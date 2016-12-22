options(echo=TRUE) # if you want see commands in output file
# Load tools for filename and MySQL methods
library(tools)
library('RMySQL')
args <- commandArgs(trailingOnly = TRUE)
# test if there are the correct number of arguments: if not, return an error
if (length(args)!=4) {
  stop("Four arguments must be supplied (input_data, input_user files, output directory and final output directory).n", call.=FALSE)
}
print(args)

input_data_file <- args[1]
input_user_file <- args[2]
output_directory <- args[3]
final_output_directory <- args[4]

# open a database connection
mydb = dbConnect(RMySQL::MySQL(), user='root', password='IiPjRf9kzaXNSdlNjQVA', dbname='tremor_app_stage', host='127.0.0.1')

# check for files in accel.R's output folder (full.names = TRUE would prepend the path to the filename)
filenames <- list.files(output_directory, pattern="*.pdf", full.names=FALSE)
print(filenames)
# if there are files in accel.R's output folder, move it to final resting place + put entry in Reports table of db
if (length(filenames) > 0){
	# filenames is a List; just take the first one, move it to the final output dir and insert it in Reports table
	final_output_file_path = paste(final_output_directory, filenames[[1]],sep="")
	print(final_output_file_path)
	file.rename(paste(output_directory, filenames[[1]],sep=""), final_output_file_path )
	# from tools library...the file exported from accel.R is {id_user}.pdf
	id_user <- file_path_sans_ext(filenames[[1]])
	print(id_user)
	now <- as.POSIXlt(Sys.time())
	now.str <- format(now,'%Y-%m-%d %H:%M:%S')
	print(now.str)
	query <- paste("INSERT INTO reports(user_id, uri, created_at) VALUES('",id_user, "','", final_output_file_path, "','",now.str,"')")
	print(query)
	# The insert query seems to return an empty data frame, so we can't see if it worked or not
	dbGetQuery(mydb, query)
}

# Now check if there's any new data to analyze (checks if test_complete = 1 but there's no report)
query <- "select u.id from users u where u.test_complete = 1 and u.id NOT IN (SELECT u.id FROM users u JOIN reports r ON u.id = r.user_id WHERE u.test_complete = 1)"
suppressWarnings(completed_users <- dbGetQuery(mydb, query))
head(completed_users)

if (!(is.data.frame(completed_users)) || nrow(completed_users)==0){
	stop("No new data to analyze.n", call.=FALSE)
}
# OK, we have something to do, let's do it!

# Get the test data for the first user
query<-paste("select t.user_id, t.posture, t.ordinal, td.accel_x, td.accel_y, td.accel_z, td.t from test_data td join tests t where td.test_id = t.id and t.user_id =", completed_users[1,1])

suppressWarnings(testData<-dbGetQuery(mydb, query))

# see what the result looks like
head(testData)

# Write the results to file in the accel.R's data input file
write.csv(testData, file = input_data_file, row.names = FALSE)

# Get the user data to go with it
query<-paste("select * from users u where u.id =", completed_users[1,1])
suppressWarnings(userData<-dbGetQuery(mydb, query))

# Write the results to file in the accel.R's user input file
write.csv(userData, file = input_user_file, row.names = FALSE)

# Now invoke accel.R to analyze the data and place the report in the output directory
# Ready to be swept up and sent to its final resting place on the next (or subsequent) run of this program.
# (This allows time for the analysis to run before we try to tidy up its results)

params = paste(input_data_file, input_user_file, output_directory)
print (params)
invoke = paste("Rscript accel.R ", params)
print (invoke)

system(invoke, wait=FALSE)
dbDisconnect(mydb)


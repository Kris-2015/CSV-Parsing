options(echo=TRUE) # if you want see commands in output file
args <- commandArgs(trailingOnly = TRUE)
# test if there is at least one argument: if not, return an error
if (length(args)!=3) {
  stop("Three arguments must be supplied (input_data, input_user files and output directory).n", call.=FALSE)
}
print(args)

input_data_file_path <- args[1]
input_user_file_path <- args[2]
output_file_folder <- args[3]

rm(args)

#example path...
#accelData <- read.csv("/Users/julian/Documents/Projects/Tremor/Data/acceleration2.csv", header=FALSE)
accelData <- read.csv(input_data_file_path, header=TRUE)
# Show what the acceleration data looks like
head(accelData)

colnames(accelData)[colnames(accelData)=="accel_z"] <- "accelz"

head(accelData)

userData <- read.csv(input_user_file_path, header=TRUE)
# Show what the user data looks like
head(userData)

# Get the user_id
user_id <- accelData[2,1]

# direct the output to our output file
output_file_path <- paste(output_file_folder, user_id, ".pdf", sep="")

pdf(output_file_path)

# draw a graph using our input data
plot(accelData$t, accelData$accelz)
title(paste("Acceleration, name = ", userData[1,2], userData[1,3]))

# delete the input file 
#file.remove(input_data_file_path)
#file.remove(input_user_file_path)

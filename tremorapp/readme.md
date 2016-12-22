#Installation Process
    
- Make sure the following apache extensions are enabled
   - mbstring
   - php-xml
   - gzip

- Make sure the mod_rewrite is enabled or not
  - To enable it, use
   sudo a2enmod rewrite

- Clone the master branch of the repository.
- Give full permission to the repository folder.
- Inside the repo give full permission to /storage and /bootstrap/cache directories
- Run 'composer update' to generate the vendor folder.
- Copy the .env.example file to .env file.
- Run 'php artisan key:generate' to generate the application key of the project.
- Update the .env file to include the server settings

Updating the virtual host setting changes for the staging site
 - Since the repo has been added inside the staging directory itself, it has to be updated to point to the public directory
 - New settings:
 
 <VirtualHost *:80>

        ServerName staging.mytremor.org
        ServerAdmin informatique@criugm.qc.ca
        DocumentRoot /var/www/staging/tremorapp_server/public

        <Directory /var/www/staging/tremorapp_server/public>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Order allow,deny
                allow from all
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>

- Database creation
- Run: php artisan migrate to create the necessary tables for the database

# MAIL INTEGRATION

- To setup the mail functionality in the project, do the following:

  - Give your email id and password
  - Give the MAIL HOST.
    Example:
      MAIL_HOST='smtp.domain_name.com'
  - Give Mail Encryption protocol

# DATABASE

- To limit the number of records to be fetched, give an LIMIT environment variable in env file.
  Example: LIMIT=10

- To remark the email has been send to user, define EMAIL_STATUS environment variable in env file.
  Example: EMAIL_STATUS=1

- To remark the report has been downloaded by the user, define DOWNLOAD_STATUS environment variable in env file.
  Example: DOWNLOAD_STATUS=2
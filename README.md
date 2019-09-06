# webdev-php-quickstart
Quick setup (php and firebase) for developing a site with account creation 


## Quick start

### Using docker
 - Create a user on firebase console using an email address
 - Locate the file `init.sql` in `/www/app/database/` and change the email adress
 - Add firebase apikey and project id in `/www/app/config.php`
 - In the firebase console go to `Authentication > Templates` edit the email verification and hit `customise action URL`. Change the ur to: `http://127.0.0.1:8080/email_verification` if running localy or replace with your server ip or domain ..etc.
 - Cd to the docker and compose:
 ```
 cd docker
 docker compose up
 ```
 

### Using own server
 - Change database config in `/www/app/database/config.php`
 - Use import the database file `/www/app/database/init.sql`
 - Follow the steps using docker except for the last one

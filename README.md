# hunt.test

To make it run:
1. Create dir hunt.test, go in.
2. docker-compose up -d
3. add hunt.test to /etc/hosts as 127.0.0.1  hunt.test
4. composer install in dir /html
5. go to phpmyadmin.test and create database "freelancehunt" or any other but change it in config file db.php
6. go to /parse.php
  In config file located in hunt.test/html/app/config/app.php i have set 10 pages to parse so it is 100 projects in total. script will create table and will fill it with api calls.

I worked with docker itself for the first time so i needed to move all files(config files, etc), not just frontend, into /html dir to not to spent more time on configs. 

to see table with paginator go to /index.php
there you will see Link which will send you to /chart.php page

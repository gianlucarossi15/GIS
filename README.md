# Geographic Information Systems 
Repository for Geographic Information Systems course for the Master Degree in Computer Engineering, curriculum Web Application and Data Engineering at the University of Padua.

## Introduction
An Italian province wants to create an information system for the management of its road network extended for about 1000 km.

## Requirements
1. PostgreSQL with the Postgis extension must be installed on the target machine.
2. Apache Web Server must be installed on the target machine.
3. Geoserver must be installed on the target machine.

## Repository structure
```
├── README.md
├── webapp --> Web Application code
├── plugins --> openJUMP plugins code
├── database --> Database SQL dump
├── latex --> Report Latex
```
## Installation guideline
### Web Application
1. Clone the repository.
2. Import the database schema by importing the [database/database.sql](database/database.sql) file present in the `database` folder.
> NOTE: The SQL file creates a database called gis and all the tables and data are present in the public schema.
4. Move the `webapp` folder to the proper `htdocs` folder in the Apache Web Server folder.
5. For the connection with the database and your web app you must change the username, password and DB name that you are using, in the [webapp/conn.php](webapp/conn.php):

```php  $conn = pg_connect("host=your_host port=5432 dbname=gis user=your_user password=your_password");```

6. After you have deployed the application using Apache Web Server, the Web Application is available at [http://localhost/web/webapp/](http://localhost/web/webapp/).

### openJUMP plugins

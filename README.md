# ScandiWeb Senior Test
### _Using MVC Structure, PHP, OOP Principles and Composer Autoloader(PS4) => BackEnd_
#### _Using HTML,CSS,JS,Jquery,AJAX and Bootstrap => FrontEnd_

## Features

- MVC Structure with implemntation of Composer Autoloader "PS4"
- Validation and Error handling specially for add product form
- Independent environment using Docker LAMP Compose "Apache, PHP 8.1, MySql"
- Apply all Task Requirements
- No Use of any framework except Bootstrap and Jquery Library in FrontEnd
- All pages Are responsive
- Only 2 REST API endpoints for product add and product get actions.


## Installation

Must Have Doker Installed already

```sh
git clone https://github.com/Phoenix-H22/ScandiWeb-Senior-Test.git
cd ScandiWeb-Senior-Test/docker-compose-lamp
docker-compose up -d
```
Visit http://localhost:808/
Visi http://localhost:8080/ to see PhpMyAdmin and project database 
## Or

You can Run it with apache or nginx server
| Requirement
| ------
| PHP 8.1
| MySql
| Apache or Nginx
| Server Root Must Be inside public folder

You will Need To configure your database connection in app/config.php file
then import the database you will find it in the root folder of the project

### Note
You won't be able to run the project if server root isn't inside public folder

## Or

Just Visit https://scandiweb.phoenixtechs.tech/ to see project live and you can see the code from the repository

## Composer Packages

| Package
| ------ 
| Autoloader (PS4) 
### This Project Done By Abdalrhman M. Alkady
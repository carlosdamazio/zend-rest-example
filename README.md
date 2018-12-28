# Simple Zend Example
This is my example of doing a REST API with Zend 3 MVC without using Zend REST Client or Server. It contains the API for a property
called "categories", and an Angular 7 app for interfacing the whole process.

## Installation
To run this project there are 2 options: using Docker Compose or running them stanalone.
To do so:
1.  Make sure you have Docker and Docker Compose;
2.  If you want the hard way, just make sure you have Composer and Npm installed.

## Docker Compose
1. <user> $ docker-compose up -d --build

Generally, this process is a bit long (building images and yarn install thou...).

With both images built and containers up and running,
 the app will be accesible through localhost, port 4200. Simple, eh?

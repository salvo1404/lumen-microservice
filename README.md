# Lumen Microservice

## **Environment Description**

This is a dockerized stack for a Lumen microservice, consisted of the following containers:
-  **microservice**, PHP application container

        PHP7.3 PHP7.3-fpm, Composer, NPM, Node.js v8.x
    
-  **mysql**, MySQL database container ([mysql](https://hub.docker.com/_/mysql/) official Docker image)
-  **mysql-test**, MySQL database container used for testing ( PHPUnit )
-  **nginx**, Nginx container ([nginx](https://hub.docker.com/_/nginx/) official Docker image)

### **Directory Structure**
```
+-- .docker
|   +-- nginx
|       +-- nginx.conf
|   +-- Dockerfile
+-- src <project root>
+-- .dockerignore
+-- .gitignore
+-- docker-compose.yml
+-- Lumen Microservice.postman_collection.json
+-- readme.md <this file>
```

### **Setup instructions**

**Prerequisites:** 

* Depending on your OS, the appropriate version of Docker Community Edition has to be installed on your machine.  ([Download Docker Community Edition](https://hub.docker.com/search/?type=edition&offering=community))

**Installation steps:** 

1. Open a new terminal/CMD, navigate to this repository root (where `docker-compose.yml` exists) and execute the following command:

    ```
    $ docker-compose up -d
    ```

    This will download/build all the required images and start the stack containers.

2. After the whole stack is up, enter the app container and install the lumen vendor libraries:

    ```
    $ docker-compose exec microservice bash
    $ composer install
    ```

2. Create a local .env and run DB migrations with seeders:

    ```
    $ cp .env.example .env
    $ php artisan migrate --seed
    ```

3. Navigate to [http://localhost](http://localhost) to access the application.

## **Microservice Description**

Microservice in Lumen Framework version v5.8.13

### **Repository Pattern**

Model-View-Repository-Controller

### **API endpoints**

The application integrates 5 API endpoints that allow the user to:

    1 List all the Players
    2 Create a new Player
    3 View a single Player information
    4 Update Player information
    5 Delete a Player

**Documentation:**

A simple API Blueprint doc is available [here](https://lumenmicroserviceapis.docs.apiary.io/)

### **Broadcasting**

When an player is added, updated or deleted, the service will broadcast the event to other microservices.
Laravel supports several broadcast drivers out of the box: Pusher Channels, Redis, and a log driver for local development and debugging.

The broadcast provider of choice is pusher.
Create an app on pusher.com to deug the functionality and your app keys to your .env 
Here s some screenshots of the broadcasted events seen through debug console in pusher.com

**Pusher.com** 

1. Create a new directory in which yo

### **Data structure**

This is the Player data structure



### **Testing**
A separate docker mysql ( mysql-test ) image is used to run Unit Tests.


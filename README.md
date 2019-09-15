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

This is a microservice built in Lumen Framework version v5.8.13

### **API endpoints**

The application integrates 5 API endpoints that allow the user to:

    1 List all the Players
    2 Create a new Player
    3 View a single Player information
    4 Update Player information
    5 Delete a Player

**Documentation:**

A simple API Blueprint doc is available [here](https://lumenmicroserviceapis.docs.apiary.io/)

### **Repository Pattern**

Model-View-Repository-Controller

### **Broadcasting**

When an player is added, updated or deleted, the service will broadcast the event to other microservices.

The implementation is based on **Pub/Sub** paradigm.
At each event, the application sends a notification message to the listeners over a "channel" ( websocket ) which contains
entity information and a status attribute ( added, updated, deleted )

This logic is built in the class PlayerPubSub ( src\app\Events\PlayerPubSub )

Lumen supports several broadcast drivers out of the box: Pusher Channels, Redis, and a log driver for local development.

**Pusher** 

If you want to use pusher as broadcast provider, create an app on [pusher.com](https://pusher.com/) and add your app keys to your .env file.
Here s some screenshots of broadcasted events seen through debug console in pusher.com

### **Data structure**

This is the Player data structure



### **Testing**
A separate docker mysql ( mysql-test ) image is used to run Unit Tests.

The testing environment variables are configured in the phpunit.xml file as well as specified in .env.testing file.

The class PlayerControllerTest ( src\tests\Feature\PlayerControllerTest ) covers PlayerController basic functionality
such as HTTPS responses to JSON API endpoints.

More Unit tests should be added to focus on PlayerRepository functions.

After each test the database is reset so that data from a previous test does not interfere with subsequent tests.
This functionality is provided by the use of the trait DatabaseMigrations which rollback the database after each test and migrate it before the next one.

To run Unit Tests from your project root, simply run 
```
    $ docker-compose exec microservice bash
    $ ./vendor/bin/phpunit
```
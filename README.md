# Lumen Microservice [![Codacy Badge](https://api.codacy.com/project/badge/Grade/426075bb8e174be4ac92ab0711706eae)](https://www.codacy.com/manual/salvo1404/lumen-microservice?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=salvo1404/lumen-microservice&amp;utm_campaign=Badge_Grade)

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
+-- doc
|   +-- Lumen Microservice.postman_collection.json
|   +-- PusherBroadcastMessage.png
|   +-- RepositoryPattern.png
+-- src <project root>
+-- .dockerignore
+-- .gitignore
+-- docker-compose.yml
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

This is a microservice built in Lumen Framework version v5.8.13.

The application handles a collection of Players and each Player is identified by name, email and a role ( basketball roles ).

Email is a unique field in Database.

### **API endpoints**

The application integrates 5 API endpoints that allow the user to:

    1 List all Players
    2 Create a new Player
    3 View a single Player information
    4 Update Player information
    5 Delete a Player

A postman collection is included [here](./doc/Lumen%20Microservice.postman_collection.json) to test the endpoints.

**Documentation:**

A simple API Blueprint doc is available [here](https://lumenmicroserviceapis.docs.apiary.io/)

### **Repository Pattern**

The Repository Pattern is one of the most popular patterns to create an enterprise level application.

In simple terms, a repository works as a mediator between the business logic layer and the data access layer of the application.

![Repository Pattern Architecture](./doc/RepositoryPattern.png? "Repository Pattern Architecture")

Using the Repository Pattern has many advantages:

- The business logic can be unit tested without data access logic;
- The database access code can be reused (e..g. to create an entity via command line or in response to an event received);
- Your database access code is centrally managed so easy to implement any database access policies, like caching;

Code structure
```
+-- app
|   +-- Console
|   +-- Events
|   +-- Http
|       +-- Controllers
|           +-- PlayerController
|   +-- Repositories
|       +-- PlayerRepository
|   .
|   .
```

### **Broadcasting**

When an player is added, updated or deleted, the service will broadcast the event to other microservices.

The implementation is based on **Pub/Sub** paradigm.

At each event, the application sends a notification message to the listeners over a "channel" ( websocket ) which contains
entity information and a status attribute ( added, updated, deleted ).
```$xslt
{
  "player": {
    "name": "Charles Smith",
    "role": "Point Guard",
    "email": "charles.smith@gmail.com",
    "updated_at": "2019-09-15 07:56:10",
    "created_at": "2019-09-15 07:56:10",
    "id": 26
  },
  "status": "created"
}
```

This logic is built in the class PlayerPubSub ( src\app\Events\PlayerPubSub )

Lumen supports several broadcast drivers out of the box: Pusher Channels, Redis, and a log driver for local development.

**Pusher** 

If you want to use pusher as broadcast provider, create an app on [pusher.com](https://pusher.com/) and add your app keys to your .env file.
Then change your BROADCAST_DRIVER value to be 'pusher'.

![Pusher Broadcast Message](./doc/PusherBroadcastMessage.png? "Pusher Broadcast Message")


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
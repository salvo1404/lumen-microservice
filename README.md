# Lumen Microservice

## **Environment Description**

This is a dockerized stack for a Lumen microservice, consisted of the following containers:
-  **microservice**, PHP application container

        PHP7.3 PHP7.3-fpm, Composer, NPM, Node.js v8.x
    
-  **mysql**, MySQL database container ([mysql](https://hub.docker.com/_/mysql/) official Docker image)
-  **mysql-test**, MySQL database container used for testing ( PHPUnit )
-  **nginx**, Nginx container ([nginx](https://hub.docker.com/_/nginx/) official Docker image)

#### **Directory Structure**
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
    $ docker exec -it microservice bash
    $ composer install
    ```

2. Create a local .env and run DB migrations with seders:

    ```
    $ cp .env.example .env
    $ php artisan migrate --seed
    ```

3. Navigate to [http://localhost](http://localhost) to access the application.

**Default configuration values** 

The following values should be replaced in your `.env` file if you're willing to keep them as defaults:
    
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=appdb
    DB_USERNAME=user
    DB_PASSWORD=myuserpass
    
## **Microservice Description**

This is a dockerized stack for a Lumen microservice, consisted of the following containers:
-  **microservice**, PHP application container

        PHP7.3 PHP7.3-fpm, Composer, NPM, Node.js v8.x
    
-  **mysql**, MySQL database container ([mysql](https://hub.docker.com/_/mysql/) official Docker image)
-  **mysql-test**, MySQL database container used for testing ( PHPUnit )
-  **nginx**, Nginx container ([nginx](https://hub.docker.com/_/nginx/) official Docker image)

#### **Directory Structure**
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

1. Create a new directory in which yo
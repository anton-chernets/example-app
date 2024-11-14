Example App:
http://37.27.81.184/
http://37.27.81.184/horizon/dashboard

Docker Installation Using Sail
[https://laravel.com/docs/11.x/installation#docker-installation-using-sail](https://laravel.com/docs/11.x/installation#docker-installation-using-sail)

Sail on macOS:
If you're developing on a Mac and Docker Desktop is already installed.

```
cd example-app
./vendor/bin/sail up
./vendor/bin/sail artisan migrate
```

Sail on Windows:
Before we create a new Laravel application on your Windows machine, make sure to install Docker Desktop.

```
cd example-app
./vendor/bin/sail up
./vendor/bin/sail artisan migrate
```

Sail on Linux
First, if you are using Docker Desktop for Linux, you should execute the following command. If you are not using Docker Desktop for Linux, you may skip this step:

```
docker context use default
cd example-app
./vendor/bin/sail up
./vendor/bin/sail artisan migrate
```

Finally, you can access the application in your web browser at: http://localhost.

Tests

```bash
php artisan test
```

## How to install and run Rapier

To install and run Rapier application you must have installed:

- Post or related
- PHP ^7.0
- Composer
- Bower

Before installing the application you must run your pg database :

```shell
$ postgres -D /usr/local/pgsql/data
```

Then run the commands:

```shell
$ composer create-project fedotovaleksandr/rapier rapier "dev-master"
$ cd rapier
$ composer install
$ bower install
$ php bin/console doctrine:database:create --if-not-exists
$ php bin/console doctrine:schema:create
$ php bin/console fos:user:create --super-admin
$ php bin/console server:run 127.0.0.1 --env=dev

```

After sucessfully running all commands navigate to:

```
http://127.0.0.1
```

### Docker (recomended way)

Install docker engine first. Then run the commands in the terminal:

```shell
$ docker-compose build
$ bash bin\docker_install.sh
$ docker-compose up -d
$ docker-compose ps
```


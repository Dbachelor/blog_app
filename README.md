# configuration
    - Environment
        -- PHP 8.2
        -- symfony 6.3

# How to run app
    -Create a db by the name of blog
    -configure .env file to reflect the right credentials for your db i.e username and password should be changed to yours. The default value in the .env file is root as username and mysql as password.
    -run composer install
    -run php bin/console make:migrations
    -run php artisan doctrine:migrations:migrate
    -run php bin/console doctrine:fixtures:load   -- this will load the tables in the db with dummy data if this command fails pls run the below before running it again
    -composer require --dev doctrine/doctrine-fixtures-bundle

# /posts Endpoint
    - open postman or browser and visit {{BASEURL}}/posts to get the first 10 records
    - you can paginate by adding a url param ?page=2
    - you can search for keywords this way ?search=Summer
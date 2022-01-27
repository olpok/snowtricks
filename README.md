# snowtricks

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/65c4443464ab42df803e85faa9c864d7)](https://app.codacy.com/gh/olpok/snowtricks?utm_source=github.com&utm_medium=referral&utm_content=olpok/snowtricks&utm_campaign=Badge_Grade_Settings)

About the project

Development of a snowboard community site
Requirements

PHP 7.4
Symfony 5.4
MySQL
Composer 2.1 

1. Clone the repository: https://github.com/olpok/snowtricks.git
2. Install dependencies: composer install
3. Create a .env.local file at the root of the project
4. Copy .env code and past in .env.local
5. Modify the line DATABASE_URL= with your login/password and your database name.
6. Create the database: php bin / console doctrine: database: create
7. Run first php bin/console make:migration then run php bin/console doctrine:migrations:migrate
8. Run php bin/console doctrine:fixtures:load
9. Start the internal server:  php bin / console server: start

Enjoy!

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/dbf7885b159b47b3ab2977a3d7b55ce3)](https://www.codacy.com/gh/olpok/snowtricks/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=olpok/snowtricks&amp;utm_campaign=Badge_Grade)

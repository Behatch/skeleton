# Behat Custom Helper

This repository's purpose is to share our custom Behat Definitions and provide a
quick startup for any Project.

## Installation

    $ git clone https://github.com/sanpii/BehatCH.git
    $ cd BehatCH
    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar install
    $ ./bin/behat --tags=github

## Running BehatCH tests

Download selenium2 server (<http://seleniumhq.org/download/>) and start it:

    $ java -jar selenium-server-standalone-2.24.1.jar

Setup a web server on fixtures/www:

    $ php -S localhost:8080 -t fixtures/www

Copy the default configuration file:

    $ cp behat.yml{-dist,}

Run the tests:

    $ ./bin/behat

## Credits

Please support Behat, Mink, PHPUnit and their contributors :

* https://github.com/Behat/Behat
* https://github.com/Behat/Mink
* https://github.com/sebastianbergmann/phpunit

Icons included are Gnome Project property : http://iconfinder.com/search/?q=iconset%3Agnome-desktop-icons-png

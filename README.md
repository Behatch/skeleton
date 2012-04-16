# Behat Custom Helper

This repository's purpose is to share our custom Behat Definitions and provide a quick startup for any Project.

## Usage

1. Clone BehatCH
2. Run "curl -s http://getcomposer.org/installer | php"
3. Run "php composer.phar install"
4. Run "./vendor/bin/behat --tags=github" inside BehatCH directory
5. ???
6. Profit !

## Running BehatCH tests

BehatCH is auto testing itself providing you follow these steps :

1. Copy *behat.yml-dist* as *behat.yml*
2. Setup an Apache Virtual Host so that you can access to *BehatCH/fixtures/www* (ex *http://localhost/BehatCH*), see below for a Virtual Host example.
3. Update *behat.yml* with BehatCH root directory in *filesystem\root*
4. Update *behat.yml* with your Virtual Host in *base_url*
5. Run "php behat.phar"

## Apache Virtual Host example

```
Alias /BehatCH /path/to/your/workspace/BehatCH/fixtures/www

<Directory "/path/to/your/workspace/BehatCH/fixtures/www">
    AllowOverride All
    Allow from All
</Directory>
```

## Credits

Please support Behat, Mink, PHPUnit and their contributors :

* https://github.com/Behat/Behat
* https://github.com/Behat/Mink
* https://github.com/sebastianbergmann/phpunit

Icons included are Gnome Project property : http://iconfinder.com/search/?q=iconset%3Agnome-desktop-icons-png

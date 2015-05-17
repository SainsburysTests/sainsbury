Synopsis

Sainburys cli app to scrape a website and prints the json scraped and processed to screen

Run Console Application
./app/console sainsburys:scrape


Used symfony 2
1. RestBungle
composer.phar require "friendsofsymfony/rest-bundle" "@dev"
2. Command Bundle
composer.phar require "symfony/console"
3. writeable folder for crawler cookies "/tmp"

API Reference
execution
sainsburys:scrape  ./app/console sainsburys:scrape
source 
/src/SainsburysBundle

Tests
cd /tests
phpunit

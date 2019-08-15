#!/usr/bin/env bash
rm -R docs/
mkdir docs/
php ./vendor/bin/phpcs --report=xml > .reports/phpcs.xml
phpmd ./src,./tests xml phpmd.xml > ./.reports/phpmd.xml
mkdir docs/pmd/
phpmd ./src,./tests html phpmd.xml > ./docs/pmd/pmd.html
phpdox
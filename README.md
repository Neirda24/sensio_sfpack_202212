SF6 Start & SF6 Master
======================

This repository is for training purposes.
See the Pull Request section for each steps of the SFPack training.

# Requirements
* [symfony](https://symfony.com/download) `>=5.4`
* PHP `>=8.1`
  * `pdo_sqlite`

# Install
```shell
$ git clone git@github.com:Neirda24/sensio_sfpack_202212.git --branch main
$ cd ./sensio_sfpack_202212/
$ symfony composer install
$ symfony serve -d
```

# How was it generated ?

[![asciicast](https://asciinema.org/a/ggiYi4uWbVl1XyRklxosCzP44.svg)](https://asciinema.org/a/ggiYi4uWbVl1XyRklxosCzP44)

# Exercices

SFStart
* [01 - Controllers](./doc/01-sfstart/01-controllers.md)
* [02 - Tests](./doc/01-sfstart/02-tests.md)
* [03 - Twig / Create a template](./doc/01-sfstart/03-twig.md#exercise-03---create-a-template)
* [04 - Twig / Make the navbar dynamic](./doc/01-sfstart/03-twig.md#exercise-04---make-the-navbar-dynamic)
* [05 - Webpack Encore](./doc/01-sfstart/05-encore.md)
* [06 - Configure Doctrine](./doc/01-sfstart/06-doctrine.md#exercise-06---configure-doctrine)
* [07 - New Entities with doctrine](./doc/01-sfstart/06-doctrine.md#exercise-07---new-entities)
* [08 - Fetch from the database with doctrine](./doc/01-sfstart/06-doctrine.md#exercise-08---fetch-from-the-database)
* [09 - Leverage the entities relationships](./doc/01-sfstart/06-doctrine.md#exercise-09---create-entities-relationships)
* [10 - Forms](./doc/01-sfstart/10-forms.md#exercise-10---create-and-display-a-form)
* [10 - Form validation](./doc/01-sfstart/10-forms.md#exercise-11---add-validation-to-the-form)

Exercise 02 - Create a smoke test
=================================

1. Write a smoke test to cover your controller.

# Steps
```shell
$ symfony console make:test

 Which test type would you like?:
  [TestCase       ] basic PHPUnit tests
  [KernelTestCase ] basic tests that have access to Symfony services
  [WebTestCase    ] to run browser-like scenarios, but that don\'t execute JavaScript code
  [ApiTestCase    ] to run API-oriented scenarios
  [PantherTestCase] to run e2e scenarios, using a real-browser or HTTP client and a real web server
 > WebTestCase


Choose a class name for your test, like:
 * UtilTest (to create tests/UtilTest.php)
 * Service\UtilTest (to create tests/Service/UtilTest.php)
 * \App\Tests\Service\UtilTest (to create tests/Service/UtilTest.php)

 The name of the test class (e.g. BlogPostTest):
 > Controller\HelloControllerTest

 created: tests/Controller/HelloControllerTest.php


  Success!


 Next: Open your new test class and start customizing it.
 Find the documentation at https://symfony.com/doc/current/testing.html#functional-tests
```

See it in action :

[![asciicast](https://asciinema.org/a/4suw7I1xnzh5dxc7naJAC72pc.svg)](https://asciinema.org/a/4suw7I1xnzh5dxc7naJAC72pc)

Then write your test in `./tests/Controller/HelloControllerTest.php`.

You can execute them like so :
```shell
$ symfony php ./vendor/bin/phpunit
$ # Or to leverage the dataproviders :
$ symfony php ./vendor/bin/phpunit --testdox 
```

See it in action :

[![asciicast](https://asciinema.org/a/jMnRy5HnO5KAG5k8WpPljy7z0.svg)](https://asciinema.org/a/jMnRy5HnO5KAG5k8WpPljy7z0)

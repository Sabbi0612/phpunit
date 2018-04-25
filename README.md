# Test-Driven Development Using Phpunit

## Lets understand Unit Testing

A classic definition of unit testing, states that unit testing is a software testing method by which individual units of source code, sets of one or more computer program modules together with associated control data, usage procedures, and operating procedures, are tested to determine whether they are fit for use. 

*So this is what Wikipedia says, pretty awesome huh..*

Lets try to break it down to understand better.

**Unit Testing is -**
* An idea of testing isolated units of code to ensure the code meets some parameters. 
* Typically that it correctly performs as expected. 
* Isolated unit of code - (a single function or method) the smallest unit of code that can be independently run and operated. 

## Then!! What is Test-Driven Development?

*"Test-driven development"* refers to a style of programming in which three activities are tightly interwoven: coding, testing (in the form of writing unit tests) and design (in the form of refactoring).

**Some Good reads on TDD -**
* [TDD by Agile Alliance](https://www.agilealliance.org/glossary/tdd)
* [Realising quality improvement through TDD 2008 (Paper by : Pankaj Jalote)](https://people.engr.ncsu.edu/gjin2/Classes/591/Spring2017/case-tdd-b.pdf)

## TDD Pattern
![TDD pattern][Tdd-pattern]



### Significance of following TDD for a developer

TDD is one the biggest things, you as a developer and software engineer can do to level up yourself. It takes you from a style of manual refreshing, testing and looking at things to figure out if something worked to instead validating your software and proving it works the way it’s intended.

## Installing PHPUnit

### Requirements
* PHP 5.6+
* Composer ([To download and install composer](https://getcomposer.org/download/))

### Steps to Install PHPUnit via composer
* First we need to create a new ‘composer.json' file in our main project directory. (In my case it was phpunit)
* Copy the below content and paste it inside for the **composer.json** file.

```json
{
    "require-dev": {
        "phpunit/phpunit": "^5.5"
    },
    "autoload": {
        "psr-4": {
            "TDD\\": "src/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "TDD\\Test\\": "tests/"
        }
    }
}
```

* We can change the phpunit version as per our requirements.
* Go to the terminal and move to your project directory.
* Run the command ‘composer install’
* Wait for the process to be completed and when its done we should have a version of phpunit installed on our system.
* To check the version of the phpunit installed, run the command 'vendor/bin/phpunit --version'
* Expected output is like - `PHPUnit x.x.xx by Sebastian Bergmann and contributors.`

**_Hurray!! We are done with our Installation._**

**_Before we move forward to write our first Unit test, we need to have some bit of knowledge of Object-Oriented PHP w.r.t concepts like namespaces, instantiation etc._**

## Let's write our first Unit Test

First of all we need a simple piece of code that we want to test. This file can be found by following **src/Receipt.php** in this repo.

```php
<?php
namespace TDD;

class Receipt {
	public function total (array $items = []) {
		return array_sum($items);
	}
}
```

Where we have this receipt class which contains a function total where we take an array of items with a default of an empty array and return the array sum of those items.

Now to test this piece of code we need to add a **tests** directory, and add all our tests there. For this code in particular we will create a ReceiptTest.php file where our code will look like below - 

```php
namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase {
	public function testTotal() {
		$Receipt = new Receipt();
		$this->assertEquals(
			15,
			$Receipt->total([0,2,5,8]),
			'When summing the total should equal 15'
		);
	}
}
```

















#### This Repo and it's content is inspired by the LinkedIn Learning course **PHP: Test-Driven Development with PHPUnit
 by Justin Yost**


[Tdd-pattern]: https://github.com/Sabbi0612/phpunit/blob/master/images/Tdd-pattern1.png
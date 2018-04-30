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

## First Unit Test

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

Where we have this receipt class which contains a function total where we take an array of items with a default of an empty array and return the array sum of those items. Here `array_sum` is a native php method.

Now to test this piece of code we need to add a **tests** directory, and add all our tests there. In general, we will have a pretty **_simple one-to-one ratio. For every class created, a corresponding test class will exist_**. For this code in particular we will create a ReceiptTest.php file where our code will look like written below - 

```php
<?php
namespace TDD\Test;
// The below line states to require starting from the root directory, go to the vendor directory, and then require the autoload.php file from there. After this, we can use the PHP TestCase class and our Receipt class and then write our first test class.
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';
 
// This imports the PHPUnit core class 'TestCase' for our use.
use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase {
	public function testTotal() {
		$Receipt = new Receipt(); // instantiation
		// assertEquals asserts that two values are equal.
		$this->assertEquals(
			15,
			$Receipt->total([0,2,5,8]),
			'When summing the total should equal 15'
		);
	}
}
```
**Important Note:** 
The assertion methods typically follow a similar pattern: three inputs. First is the _expected value, _second is the actual value, and, finally, a message displayed in the case of a failure._
So in the above piece of code: 15 will be expected value, The 0,2,5,8 are the actual values in the array and "When summing the total should equal 15" is the message to displayed when condition is failed.

TO know about the tons of other PHPUnit assertions and their usage, Go to [this link](https://phpunit.de/manual/6.5/en/appendixes.assertions.html)

### Let's Run our Test
To run the test - 
* We need to simply go to the Terminal(Mac/Linux) or Command Prompt(Windows) and navigate to our phpunit directory.
* Write the command `vendor/bin/phpunit tests` (We'll learn to write commands specific to a file a bit later)
* This command will run all thse test files inside the **tests** directory.

### Results 
If the Expected value is not equal to the actual value (after summing up the elements of the array), then it will display the following report in the Terminal.

![Test Failed][Test-Failed]

If the Expected value equals the actual value then the below result will be displayed. 

![Test Passed][Test-Passed]



Since Now we have created our first unit test, its time to *Refactor* our test.
Going a bit deeper into writing Unit test we follow a certain pattern of **_Arrange-Act-Assert_**

### What is Arrange-Act-Assert Pattern?
* **_Arrange_** is where we arrange all the necessary preconditions and inputs for our test case. After this,
* **_Act_** we act on the object or method we are testing i.e. actually call the thing we want to test. And finally, 
* we finish up with an **_Assertion_** that the expected results have occurred.

### Some general rules to follow while writing unit tests
* Always follow the basic pattern of Arrange-Act-Assert in all of the tests we write,
* Our test should happen in isolation as much as possible.
* We should write tests that focus on writing a single method that does only one thing.
* Our test should also test only a few things at once
* Finally, if we find yourself having a lot of trouble with writing a test, that may be a hint to we need to look at our implementation and find a new solution. 

### Let's refactor our previous Test in this pattern
After refactoring our code will look like this. (Read code comments for better understanding)

```php
<?php
namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase {
	public function setUp() {
		$this->Receipt = new Receipt();
	}

	public function tearDown() {
		unset($this->Receipt);
	}
	public function testTotal() {
		$input = [0,2,5,8];                        // Arrange
		$output = $this->Receipt->total($input);   // Act
		$this->assertEquals(                       // Assert
			15,
			$output,
			'When summing the total should equal 15'
		);
	}
}
```

Here the two methods, `setUp` and `tearDown` are the ones that are called by PHPUnit before every test method.
* **setUp** permits us to create instances of classes or anything else that we need before running our test method and
* **tearDown** lets us remove any of those instances to ensure our tests are running in isolation.


### So overall this is how our Unit test has been refactored - 

![Code-Refactored][Code-Refactored]

This was all aligned more towards Unit Testing..


## Let's Practice Test Driven Development Now!!

Lets make more changes to the same ReceiptTest.php and Receipt.php files only.

### Step 1: Write a Failing Test
Extending the previous `ReceiptTest.php` file we write one more method `testTax` to test calculating the tax for a receipt, by following the same Arrange-Act-Assert pattern which makes our file look like this.

```php
<?php
namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase {
	public function setUp() {
		$this->Receipt = new Receipt();
	}

	public function tearDown() {
		unset($this->Receipt);
	}
	public function testTotal() {
		$input = [0,2,5,8];
		$output = $this->Receipt->total($input);
		$this->assertEquals(
			15,
			$output,
			'When summing the total should equal 15'
		);
	}

	public function testTax() {
		$inputAmount = 10.00;
		$taxInput = 0.10;
		$output = $this->Receipt->tax($inputAmount, $taxInput);
		$this->assertEquals(
			1.00,
			$output,
			'The tax calculation should equal 1.00'
		);
	}
}
```

### Step 2: Run the Test via terminal
As we expect, our Test is going to fail and the error displayed in the below screenshot will be displayed.

![Dry-Run][Dry-Run]

As stated by the error recieved in the screenshot, our test has failed due to calling an undefined function, hence now to make this test pass we'll have to add this tax function our source code.

### Step 3: Code/Refactor to make the Test Pass
So here we add a new method `tax` where this tax method needs to take two inputs. First an amount, and second a tax.

Let's run our test one more time and see what we get. 

![Dry-Run-2][Dry-Run-2]

The test still fails, but this time because we returned null instead of our expected value of 1.00. 
So now, we can calculate the tax amount. To do so, we'll go back to our editor, and we can add return, and in parenthesis, amount times our tax.

Re-run the Test. Wallahh.. 

![Code-Passed][Code-Passed]

It passes this time and in this way we have written our first piece of code in Test-Driven Development Fashion.

So now our Code in Receipt.php looks like this

```php
<?php
namespace TDD;

class Receipt {
	public function total(array $items = []) {
		return array_sum($items);
	}

	public function tax($amount, $tax) {
		return ($amount * $tax);
	}
}
```

## Filter out Test Execution

You might have observed till now that during this whole time we have been running all the tests that were a part of the directory `/tests`. It worked fine as we had only two tests in particular in this directory.

Imagine if we had a huge number of tests being written by different members of the team in a much larger project. This would become a really tedious job for us to run all the tests and wait for the execution of just the one that we are working on.

So to solve this problem PHPUnit gives us the option to filter out and run only a specific tests with the help of the commands that we execute into our Terminal or Command prompt.

### Examples: 
* **Run the full test suite**
```vendor/bin/phpunit dirname```  where dirname is the name of the test-suite directory in which all our tests are contained.
For our previous test the command would look like - **_vendor/bin/phpunit tests/_**

* **Run the tests present in a single test file**
```vendor/bin/phpunit dirname/filename.php```
For our previous test the command would look like - **_vendor/bin/phpunit tests/RecieptTest.php_**


* **Run a test related to particular method or class**
```vendor/bin/phpunit --filter=string``` 
This string is going to be a *regular expression match against classes, methods, and name spaces*. To run our previous test we'll pass in the method name testTax. When we execute this, we'll see that we only have one test executed, our testTax method.
So the commands would look like this - 
**_vendor/bin/phpunit --filter=testTax_** or **_vendor/bin/phpunit --filter=ReceiptTest::testTax_**

* **Run tests based on a PHPUnit.xml file**
It also allows us to no longer have to specify the directory to look for tests in. Instead the XML file acts as a basic configuration file for us. We can view it's contents in **_phpunit.xml_** file in the main phpunit directory of this repo.
This phpunit.xml file will allow us to directly run the command **_vendor/bin/phpunit_** and will then execute the tests based on the configurations done in the file. Through this file we have options to run particular test suites, exclude files and even add colors to the execution results in our terminal. See below - 

![Php-Unit-xml-exec][Php-Unit-xml-exec]






























#### This Repo and it's content is inspired by the LinkedIn Learning course PHP: Test-Driven Development with PHPUnit by Justin Yost


[Tdd-pattern]: https://github.com/Sabbi0612/phpunit/blob/master/images/Tdd-pattern1.png
[Test-Failed]: https://github.com/Sabbi0612/phpunit/blob/master/images/Test-Failure.png
[Test-Passed]: https://github.com/Sabbi0612/phpunit/blob/master/images/Test-Passed.png
[Code-Refactored]: https://github.com/Sabbi0612/phpunit/blob/master/images/Code-Refactored.png
[Dry-Run]: https://github.com/Sabbi0612/phpunit/blob/master/images/Dry-Run.png
[Dry-Run-2]: https://github.com/Sabbi0612/phpunit/blob/master/images/Dry-Run-2.png
[Code-Passed]: https://github.com/Sabbi0612/phpunit/blob/master/images/Code-Passed.png
[Php-Unit-xml-exec]: https://github.com/Sabbi0612/phpunit/blob/master/images/Php-Unit-xml-exec.png
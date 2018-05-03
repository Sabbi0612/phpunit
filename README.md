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
For our previous test the command would look like - **_vendor/bin/phpunit tests/ReceiptTest.php_**


* **Run a test related to particular method or class**
```vendor/bin/phpunit --filter=string``` 
This string is going to be a *regular expression match against classes, methods, and name spaces*. To run our previous test we'll pass in the method name testTax. When we execute this, we'll see that we only have one test executed, our testTax method.
So the commands would look like this - 
**_vendor/bin/phpunit --filter=testTax_** or **_vendor/bin/phpunit --filter=ReceiptTest::testTax_**

* **Run tests based on a PHPUnit.xml file**
It also allows us to no longer have to specify the directory to look for tests in. Instead the XML file acts as a basic configuration file for us. We can view it's contents in **_phpunit.xml_** file in the main phpunit directory of this repo.
This phpunit.xml file will allow us to directly run the command **_vendor/bin/phpunit_** and will then execute the tests based on the configurations done in the file. Through this file we have options to run particular test suites, exclude files and even add colors to the execution results in our terminal. See below - 

     ![Php-Unit-xml-exec][Php-Unit-xml-exec]


## Test Doubles
It is a generic term for any case where we replace the production object for testing purposes.
For more information on test doubles follow [this link](https://www.martinfowler.com/bliki/TestDouble.html)

When someone is talking about a test double, they're referring to the generic term for a variation of one of these five different objects. Each of these is designed to solve different variations of our three main reasons for using a test double. These are - 
* **Dummy**: Replaces an object typically as an input to a method, that isn't used or needed for the test.
* **Fake**: Replaces an object in which we need a simplified version of the object, typically to achieve speed improvements or eliminate side effects.
* **Stub**: Provides a preset answer to method calls that we have decided ahead of time.
* **Spy**: Acts as a higher level stub as it allows us to also record information about what happened with this test double.
* **Mock**: It acts as a higher level stub as they are pre-programmed with expectations, including the ability to both respond to the calls they know about and don't know about.

**_So this becomes really important to note what problem we are attempting to solve and focus on building a double that meets that requirement._**
We'll discuss about these in detail further in the documentation.

### Three main reasons for using a Test Double
* **Replace a dependency** - Our test doubles replace portions of our 'in-use' dependencies, or inputs, 
* **Ensure a condition occurs** - To ensure we can test our code in isolation and have complete coverage.
* **Improve the test performance** - Focus on just the single unit or method at hand.


### Build a "Dummy" Object
Since we know a dummy object is an object or value that has no use in our method under test, but is needed for the signature.
So we can go back to our ReceiptTest.php file and add coupon variable as a second input and assign it a value null so the NULL value will be our DUMMY object. if we run this through the Terminal, our test will pass as **php doesn't care that we passed an extra input to our total method.**

**Now let's see how assigning some value to coupon variable will affect our test**

File changes made are as shown in the below screenshot - 

![Dummy-Object][Dummy-Object]

On executing this, it will give us a **failing test**. 

![Dummy-Test-Object-Fails][Dummy-Test-Object-Fails]

Hence, we need to make following changes to our **Receipt.php** file as well. The Receipt.php File would finally look like this as shown below in Screenshot

![Dummy-Object-Passed][Dummy-Object-Passed]

Let's go back to our terminal and rerun our test, 
We'll see that we're back to our full list of greens. So, this is how easy it is to use a dummy object. Notice, it does not have to be anything complex or anything extensive. It just needs to be something that has no actual use in our method under test, but is simply needed for this signature to pass.

### Building Test Stubs
As explained earlier, Stubs in PhpUnit provides a preset answer to method calls that we have decided ahead of time.

Here's how we create a Test Stub in PHPUnit. **(Please read through the Notes in the code for better understanding**

```php
	/** 
	* Our test here will build a mock instance of the Receipt class so we can 
	* replace the instance we are using and instead call it, and then return 
	* the sum from the two calls to the other methods, 
	* so we're testing this in isolation.
	*/
	public function testPostTaxTotal() {
		$Receipt = $this->getMockBuilder('TDD\Receipt')
			->setMethods(['tax', 'total'])
			->getMock();
		$Receipt->method('total')
			->will($this->returnValue(10.00));
		$Receipt->method('tax')
			->will($this->returnValue(1.00));
		$result = $Receipt->postTaxTotal([1,2,5,8], 0.20, null);
		$this->assertEquals(11.00, $result);
	} 
```

### Understanding the code
* Write **_$this->getMockBuilder_** and then pass in the string with the namespace name of the class that we want to build. In this case, **TDD\Receipt**. The only builder PHPUnit provides is a MockBuilder, but we can ignore some of the specific features of a mock test class and instead use it to **build out a stub**. Next, we need to define the **methods our stub** will respond to, so we'll add, - >setMethods(). 
* **_setMethods_** call takes an array of methods for the test double to respond to. In this case, it will respond to the method calls for tax and total, so we'll add those two strings to an array as the parameter for setMethods.
* At this point, we can now return the instance of the mock with a call to **_getMock_**
* So now we'll need our doubles saved to a local variable, so we'll modify the first line and set it to a local $Receipt variable. So it makes our code be  - ```$Receipt = $this->getMockBuilder('TDD\Receipt')```

**(Now after this, we'll update our stub to respond to our two method calls for tax and total and then inform them to return the data that we want them to.)**
* To do so, we will add **_$Receipt->method_** and then pass in the string name of the method that we want to define what exactly our stub will perform. In this case, we'll pass in total.
* After this, we then call a method **_will_**. This method will simply says what exactly will that stubbed method do. In this case, this method will return a value equal to 10.00. So, we will do ```$this->returnValue(10.00)```
* We now to repeat this for our tax method, which our tax method will return 1.00, so we'll add ```$Receipt->method('tax')```
* Finally, we can repeat the pattern that we've seen in the past. We call the method and assert the result is what we expect. We add **_$result is equal to our $Receipt instance - >postTaxTotal_** with an array and then pass in the value 0.20 and then null.
* Notice we are using values that wouldn't actually make sense given what our stub is returning. This is going to assure you that the stub is returning that stubbed result.

Now that we understood that what's there in our test we run our test.

![Test-Stub][Test-Stub]

As expected the test has failed. So to make our test pass, we'll add the code below at the end of our Receipt.php file.

```php

	public function postTaxTotal($items, $tax, $coupon) {
		$subtotal = $this->total($items, $coupon);
		return $subtotal + $this->tax($subtotal, $tax);
	}
```
Now run the test again and see it PASSED. This is how easy and quick it is to use a stub to replace some basic methods inside of your classes that you're testing.

![Stub-Test-Passed][Stub-Test-Passed]

## Build a Test Mock 
In this we'll be converting our stub into a mock. We'll make changes to our existing testPostTaxTotal function in the ReceiptTest.php file only.

Note: The main difference between a plain stub and a mock is that mock has expectations about what stub methods are called and the inputs to that stub.

See how the code changes from a Plain Stub to a Mock.

![Mock-Code][Mock-Code]

### Understanding the Code.
* We'll first modify our test for the post tax total method to use a predefined value for the items, tax, and coupon.
hence, 
```php
		$items = [1,2,5,8];
		$tax = 0.20;
		$coupon = null;
```
* We will now modify our stub to set up expectations for both the number of times we will call our mark methods as well as what inputs to expect. So we add before our method call, we add ```$Receipt->expects($this->once())```. 
**Note: There are lots of ways in which we can define this expects including at least once, exactly, passing in some integer value and never.**
* After this, we can ensure we get passed the correct parameters to our total method call. We can add ```->with($items, $coupon)```. 
* And just like this we turned our stub into a mock.
* We'll now modify the setup for the **tax** call to do the same thing.
* Now we can run our test and see if anything changed.

![Mock-Code-Test][Mock-Code-Test]

**_Notice we now have five assertions for our four tests. This is because our mock is now a new assertion. Our mock setup has to fully pass. The methods are only called once and their methods have the correct inputs.
This is one of the reasons mocks are widely used. It allows you to assert that the inputs to those methods that you're mocking are exactly correct._**


## Write an Exception-based Test
Exceptions are a common way of throwing errors to the user, or to other parts of your application, to then register that a failure occurred and to then understand how to handle those particular cases.

Here we'll assert that an exception is thrown.

Here's what is code is added to our ReceiptTest.php file.
```php
	public function testTotalException() {
		$input = [0,2,5,8];
		$coupon = 1.20;
		$this->expectException('BadMethodCallException');
		$this->Receipt->total($input, $coupon);
	}
```

### Understanding the Code
* Since we have no output to test this time, So we start with assigning values to the $input and $coupon.
* Now in the 4th line, we can test for the exception directly, by using the PHP Unit Method, **_expectException_**. This method takes the class name of the exception that it expects.
Note: There are also corresponding methods available to test for the expected exception message, and corresponding code.

**_Run the test to see it fail._**

So it is time to edit our source code accordingly.

![Exception-Test][Exception-Test]

* We have imported the \BadMethodCallException into our namespace.
* Logic: We can add if coupon is greater than 1.00, after all, we may want to allow a 100% off coupon in certain cases.
* Run the Test again.
* This time the test passes.

So this is how we work with exceptions and write tests for them accordingly.

## Code Coverage in PhpUnit
Code Coverage is a measure of how much or rather what percentage of lines in our codebase is covered by our test. In short, it tells us these lines were run and for what particular test. 
The isolation of our test permits us to see the coverage of our code; simply, as the code we run based on the particular test for that particular method. 

**Question:** "Is there a magic number at which I've solved all of my prompts with bugs and other issues?
**Answer:** There just isn't a magic percentage of code coverage that will solve all of your problems, but code coverage is still the best measure we have for producing well-tested code.

### Generate Code Coverage Reports
We can generate code coverage in two basic forms: an **HTML version** and an **XML version**





#### This Repo and it's content is inspired by the LinkedIn Learning course PHP: Test-Driven Development with PHPUnit by Justin Yost


[Tdd-pattern]: https://github.com/Sabbi0612/phpunit/blob/master/images/Tdd-pattern1.png
[Test-Failed]: https://github.com/Sabbi0612/phpunit/blob/master/images/Test-Failure.png
[Test-Passed]: https://github.com/Sabbi0612/phpunit/blob/master/images/Test-Passed.png
[Code-Refactored]: https://github.com/Sabbi0612/phpunit/blob/master/images/Code-Refactored.png
[Dry-Run]: https://github.com/Sabbi0612/phpunit/blob/master/images/Dry-Run.png
[Dry-Run-2]: https://github.com/Sabbi0612/phpunit/blob/master/images/Dry-Run-2.png
[Code-Passed]: https://github.com/Sabbi0612/phpunit/blob/master/images/Code-Passed.png
[Php-Unit-xml-exec]: https://github.com/Sabbi0612/phpunit/blob/master/images/Php-Unit-xml-exec.png
[Dummy-Object]: https://github.com/Sabbi0612/phpunit/blob/master/images/Dummy-Object.png
[Dummy-Test-Object-Fails]: https://github.com/Sabbi0612/phpunit/blob/master/images/Dummy-Test-Object-Fails.png
[Dummy-Object-Passed]: https://github.com/Sabbi0612/phpunit/blob/master/images/Dummy-Object-Passed.png
[Test-Stub]: https://github.com/Sabbi0612/phpunit/blob/master/images/Test-Stub.png
[Stub-Test-Passed]: https://github.com/Sabbi0612/phpunit/blob/master/images/Stub-Test-Passed.png
[Mock-Code]: https://github.com/Sabbi0612/phpunit/blob/master/images/Mock-Code.png
[Mock-Code-Test]: https://github.com/Sabbi0612/phpunit/blob/master/images/Mock-Code-Test.png
[Exception-Test]: https://github.com/Sabbi0612/phpunit/blob/master/images/Exception-Test.png
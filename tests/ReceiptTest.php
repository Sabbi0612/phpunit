<?php
namespace TDD\Test;
/**
* The below line states to require starting from the root directory, 
* go to the vendor directory and then require the autoload.php file from there.
* After this, we can use the PHP TestCase class and our Receipt class and then write our first test class.
*/
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';

// This imports the PHPUnit core class 'TestCase' for our use.
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
		$input = [0,2,5,8];                               // Arrange
		$coupon = null;                                   // Act
		$output = $this->Receipt->total($input, $coupon); // Assert
		$this->assertEquals(
			15,
			$output,
			'When summing the total should equal 15'
		);
	}

	public function testTotalAndCoupon() {
		$input = [0,2,5,8];
		$coupon = 0.20;
		$output = $this->Receipt->total($input, $coupon);
		$this->assertEquals(
			12,
			$output,
			'When summing the total should equal 12'
		);
	}
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
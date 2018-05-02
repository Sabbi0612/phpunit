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

	public function testTotalException() {
		$input = [0,2,5,8];
		$coupon = 1.20;
		$this->expectException('BadMethodCallException');
		$this->Receipt->total($input, $coupon);
	}
	
	public function testPostTaxTotal() {
		$items = [1,2,5,8];
		$tax = 0.20;
		$coupon = null;
		$Receipt = $this->getMockBuilder('TDD\Receipt')
			->setMethods(['tax', 'total'])
			->getMock();
		$Receipt->expects($this->once())
			->method('total')
			->with($items, $coupon)
			->will($this->returnValue(10.00));
		$Receipt->expects($this->once())
			->method('tax')
			->with(10.00, $tax)
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
<?php
require_once(dirname(__FILE__).'/../core/sofortLibMultipay.inc.php');
require_once('sofortLibTest.php');

/**
 * Class constructed just to test the methods of the abstract class
 * @author mm
 *
 */
class SofortLibMultipayMock extends SofortLibMultipay {}

class Unit_SofortLibMultipayTest extends SofortLibTest {

	protected $_classToTest = 'SofortLibMultipayMock';
	
	public function providerGetPaymentUrl () {
		return array(
			array('http://www.google.de'),
			array('http://www.test.de'),
		);
	}
	
	
	public function providerGetTransactionId () {
		return array(
			array('123324-3434354-4545454'),
			array('AS3324-45fFEr4-4545454'),
		);
	}
	
	
	public function providerSetAmount () {
		return array(
			array(20),
			array(10.13),
		);
	}
	
	
	public function providerSetEmailCustomer () {
		return array(
			array('info@sofort.com'),
			array('test@test.de'),
			array('ererererre'),
		);
	}
	
	
	public function providerSetHolder () {
		return array(
			array('Max Mustermann'),
		);
	}
	
	
	public function providerSetLanguageCode () {
		return array(
			array(array('DE', 'DE')),
			array(array('FR', 'FR')),
			array(array(NULL, 'EN')),
		);
	}
	
	
	public function providerSetPhoneCustomer () {
		return array(
			array('034545454'),
			array('045454545'),
			array('045454-454545'),
		);
	}
	
	
	/**
	 * Dataprovider for testSetReason
	 * 
	 * @return array
	 */
	public function providerSetReason () {
		return array(
			array(array('Verwendungszweck', 'Zweite Zeile'), array('Verwendungszweck', 'Zweite Zeile')),
			array(array('Verwendungszweck', NULL), array('Verwendungszweck', '')),
			array(
				array('Verwendungszweck', '123456789012345678901234567890'),
				array('Verwendungszweck', '123456789012345678901234567')),
			array(array('Verwendungszweck', 'test@test'), array('Verwendungszweck', 'test test')),
		);
	}
	
	
	public function providerSetSenderAccount () {
		return array(
			array(array('88888888', '12345678', 'Max Mustermann')),
		);
	}
	
	
	public function providerSetSenderBic () {
		return array(
			array('MARKDEFF'),
		);
	}
	

	public function providerSetSenderCountryCode () {
		return array(
			array('de'),
			array('fr'),
			array('br'),
		);
	}
	
	
	public function providerSetSenderIban () {
		return array(
				array('DE8888888812345678'),
		);
	}
	
	
	public function providerSetSenderSepaAccount () {
		return array(
			array(array('DEKTDE71002', 'DE471108151234567890', 'Max Mustermann')),
		);
	}
	
	
	public function providerSetTimeout () {
		return array(
			array(100),
			array(50),
			array(NULL),
		);
	}
	
	
	public function providerSetUserVariable () {
		return array(
			array('http://www.google.de'),
			array(array('http://www.sofort.com', 'http://www.heise.de')),
		);
	}
	
	
	/**
	 * @dataProvider providerGetPaymentUrl
	 */
	public function testGetPaymentUrl ($provided) {
		$response = self::_getProperty('_response', $this->_classToTest);
		$SofortLibMultipayMock = new SofortLibMultipayMock(self::$configkey);
		$test['new_transaction']['payment_url']['@data'] = $provided;
		$response->setValue($SofortLibMultipayMock, $test);
		$this->assertEquals($provided, $SofortLibMultipayMock->getPaymentUrl());
	}
	
	
	public function testGetReason () {
		$SofortLibMultipayMock = new SofortLibMultipayMock(self::$configkey);
		$this->assertFalse($SofortLibMultipayMock->getReason());
		
		$expected = array();
		$expected['reasons']['reason'] = 'test';
		$SofortLibMultipayMock->setParameters($expected);
		$this->assertEquals('test', $SofortLibMultipayMock->getReason());
	}
	
	
	/**
	 * @dataProvider providerGetTransactionId
	 */
	public function testGetTransactionId ($provided) {
		$response = self::_getProperty('_response', $this->_classToTest);
		$SofortLibMultipayMock = new SofortLibMultipayMock(self::$configkey);
		$test['new_transaction']['transaction']['@data'] = $provided;
		$response->setValue($SofortLibMultipayMock, $test);
		$this->assertEquals($provided, $SofortLibMultipayMock->getTransactionId());
	}
	
	
	/**
	 * @dataProvider providerSetAmount
	 */
	public function testSetAmount ($provided) {
		$SofortLibMultipayMock = new SofortLibMultipayMock(self::$configkey);
		$SofortLibMultipayMock->setAmount($provided);
		$received = $SofortLibMultipayMock->getParameters();
		$this->assertEquals($provided, $received['amount']);
	}
	
	
	/**
	 * @dataProvider providerSetEmailCustomer
	 *
	 */
	public function testSetEmailCustomer ($provided) {
		$SofortLibMultipayMock = new SofortLibMultipayMock(self::$configkey);
		$SofortLibMultipayMock->setEmailCustomer($provided);
		$received = $SofortLibMultipayMock->getParameters();
		$this->assertEquals($provided, $received['email_customer']);
	}
	
	
	/**
	 * @dataProvider providerSetHolder
	 */
	public function testSetHolder ($provided) {
		$SofortLibMultipayMock = new SofortLibMultipayMock(self::$configkey);
		$SofortLibMultipayMock->setSenderHolder($provided);
		$received = $SofortLibMultipayMock->getParameters();
		$this->assertEquals($provided, $received['sender']['holder']);
	}
	
	
	/**
	 * @dataProvider providerSetLanguageCode
	 *
	 */
	public function testSetLanguageCode ($provided) {
		$SofortLibMultipayMock = new SofortLibMultipayMock(self::$configkey);
		$SofortLibMultipayMock->setLanguageCode($provided[0]);
		$received = $SofortLibMultipayMock->getParameters();
		$this->assertEquals($provided[1], $received['language_code']);
	}
	
	
	/**
	 * @dataProvider providerSetPhoneCustomer
	 *
	 */
	public function testSetPhoneCustomer ($provided) {
		$SofortLibMultipayMock = new SofortLibMultipayMock(self::$configkey);
		$SofortLibMultipayMock->setPhoneCustomer($provided);
		$received = $SofortLibMultipayMock->getParameters();
		$this->assertEquals($provided, $received['phone_customer']);
	}
	
	
	/**
	 * @dataProvider providerSetReason
	 */
	public function testSetReason ($provided, $expected) {
		$SofortLibMultipayMock = new SofortLibMultipayMock(self::$configkey);
		$SofortLibMultipayMock->setReason($provided[0], $provided[1]);
		$this->assertEquals($expected, $SofortLibMultipayMock->getReason());
	}
	
	
	/**
	 * @dataProvider providerSetSenderAccount
	 */
	public function testSetSenderAccount ($provided) {
		$SofortLibMultipayMock = new SofortLibMultipayMock(self::$configkey);
		$SofortLibMultipayMock->setSenderAccount($provided[0], $provided[1], $provided[2]);
		$received = $SofortLibMultipayMock->getParameters();
		$this->assertEquals($provided, array($received['sender']['bank_code'], $received['sender']['account_number'], $received['sender']['holder']));
	}
	
	
	/**
	 * @dataProvider providerSetSenderBic
	 */
	public function testSetSenderBic ($provided) {
		$SofortLibMultipayMock = new SofortLibMultipayMock(self::$configkey);
		$SofortLibMultipayMock->setSenderBic($provided);
		$received = $SofortLibMultipayMock->getParameters();
		$this->assertEquals($provided, $received['sender']['bic']);
	}
	
	
	/**
	 * @dataProvider providerSetSenderCountryCode
	 */
	public function testSetSenderCountryCode ($provided) {
		$SofortLibMultipayMock = new SofortLibMultipayMock(self::$configkey);
		$SofortLibMultipayMock->setSenderCountryCode($provided);
		$received = $SofortLibMultipayMock->getParameters();
		$this->assertEquals($provided, $received['sender']['country_code']);
	}
	
	
	/**
	 * @dataProvider providerSetSenderIban
	 */
	public function testSetSenderIban ($provided) {
		$SofortLibMultipayMock = new SofortLibMultipayMock(self::$configkey);
		$SofortLibMultipayMock->setSenderIban($provided);
		$received = $SofortLibMultipayMock->getParameters();
		$this->assertEquals($provided, $received['sender']['iban']);
	}
	
	
	/**
	 * @dataProvider providerSetSenderSepaAccount
	 */
	public function testSetSenderSepaAccount ($provided) {
		$SofortLibMultipayMock = new SofortLibMultipayMock(self::$configkey);
		$SofortLibMultipayMock->setSenderSepaAccount($provided[0], $provided[1], $provided[2]);
		$received = $SofortLibMultipayMock->getParameters();
		$this->assertEquals($provided, array($received['sender']['bic'], $received['sender']['iban'], $received['sender']['holder']));
	}
	
	
	/**
	 * @dataProvider providerSetTimeout
	 *
	 */
	public function testSetTimeout ($provided) {
		$SofortLibMultipayMock = new SofortLibMultipayMock(self::$configkey);
		$SofortLibMultipayMock->setTimeout($provided);
		$received = $SofortLibMultipayMock->getParameters();
		$this->assertEquals($provided, $received['timeout']);
	}
	
	
	/**
	 * @dataProvider providerSetUserVariable
	 */
	public function testSetUserVariable ($provided) {
		$SofortLibMultipayMock = new SofortLibMultipayMock(self::$configkey);
		$SofortLibMultipayMock->setUserVariable($provided);
		$received = $SofortLibMultipayMock->getParameters();
		
		if(!is_array($provided)) {
			$provided = array($provided);
		}
		
		$this->assertEquals($provided, $received['user_variables']['user_variable']);
	}
	
	
	public function testSetVersion() {
		$SofortLibMultipayMock = new SofortLibMultipayMock(self::$configkey);
		$version = '12345';
		$SofortLibMultipayMock->setVersion($version);
		$received = $SofortLibMultipayMock->getParameters();
		$this->assertEquals($version, $received['interface_version']);
	}
}
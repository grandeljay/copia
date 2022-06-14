<?php
require_once(dirname(__FILE__).'/../core/abstractDataHandler.php');
require_once('sofortLibTest.php');

class Unit_AbstractDataHandlerTest extends SofortLibTest {
	
	protected $_classToTest = 'AbstractDataHandler';
	
	public function providerGetApiKey() {
		return array(
					array('4545434ff4493tej394gf343',),
				);
	}
	
	
	public function providerGetProjectId() {
		return array(
					array(4711,),
					array(20,),
				);
	}
	
	
	public function providerGetUserId() {
		return array(
					array(4711,),
					array(20,),
				);
	}
	
	
	/**
	 * @dataProvider providerGetApiKey
	 */
	public function testGetApiKey ($provided) {
		$AbstractDataHandler = $this->getMockForAbstractClass($this->_classToTest,array(self::$configkey));
		$this->assertEquals(self::$apikey, $AbstractDataHandler->getApiKey());
		
		$AbstractDataHandler->setApiKey($provided);
		$this->assertEquals($provided, $AbstractDataHandler->getApiKey());
	}
	
	
	/**
	 * @dataProvider providerGetProjectId
	 */
	public function testGetProjectId ($provided) {
		$AbstractDataHandler = $this->getMockForAbstractClass($this->_classToTest,array(self::$configkey));
		$this->assertEquals(self::$project_id, $AbstractDataHandler->getProjectId());
		
		$AbstractDataHandler->setProjectId($provided);
		$this->assertEquals($provided, $AbstractDataHandler->getProjectId());
	}
	
	
	public function testGetRawRequest() {
		$AbstractDataHandler = $this->getMockForAbstractClass($this->_classToTest,array(self::$configkey));
		$raw_request = self::_getProperty('_rawRequest', $this->_classToTest);
		$testdata = 'sometestdata';
		$raw_request->setValue($AbstractDataHandler, $testdata);
		$this->assertEquals($testdata, $AbstractDataHandler->getRawRequest());
	}
	
	
	public function testGetRawResponse() {
		$AbstractDataHandler = $this->getMockForAbstractClass($this->_classToTest,array(self::$configkey));
		$raw_response = self::_getProperty('_rawResponse', $this->_classToTest);
		$testdata = 'sometestdata';
		$raw_response->setValue($AbstractDataHandler, $testdata);
		$this->assertEquals($testdata, $AbstractDataHandler->getRawResponse());
	}
	
	
	public function testGetRequest() {
		$AbstractDataHandler = $this->getMockForAbstractClass($this->_classToTest,array(self::$configkey));
		$request = self::_getProperty('_request', $this->_classToTest);
		$testdata = 'sometestdata';
		$request->setValue($AbstractDataHandler, $testdata);
		$this->assertEquals($testdata, $AbstractDataHandler->getRequest());
	}

	
	
	/**
	 ** @dataProvider providerGetUserId
	 */
	public function testGetUserId ($provided) {
		$AbstractDataHandler = $this->getMockForAbstractClass($this->_classToTest,array(self::$configkey));
		$this->assertEquals(self::$user_id, $AbstractDataHandler->getUserId());
		
		$AbstractDataHandler->setUserId($provided);
		$this->assertEquals($provided, $AbstractDataHandler->getUserId());
	}
}
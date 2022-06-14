<?php
require_once(dirname(__FILE__).'/../core/lib/xmlToArray.php');

class Unit_XmlToArrayNodeTest extends SofortLibTest {

	protected $_classToTest = 'XmlToArrayNode';
	
	private $_attributes = array('attribute1' => 'val1', 'attribute2' => 'val2');
	
	private $_name = 'name';
	
	
	public function testAddChild() {
		$XmlToArrayNode = new XmlToArrayNode($this->_name, $this->_attributes);
		$mockXmlToArrayNode = $this->getMock('XmlToArrayNode', array(), array($this->_name, $this->_attributes));
		$XmlToArrayNode->addChild($mockXmlToArrayNode);
		$this->assertAttributeEquals(array($mockXmlToArrayNode), '_children', $XmlToArrayNode);
	}
	
	
	public function testConstruct() {
		$XmlToArrayNode = new XmlToArrayNode($this->_name, $this->_attributes);
		$this->assertAttributeEquals($this->_name, '_name', $XmlToArrayNode);
		$this->assertAttributeEquals($this->_attributes, '_attributes', $XmlToArrayNode);
	}
	
	
	public function testGetData() {
		$XmlToArrayNode = new XmlToArrayNode($this->_name, $this->_attributes);
		$data = 'test';
		$_data = self::_getProperty('_data', $this->_classToTest);
		$_data->setValue($XmlToArrayNode, $data);
		$this->assertEquals($data, $XmlToArrayNode->getData());
	}
	
	
	public function testGetName() {
		$XmlToArrayNode = new XmlToArrayNode($this->_name, $this->_attributes);
		$this->assertEquals($this->_name, $XmlToArrayNode->getName());
	}
	
	
	public function testGetParentXmlToArrayNode() {
		$XmlToArrayNode = new XmlToArrayNode($this->_name, $this->_attributes);
		$mockXmlToArrayNode = $this->getMock('XmlToArrayNode', array(), array($this->_name, $this->_attributes));
		$_ParentXmlToArrayNode = self::_getProperty('_ParentXmlToArrayNode', $this->_classToTest);
		$_ParentXmlToArrayNode->setValue($XmlToArrayNode, $mockXmlToArrayNode);
		$this->assertEquals($mockXmlToArrayNode, $XmlToArrayNode->getParentXmlToArrayNode());
	}
	
	
	public function testHasChild() {
		$XmlToArrayNode = new XmlToArrayNode($this->_name, $this->_attributes);
		$this->assertEquals(0, $XmlToArrayNode->hasChildren());
		
		$mockXmlToArrayNode = $this->getMock('XmlToArrayNode', array(), array($this->_name, $this->_attributes));
		$XmlToArrayNode->addChild($mockXmlToArrayNode);
		$this->assertEquals(1, $XmlToArrayNode->hasChildren());
	}
	
	
	public function testHasParentXmlToArrayNode() {
		$XmlToArrayNode = new XmlToArrayNode($this->_name, $this->_attributes);
		$mockXmlToArrayNode = $this->getMock('XmlToArrayNode', array(), array($this->_name, $this->_attributes));
		$_ParentXmlToArrayNode = self::_getProperty('_ParentXmlToArrayNode', $this->_classToTest);
		$_ParentXmlToArrayNode->setValue($XmlToArrayNode, $mockXmlToArrayNode);
		$this->assertTrue($XmlToArrayNode->hasParentXmlToArrayNode());
	}
	
	
	public function testIsOpen() {
		$XmlToArrayNode = new XmlToArrayNode($this->_name, $this->_attributes);
		$this->assertTrue($XmlToArrayNode->isOpen());
	}
	
	
	public function testRender() {
		$XmlToArrayNode = new XmlToArrayNode($this->_name, $this->_attributes);
		$mockFalseXmlToArrayNode = new XmlToArrayNode($this->_name, false);
		$XmlToArrayNode->addChild($mockFalseXmlToArrayNode);
		$mockXmlToArrayNode = new XmlToArrayNode($this->_name, $this->_attributes);
		$XmlToArrayNode->addChild($mockXmlToArrayNode);
		$this->assertEquals(array('name' => array('name' => array(0 => '', 1 => ''))),$XmlToArrayNode->render('struct'));
		
		$XmlToArrayNode = new XmlToArrayNode($this->_name, $this->_attributes);
		$XmlToArrayNode->addChild($mockXmlToArrayNode);
		$this->assertEquals(array('name' => array('name' => '')), $XmlToArrayNode->render('struct'));
		$this->assertEquals(
			array('name' => array(
					'name' => array('name' => array(
						'@data' => '',
						'@attributes' => array('attribute1' => 'val1', 'attribute2' => 'val2')
					)),
					'@data' => '',
					'@attributes' => array('attribute1' => 'val1', 'attribute2' => 'val2')
			)),
			$XmlToArrayNode->render(FALSE));
		$this->assertEquals(array('name' => array('name' => '')),$XmlToArrayNode->render(TRUE));
		
		$mock2XmlToArrayNode = new XmlToArrayNode($this->_name, array());
		$XmlToArrayNode = new XmlToArrayNode($this->_name, $this->_attributes);
		$mockXmlToArrayNode->addChild($mock2XmlToArrayNode);
		$XmlToArrayNode->addChild($mockXmlToArrayNode);
		$XmlToArrayNode->addChild($mockXmlToArrayNode);
		$this->assertEquals(
			array('name' => array('name' => array(
					0 => array('name' => array('name'  => '')),
					1 => array('name' => array('name'  => ''))
			))),
			$XmlToArrayNode->render('struct'));
	}
	
	
	public function testSetClosed() {
		$XmlToArrayNode = new XmlToArrayNode($this->_name, $this->_attributes);
		$this->assertTrue($XmlToArrayNode->isOpen());
		
		$XmlToArrayNode->setClosed();
		$this->assertFalse($XmlToArrayNode->isOpen());
	}
	
	
	public function testSetData() {
		$XmlToArrayNode = new XmlToArrayNode($this->_name, $this->_attributes);
		$data = 'test';
		$XmlToArrayNode->setData($data);
		$this->assertEquals($data, $XmlToArrayNode->getData());
		
		$data2 = 'MoreData';
		$XmlToArrayNode->setData($data2);
		$this->assertEquals($data. $data2, $XmlToArrayNode->getData());
	}
	
	
	public function testSetParentXmlToArrayNode() {
		$XmlToArrayNode = new XmlToArrayNode($this->_name, $this->_attributes);
		$mockXmlToArrayNode = $this->getMock('XmlToArrayNode', array(), array($this->_name, $this->_attributes));
		$XmlToArrayNode->setParentXmlToArrayNode($mockXmlToArrayNode);
		$this->assertAttributeEquals($mockXmlToArrayNode, '_ParentXmlToArrayNode', $XmlToArrayNode);
	}
}
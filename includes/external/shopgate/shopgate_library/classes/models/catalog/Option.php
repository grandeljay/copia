<?php

/**
 * Shopgate GmbH
 *
 * URHEBERRECHTSHINWEIS
 *
 * Dieses Plugin ist urheberrechtlich geschützt. Es darf ausschließlich von Kunden der Shopgate GmbH
 * zum Zwecke der eigenen Kommunikation zwischen dem IT-System des Kunden mit dem IT-System der
 * Shopgate GmbH über www.shopgate.com verwendet werden. Eine darüber hinausgehende Vervielfältigung, Verbreitung,
 * öffentliche Zugänglichmachung, Bearbeitung oder Weitergabe an Dritte ist nur mit unserer vorherigen
 * schriftlichen Zustimmung zulässig. Die Regelungen der §§ 69 d Abs. 2, 3 und 69 e UrhG bleiben hiervon unberührt.
 *
 * COPYRIGHT NOTICE
 *
 * This plugin is the subject of copyright protection. It is only for the use of Shopgate GmbH customers,
 * for the purpose of facilitating communication between the IT system of the customer and the IT system
 * of Shopgate GmbH via www.shopgate.com. Any reproduction, dissemination, public propagation, processing or
 * transfer to third parties is only permitted where we previously consented thereto in writing. The provisions
 * of paragraph 69 d, sub-paragraphs 2, 3 and paragraph 69, sub-paragraph e of the German Copyright Act shall remain unaffected.
 *
 * @author Shopgate GmbH <interfaces@shopgate.com>
 */

/**
 * @class Shopgate_Model_Catalog_Option
 * @see http://developer.shopgate.com/file_formats/xml/products
 *
 * @method        	setUid(int $value)
 * @method int    	getUid()
 *
 * @method        	setLabel(string $value)
 * @method string 	getLabel()
 *
 * @method        	setValue(string $value)
 * @method string 	getValue()
 *
 * @method        	setAdditionalPrice(float $value)
 * @method float  	getAdditionalPrice()
 *
 * @method        	setSortOrder(int $value)
 * @method int    	getSortOrder()
 *
 */
class Shopgate_Model_Catalog_Option extends Shopgate_Model_AbstractExport {

	/**
	 * define allowed methods
	 *
	 * @var array
	 */
	protected $allowedMethods = array(
		'Uid',
		'Label',
		'Value',
		'SortOrder',
		'AdditionalPrice');

	/**
	 * @param Shopgate_Model_XmlResultObject $itemNode
	 *
	 * @return Shopgate_Model_XmlResultObject
	 */
	public function asXml(Shopgate_Model_XmlResultObject $itemNode) {
		/**
		 * @var Shopgate_Model_XmlResultObject $optionNode
		 */
		$optionNode = $itemNode->addChild('option');
		$optionNode->addAttribute('additional_price', $this->getAdditionalPrice());
		$optionNode->addAttribute('uid', $this->getUid());
		$optionNode->addAttribute('sort_order', $this->getSortOrder());
		$optionNode->addChildWithCDATA('label', $this->getLabel());
		$optionNode->addChildWithCDATA('value', $this->getValue());

		return $itemNode;
	}
}
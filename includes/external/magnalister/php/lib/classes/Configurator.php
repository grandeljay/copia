<?php
/**
 * 888888ba                 dP  .88888.                    dP                
 * 88    `8b                88 d8'   `88                   88                
 * 88aaaa8P' .d8888b. .d888b88 88        .d8888b. .d8888b. 88  .dP  .d8888b. 
 * 88   `8b. 88ooood8 88'  `88 88   YP88 88ooood8 88'  `"" 88888"   88'  `88 
 * 88     88 88.  ... 88.  .88 Y8.   .88 88.  ... 88.  ... 88  `8b. 88.  .88 
 * dP     dP `88888P' `88888P8  `88888'  `88888P' `88888P' dP   `YP `88888P' 
 *
 *                          m a g n a l i s t e r
 *                                      boost your Online-Shop
 *
 * -----------------------------------------------------------------------------
 * $Id: Configurator.php 6148 2015-10-23 13:00:34Z tim.neumann $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the MIT License (Expat)
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

class MLConfigurator {
	private $form = array();
	private $id = '';
	private $url = array();
	private $realUrl = array();
	private $magnaQuery = array();
	private $config = array();

	private $mpID = 0;

	private $requiredConfigKeys = array();	
	private $missingConfigKeys = array();	
	private $testingMethods = array();
	private $notCorrect = array();
	
	private $renderResetJS = false;
	private $renderTabIdent = false;
	
	private $topHTML = '';
	
	private $keyOrder = array();
	
	private $ajaxUpdateFuncs = array();	
	
	public function __construct(&$form, $mpID, $id = '', $requiredConfigKeys = array()) {
		global $_url, $magnaConfig, $_magnaQuery, $_MagnaSession, $_modules;
		
		$this->form = &$form;
		$this->id = $id;
		$this->mpID = $mpID;
		
		$this->form['invisible']['fields'][] = array(
			'key' => (empty($_MagnaSession['currentPlatform']) ? 'general' : $_MagnaSession['currentPlatform']).'.firstactivation',
			'type' => 'hidden',
			'default' => date('Y-m-d H:i:s')
		);
		
		$this->url = $_url;
		$this->magnaQuery = $_magnaQuery;
		if (!array_key_exists((string)$this->mpID, $magnaConfig['db'])) {
			loadDBConfig((string)$this->mpID);
		}
		$this->config = &$magnaConfig['db'][$this->mpID];

		if (!empty($_MagnaSession['currentPlatform']) && 
			array_key_exists($_MagnaSession['currentPlatform'], $_modules) && 
			array_key_exists('requiredConfigKeys', $_modules[$_MagnaSession['currentPlatform']])
		) {
			$this->requiredConfigKeys = $_modules[$_MagnaSession['currentPlatform']]['requiredConfigKeys'];
		}
		
		if (!empty($requiredConfigKeys)) {
			$this->requiredConfigKeys = array_merge(
				$this->requiredConfigKeys,
				$requiredConfigKeys
			);
		}

		$this->testingMethods = array (
			'int' => ML_CONFIG_NOT_INT, 
			'float' => ML_CONFIG_NOT_FLOAT,
			'notempty' => ML_CONFIG_NOT_EMPTY,
			'contains' => ML_CONFIG_MUST_CONTAIN,
			'regex' => ML_CONFIG_INVALID_CHARS,
		);
		
		$this->itemSettings = array (
			'trim' => true,
			'save' => true,
		);

		$this->realUrl = array();
		if ($this->mpID == '0') {
			$this->realUrl['module'] = $_magnaQuery['module'];
		} else {
			$this->realUrl['mp'] = $this->mpID;
		}
		if (!empty($_magnaQuery['mode'])) {
			$this->realUrl['mode'] = $_magnaQuery['mode'];
		}
		if (array_key_exists('expert', $_GET) && ($_GET['expert'] == 'true')) {
			$this->realUrl['expert'] = 'true';
		}

	}
	
	public function setRenderTabIdent($b) {
		$this->renderTabIdent = $b;
	}
	
	public function setTopHTML($html) {
		$this->topHTML = $html;
	}
	
	public function setRequiredConfigKeys($requiredConfigKeys) {
		$this->requiredConfigKeys = array_merge(
			$this->requiredConfigKeys,
			$requiredConfigKeys
		);
	}

	private function keySort($lkey, $rkey) {
		//echo $lkey.' '.$rkey.'<br>';
		if (!array_key_exists($lkey, $this->keyOrder) || !array_key_exists($rkey, $this->keyOrder)) 
			return 0;
		
		if ($this->keyOrder[$lkey] == $this->keyOrder[$rkey])
			return 0;
		
		return $this->keyOrder[$lkey] > $this->keyOrder[$rkey] ? 1 : -1;
	}
	
	public function sortKeys($order) {
		if (empty($order)) return;
		$this->keyOrder = array_flip($order);
		
		$invisible = $this->form['invisible'];
		unset($this->form['invisible']);
		
		$tmpForm = array();
		foreach ($this->form as $key => $item) {
			if (!array_key_exists($key, $this->keyOrder)) {
				$tmpForm[$key] = $item;
				unset($this->form[$key]);
			}
		}

		uksort($this->form, array($this, 'keySort'));
		
		if (!empty($tmpForm)) {
			foreach ($tmpForm as $key => $item) {
				$this->form[$key] = $item;
			}
			unset($tmpForm);
		}

		$this->form['invisible'] = $invisible;
	}
	
	private function verify($verify, $key, $value) {
		$correct = false;

		if ($verify === false) {
			return true;
		}
		if (array_key_exists($verify, $this->testingMethods)) {
			switch ($verify) {
				case 'int': {
					$correct = preg_match('/^-?[0-9]*$/', $value);
					break;
				}
				case 'float': {
					$value = str_replace(',', '.', $value);
					$correct = is_numeric($value);
					$value = (float)$value;
					break;
				}
				case 'notempty': {
					$correct = !empty($value);
					break;
				}
			}
			if (!$correct) {
				$this->notCorrect[$key] = $this->testingMethods[$verify];
			}
		}

		if (preg_match('/^contains\(\"(.*)\"\)$/', $verify, $match)) {
			if (!($correct = (strpos($value, $match[1]) === false) ? false : true)) {
				$this->notCorrect[$key] = sprintf($this->testingMethods['contains'], $match[1]);
			}
		}
		if (strpos($verify, 'regex') === 0) {
			$regex = '/^'.substr($verify, strlen('regex("'), -strlen('")')).'$/';
			if (empty($value) || preg_match($regex, $value)) {
				$correct = true;
			} else {
				$this->notCorrect[$key] = $this->testingMethods['regex'];
			}
		}
		return $correct;
	}
	
	public function processPOST() {
		$keysToSubmit = array();
		$tmpKeysToSubmit = array();

		if (!(array_key_exists('conf', $_POST) && is_array($_POST['conf']) &&
				array_key_exists('configtool', $_POST) && ($_POST['configtool'] == 'MagnaConfigurator') /* Nur um gaaaanz sicher zu gehen :D */
			)) {
			return true;
		}

		$noError = true;
		
		/* Save TabIdent */
		if ($this->renderTabIdent && array_key_exists('tabident', $_POST)) {
			setDBConfigValue(
				array('general.tabident', $this->mpID), '0', 
				stringToUTF8(trim($_POST['tabident'])), 
				true
			);
			$keysToSubmit['PlugIn.Label'] = trim($_POST['tabident']);
		}
		#echo print_m(getDBConfigValue('general.tabident', '0'));
		#echo print_m($_POST);
		#echo print_m($this->config);

		/* Save config */
		$postData = $_POST['conf'];
		foreach($postData as $key => &$value) {
			$key = trim($key);

			$verify = false;
			$correct = false;

			$settings = $this->itemSettings;
			
			$foundItem = array();

			foreach ($this->form as $fi) {
				foreach ($fi['fields'] as $configItem) {
					if (!isset($configItem['key'])) {
						continue;
					}
					if ($key == $configItem['key']) {
						$foundItem = $configItem;
						break;
					}
					if (isset($configItem['morefields'])) {
						foreach ($configItem['morefields'] as $moreFields) {
							if ($key == $moreFields['key']) {
								$foundItem = $moreFields;
								break;
							}
						}
					}
				}
			}

			if (!empty($foundItem)) {
				if (array_key_exists('settings', $foundItem)) {
					$settings = array_merge(
						$this->itemSettings,
						$foundItem['settings']
					);
				}
				if (array_key_exists('verify', $foundItem)) {
					$verify = $foundItem['verify'];
				}
				if (array_key_exists('submit', $foundItem) && !empty($foundItem['submit'])) {
					$tmpKeysToSubmit[] = array(
						'confKey' => $foundItem['key'],
						'apiKey' => $foundItem['submit'],
					);
				}
			}

			if (is_array($value)) {
				foreach ($value as $k => &$v) {
					if (($v == 'true') || ($v == 'false')) {
						$value[$k] = ($v == 'true') ? true : false;
					}
				}
				arrayEntitiesToUTF8($value);
				$value = json_encode($value);
			}
			if ($settings['trim']) {
				$value = trim($value);
			}
			if (!$settings['save'] && (!empty($value) || ($this->config[$key] == '__saved__'))) {
				$value = '__saved__';
			}

			$correct = $this->verify($verify, $key, $value);
			if (!empty($foundItem) && ($foundItem['type'] == 'extern') && is_callable($foundItem['procFunc'])) {
				#echo print_m($value, basename(__FILE__).'{L'.__LINE__.'}');
				$correct = call_user_func_array($foundItem['procFunc'], array (
					'args' => array_merge(
						$foundItem['params'],
						array (
							'key' => $foundItem['key'],
							'kind' => 'save',
						)
					),
					'value' => &$value
				));
				#echo print_m($value, basename(__FILE__).'{L'.__LINE__.'}');
			}
			if (!$correct) {
				$noError = false;
			}

			if (!empty($key) && $correct) {
				if (empty($value) && ($value !== '0')) $value = '';
				if (($value === 'null') || ($value === null)) $value = '';
				$data = array('mpID' => $this->mpID, 'mkey' => $key, 'value' => $value);
				if (MagnaDB::gi()->recordExists(TABLE_MAGNA_CONFIG, array(
					'mpID' => $this->mpID,
					'mkey' => $key,
				))) {
					MagnaDB::gi()->update(TABLE_MAGNA_CONFIG, $data, array(
						'mpID' => $this->mpID,
						'mkey' => $key
					));
				} else {
					MagnaDB::gi()->insert(TABLE_MAGNA_CONFIG, $data);
				}
			}
		}
		// reload DB Config
		$cfgData = loadDBConfig($this->mpID);
		if (!empty($tmpKeysToSubmit)) {
			foreach ($tmpKeysToSubmit as $key) {
				$keysToSubmit[$key['apiKey']] = getDBConfigValue($key['confKey'], $this->mpID);
			}
		}
		if (!empty($keysToSubmit)) {
			$request = array(
				'ACTION' => 'SetConfigValues',
				'DATA' => $keysToSubmit,
			);
			try {
				MagnaConnector::gi()->submitRequest($request);
			} catch (MagnaException $me) { }
		}
		
		if (is_array($cfgData)) {
			$request = array(
				'ACTION' => 'SavePluginConfig',
				'DATA' => $cfgData,
			);
			try {
				MagnaConnector::gi()->setTimeOutInSeconds(1);
				MagnaConnector::gi()->submitRequest($request);
				MagnaConnector::gi()->resetTimeOut();
			} catch (MagnaException $me) {
				$me->setCriticalStatus(false);
			}
		}
		
		return $noError;
	}
	
	private function getDefault($key) {
		foreach ($this->form as $item) {
			if (!isset($item['fields']) || empty($item['fields'])) {
				continue;
			}
			foreach ($item['fields'] as $field) {
				if ($field['key'] == $key) {
					return (isset($field['default']) && !empty($field['default'])) ? $field['default'] : '';
				}
				if (isset($field['morefields']) && !empty($field['morefields'])) {
					foreach ($field['morefields'] as $mfield) {
						if ($mfield['key'] == $key) {
							return (isset($mfield['default']) && !empty($mfield['default'])) ? $mfield['default'] : '';
						}
					}
				}
			}
		}
	}
	
	private function renderDBCols($args) {
		$values = array();
		if (!empty($args['value']) && MagnaDB::gi()->tableExists($args['value'])) {
			$values = MagnaDB::gi()->getTableCols($args['value']);
			if (!empty($values)) {
				$values = array_flip($values);
				foreach ($values as $col => &$colname) {
					$colname = $col;
				}
			}
		}
		if (empty($values)) {
			$values = array('' => ML_LABEL_SELECT_TABLE_FIRST);
		}
		$default = (array_key_exists($args['key'], $this->config) && array_key_exists('column', (array)$this->config[$args['key']]))
			? $this->config[$args['key']]['column']
			: false;
		$html = '';
		foreach ($values as $k => $v) {
			$html .= '<option value="'.$k.'"'.(($default == $k) ? ' selected="selected"' : '').'>'.$v.'</option>'."\n";
		}
		return $html;
	}
	
	public function processAjaxRequest() {
		if (!isset($_REQUEST['action']) || empty($_REQUEST['action'])) {
			return '';
		}
		switch ($_REQUEST['action']) {
			case 'getDefault': {
				if (!isset($_POST['key']) || empty($_POST['key'])) {
					return '';
				}
				return $this->getDefault(str_replace('_', '.', preg_replace('/^config_/', '', $_POST['key'])));
				break;
			}
			case 'update': {
				$args = array(
					'key' => $_POST['key'],
					'value' => $_POST['value'],
				);
				if (strpos($_POST['function'], 'UpdateColumns') === 0) {
					return $this->renderDBCols($args);
				}
				$func = 'magna'.$_POST['function'];
				if (!function_exists($func)) {
					return 'FALIURE';
				}
				return $func($args);
			}
			case 'extern': {
				$func = $_REQUEST['function'];
				$args = $_REQUEST;
				unset($args['function']);
				unset($args['action']);
				if (!is_callable($func)) {
					return 'FALIURE';
				}
				return call_user_func($func, $args);
			}
		}
		return '';
	}
	
	private function renderSubInput($item, $subKey, $pItem) {
		$idkey = 'config_'.str_replace('.', '_', $pItem['key']).'_'.$subKey.'_'.$item['type'];

		if (array_key_exists($pItem['key'], $this->config) && array_key_exists($subKey.'.value', $this->config[$pItem['key']])) {
			$value = $this->config[$pItem['key']][$subKey.'.value'];
			if (is_array($value) && is_array($item['default'])) {
				$value = array_merge($item['default'], $value);
			}
		} else if (isset($item['default'])) {
			$value = $item['default'];
		}
		
		if (array_key_exists('ajaxlinkto', $item)) {
			$item['ajaxlinkto']['from'] = $pItem['key'];
			$this->ajaxUpdateFuncs[] = $item['ajaxlinkto'];
		}
		
		$html = '';
		$parameters = '';
		if (isset($item['parameters'])) {
			foreach ($item['parameters'] as $key => $val) {
				$parameters .= ' '.$key.'="'.$val.'"';
			}
		}

		if (!in_array($item['type'], array('checkbox', 'radio')) && array_key_exists('label', $item)) {
			$html .= '<label for="'.$idkey.'">'.$item['label'].'</label>'."\n";
		}

		switch ($item['type']) {
			case 'selection': {
				$html .= '<select id="config_'.$idkey.'" name="conf['.$pItem['key'].']['.$subKey.'.value]"'.$parameters.'>'."\n";
				foreach ($item['values'] as $k => $v) {
					$html .= '	<option value="'.$k.'"'.(($value == $k) ? ' selected="selected"' : '').'>'.$v.'</option>'."\n";
				}
				$html .= '</select>'."\n";
				break;
			}
		}
		
		//echo print_m($html);
		//echo print_m($item);
		//echo print_m($pItem);
		return $html;
	}
	
	private function renderInput($item) {
		#echo print_m($item);
		
		$value = '';
		if (!isset($item['key'])) {
			$item['key'] = '';
		}
		if (array_key_exists($item['key'], $this->config)) {
			$value = $this->config[$item['key']];
			if (is_array($value) && isset($item['default']) && is_array($item['default'])) {
				//echo print_m($item['default'], 'default'); echo print_m($value, 'config');
				//var_dump(isNumericArray($item['default']), isNumericArray($value));
				if (isNumericArray($item['default']) && isNumericArray($value)) {
					foreach ($item['default'] as $k => $v) {
						if (array_key_exists($k, $value)) continue;
						$value[$k] = $item['default'][$k];
					}
				} else {
					$value = array_merge($item['default'], $value);
				}
			}
		} else if (isset($item['default'])) {
			$value = $item['default'];
		}
		$item['__value'] = $value;

		$idkey = str_replace('.', '_', $item['key']);

		$parameters = '';
		if (isset($item['parameters'])) {
			foreach ($item['parameters'] as $key => $val) {
				$parameters .= ' '.$key.'="'.$val.'"';
			}
		}
		if (array_key_exists('ajaxlinkto', $item)) {
			$item['ajaxlinkto']['from'] = $item['key'];
			$item['ajaxlinkto']['fromid'] = 'config_'.$idkey;
			if (array_key_exists('key', $item['ajaxlinkto'])) {
				$item['ajaxlinkto']['toid'] = 'config_'.str_replace('.', '_', $item['ajaxlinkto']['key']);
				$this->ajaxUpdateFuncs[] = $item['ajaxlinkto'];
			} else { # mehrere ajaxlinkto eintraege
				foreach ($item['ajaxlinkto'] as $aLiTo) {
					if (!is_array($aLiTo) || !array_key_exists('key', $aLiTo)) continue;
					$aLiTo['toid'] = 'config_'.str_replace('.', '_', $aLiTo['key']);
					$this->ajaxUpdateFuncs[] = $aLiTo;
				}
			}
		}

		if (!isset($item['cssClasses'])) {
			$item['cssClasses'] = array();
		}
		if (in_array($item['key'], $this->missingConfigKeys)) {
			$item['cssClasses'][] = 'missing';
		}

		if (isset($item['cssStyles']) && is_array($item['cssStyles'])) {
			$style = ' style="'.implode(';', $item['cssStyles']).'" ';
		} else {
			$style = '';
		}
		
		$html = '';
		switch ($item['type']) {
			case 'text':
			case 'password':
			case 'hidden': {
				if (($item['type'] == 'password') && (!empty($value))) {
					$html .= '<label for="config_'.$idkey.'" class="savedPassword"><span>'.ML_LABEL_SAVED.'</span></label>';
				}
				if ($value == '__saved__') {
					$value = '';
				}
				if (isset($item['formatstr']) && !empty($item['formatstr'])) {
					$value = sprintf($item['formatstr'], $value);
				}
				$item['cssClasses'][] = 'fullwidth';

				$class = ' class="'.implode(' ', $item['cssClasses']).'"';

				$html .= '<input type="'.$item['type'].'"'.$class.$style.' id="config_'.$idkey.'" name="conf['.$item['key'].']" value="'.(string)$value.'"'.$parameters.'/>';
				break;
			}
			case 'selection': {
				$class = ' class="'.implode(' ', $item['cssClasses']).'"';
				if (isset($item['labelinfo'])) {
					$html .= ' <label for="config_'.$idkey.'"'.$class.$style.'>'.$item['labelinfo'].'</label> ';				
				}
				
				$html .= '<select id="config_'.$idkey.'" name="conf['.$item['key'].']"'.$parameters.''.$class.$style.'>'."\n";
				foreach ($item['values'] as $k => $v) {
					if ($k === '__calc__') {
						if (preg_match('/^range\(([0-9]*),([0-9]*)\)$/', $v, $matches)) {
							$a = range($matches[1], $matches[2]);
							foreach ($a as $nV) {
								$html .= '<option value="'.$nV.'"'.(($value == $nV) ? ' selected="selected"' : '').'>'.$nV.'</option>'."\n";
							}
						}
					} else {
						$html .= '<option value="'.$k.'"'.(((strlen((string)$value) == strlen((string)$k)) && ($value == $k)) ? ' selected="selected"' : '').'>'.(!preg_match('/&[^\s;]*;/', $v) ? fixHTMLUTF8Entities($v) : $v).'</option>'."\n";
					}
				}
				$html .= '</select>'."\n";
				break;
			}
			case 'multiselection': {
				$class = ' class="'.implode(' ', $item['cssClasses']).'"';
				$html .= '<input type="hidden" value="[]" name="conf['.$item['key'].']" />';
				$html .= '<select id="config_'.$idkey.'" name="conf['.$item['key'].'][]" multiple="multiple" '.$parameters.''.$class.$style.'>'."\n";
				if (empty($item['values'])) {
					$html .= '<option>&mdash;</option>';
				} else {
					foreach ($item['values'] as $k => $v) {
						$html .= '<option value="'.$k.'"'.(in_array($k, $value) ? ' selected="selected"' : '').'>'.$v.'</option>'."\n";
					}
				}
				$html .= '</select>'."\n";
				break;
			}
			case 'radio': {
				$class = ' class="'.implode(' ', $item['cssClasses']).'"';
				$c = 0;
				$modSep = isset($item['separatormodulo']) && is_int($item['separatormodulo']) ? $item['separatormodulo'] : 1;
				foreach ($item['values'] as $k => $v) {
					$sep = '';
					if (($c % $modSep) == ($modSep - 1)) {
						$sep = isset($item['separator']) ? $item['separator'] : '';
					}
					$html .= '<span><input type="radio" value="'.$k.'" name="conf['.$item['key'].']" id="conf_'.$item['key'].'_'.$k.'"'.
								(($value == $k) ? ' checked="checked"' : '').$parameters.
							' /> <label for="conf_'.$item['key'].'_'.$k.'"'.$class.$style.'>'.$v.'</label></span>'.$sep."\n";
				}
				break;
			}
			case 'checkbox': {
				$class = ' class="'.implode(' ', $item['cssClasses']).'"';
				$c = 0;
				$modSep = isset($item['separatormodulo']) && is_int($item['separatormodulo']) ? $item['separatormodulo'] : 1;
				//echo print_m($value);
				foreach ($item['values'] as $k => $v) {
					if (is_array($v)) {
						$v = $this->renderSubInput($v, $k, $item);
					} else {
						$v = '<label for="conf_'.$item['key'].'_'.$k.'"'.$class.$style.'>'.$v.'</label>';
					}
					$sep = '';
					if (($c % $modSep) == ($modSep - 1)) {
						$sep = isset($item['separator']) ? $item['separator'] : '';
					}
					$html .= '<span class="nowrap">
						<input type="hidden" value="false" name="conf['.$item['key'].']['.$k.']" />
						<input type="checkbox" value="true" name="conf['.$item['key'].']['.$k.']" id="conf_'.$item['key'].'_'.$k.'"'.
								(is_array($value) && (array_key_exists($k, $value) && $value[$k]) ? ' checked="checked"' : '').$parameters.
							' /> '.$v.'</span>'.$sep."\n";	
					++$c;
				}
				break;
			}
			case 'multicheckbox': {
				$class = ' class="'.implode(' ', $item['cssClasses']).'"';
				$c = 0;
				$modSep = isset($item['separatormodulo']) && is_int($item['separatormodulo']) ? $item['separatormodulo'] : 1;
				//$html .= print_m($value);
				$html .= '<input type="hidden" value="[]" name="conf['.$item['key'].']" />';
				if (empty($item['values'])) {
					$html .= '&mdash;';
				} else {
					foreach ($item['values'] as $k => $v) {
						if (is_array($v)) {
							$v = $this->renderSubInput($v, $k, $item);
						} else {
							$v = '<label for="conf_'.$item['key'].'_'.$k.'"'.$class.$style.'>'.$v.'</label>';
						}
						$sep = '';
						if (($c % $modSep) == ($modSep - 1)) {
							$sep = isset($item['separator']) ? $item['separator'] : '';
						}
						$html .= '<span class="nowrap">
							<input type="checkbox" value="'.$k.'" name="conf['.$item['key'].'][]" id="conf_'.$item['key'].'_'.$k.'"'.
									((is_array($value) && in_array($k, $value)) ? ' checked="checked"' : '').$parameters.
								' /> '.$v.'</span>'.$sep."\n";
						++$c;
					}
				}
				break;
			}
			case 'textarea': {
				$item['cssClasses'][] = 'fullwidth';
				$class = ' class="'.implode(' ', $item['cssClasses']).'"';
				$html .= '<textarea'.$class.$style.' id="config_'.$idkey.'" name="conf['.$item['key'].']"'.$parameters.'>'.str_replace('<', '&lt;', (string)$value).'</textarea>';
				break;
			}
			case 'dbfieldselector': {
				$class = ' class="'.implode(' ', $item['cssClasses']).'"';
				$html .= '<select id="config_'.$idkey.'_table" name="conf['.$item['key'].'][table]"'.$parameters.''.$class.$style.'>'."\n";
				$tables = MagnaDB::gi()->getAvailableTables();
				if (!empty($tables)) {
					$tables = array_flip($tables);
					foreach ($tables as $tbl => &$tblname) {
						$tblname = $tbl;
					}
				}
				$item['values'] = array_merge(
					array(
						'' => ML_LABEL_DONT_USE,
					),
					$tables
				);
				$tblVal = (array_key_exists('table', (array)$value)) ? $value['table'] : false;
				foreach ($item['values'] as $k => $v) {
					$html .= '<option value="'.$k.'"'.(($tblVal == $k) ? ' selected="selected"' : '').'>'.$v.'</option>'."\n";
				}
				$html .= '</select>'."\n";

				$item['ajaxlinkto'] = array (
					'fromid' => 'config_'.$idkey.'_table',
					'toid' => 'config_'.$idkey.'_column',
					'key' => $item['key'],
					'func' => 'UpdateColumns_'.$idkey,
					'initload' => ($tblVal === false),
				);
				$this->ajaxUpdateFuncs[] = $item['ajaxlinkto'];

				$html .= '<select id="config_'.$idkey.'_column" name="conf['.$item['key'].'][column]"'.$parameters.''.$class.$style.'>'."\n";
				$html .= $this->renderDBCols(array(
					'value' => $tblVal,
					'key' => $item['key']
				));
				$html .= '</select>'."\n";
				break;
			}
			case 'date': {
				$class = ' class="'.implode(' ', $item['cssClasses']).'"';

				$default = $value;
				if (!empty($default)) {
					$default = strtotime($default);
					if ($default > 0) {
						$default = date('Y/m/d', $default);
					} else {
						$default = '';
					}
				}
				if (empty($default)) {
					$default = date('Y/m/d');
				} else {
					$default = date('Y/m/d', strtotime($default));
				}

				$langCode = $_SESSION['language_code'];
				if (empty($langCode)) {
					$langCode = $_SESSION['language_code'] = MagnaDB::gi()->fetchOne('
						SELECT code FROM '.TABLE_LANGUAGES.'
						 WHERE languages_id="'.$_SESSION['languages_id'].'"
					');
				}
				$deleteButton = '';

				$html .= '
					<input type="text" id="config_'.$idkey.'_visual" value="" readonly="readonly" '.$class.$style.'/>
					<input type="hidden" id="config_'.$idkey.'" name="conf['.$item['key'].']" value="'.$default.'"/>
					'.$deleteButton.'
					<script type="text/javascript">/*<![CDATA[*/
						$(document).ready(function() {
							jQuery.datepicker.setDefaults(jQuery.datepicker.regional[\'\']);
							$("#config_'.$idkey.'_visual").datepicker(
								jQuery.datepicker.regional[\''.$langCode.'\']
							).datepicker(
								"option", "altField", "#config_'.$idkey.'"
							).datepicker(
								"option", "altFormat", "yy-mm-dd"
							)'.(!empty($default) ? '.datepicker(
								"option", "defaultDate", new Date(\''.$default.'\')
							)' : '').';
							var dateFormat'.$idkey.' = $("#config_'.$idkey.'_visual").datepicker("option", "dateFormat");
							'.(!empty($default) ? '
							$("#config_'.$idkey.'_visual").val(
								jQuery.datepicker.formatDate(dateFormat'.$idkey.', new Date(\''.$default.'\'))
							);
							$("#config_'.$idkey.'").val(
								jQuery.datepicker.formatDate("yy-mm-dd", new Date(\''.$default.'\'))
							);' : '').'
						});
					/*]]>*/</script>'."\n";
				break;
			}
			case 'extern': {
				if (!is_callable($item['procFunc'])) {
					if (is_array($item['procFunc'])) {
						$item['procFunc'] = get_class($item['procFunc'][0]).'->'.$item['procFunc'][1];
					}
					$html .= 'Function <span class="tt">\''.$item['procFunc'].'\'</span> does not exists.';
					break;
				}
				$html .= call_user_func($item['procFunc'], array_merge($item['params'], array('key' => $item['key'])));
				break;
			}
			case 'html': {
				$html .= $item['value'];
				break;
			}
		}
		return $html;
	}
	
	private function renderLabel($label, $idkey) {
		if ((strpos($label, 'const') !== false) && preg_match('/^const\((.*)\)$/', $label, $match)){
			$label = constant($match[1]);
		}
		return '<label for="config_'.$idkey.'">'.$label.'</label>';
	}

	private function renderButton($button, $idkey) {
		switch ($button) {
			case '#restoreDefault#': {
				$this->renderResetJS = true;
				return '<input class="ml-button" type="button" onclick="resetDefaults(\'config_'.$idkey.'\')" value="'.ML_BUTTON_RESTORE_DEFAULTS.'" />';
				break;
			}
			default: {
				return $button;
			}
		}
	}

	public function renderConfigForm() {
		$html = '';
		#echo print_m($this->form);
		
		if (array_key_exists('conf', $_POST) && is_array($_POST['conf']) &&
			array_key_exists('configtool', $_POST) && ($_POST['configtool'] == 'MagnaConfigurator') /* Nur um gaaaanz sicher zu gehen :D */
		) {
			if (empty($this->notCorrect)) {
				$html .= '<p class="successBox">'.ML_TEXT_CONFIG_SAVED_SUCCESSFULLY.'</p>';
			} else {
				$html .= '<p class="noticeBox">'.ML_TEXT_CONFIG_SAVED_SEMI_SUCCESSFULLY.'</p>';
			}
		}
		$which = array();
		if (!empty($this->requiredConfigKeys) 
			&& !allRequiredConfigKeysAvailable($this->requiredConfigKeys, $this->mpID, false, $this->missingConfigKeys)
		) {
			$html .= '<div class="successBoxBlue">'.ML_TEXT_FILLOUT_CONFIG_FORM.(
				isset($_GET['showMissingKeys']) ? ('<ul><li>'.implode('</li><li>', $this->missingConfigKeys).'</li></ul>') : '').
			'</div>';
		}

		$html .= '<form id="'.($this->id ? $this->id : 'config').'" class="config" method="POST" action="'.toUrl($this->realUrl).'">'."\n";
		$descCount = 0;
		$html .= '
			<table class="conftbl'.($this->renderTabIdent ? ' tabident' : '').'">
				<tbody>';
		if ($this->renderTabIdent) {
			$tabLabel = getDBConfigValue(array('general.tabident', $this->mpID), '0', '');
			$tabLabel = fixHTMLUTF8Entities($tabLabel);
			$html .= '
				<tr class="conf"><th class="ml-label">
					<label for="config_tabident">'.ML_LABEL_TAB_IDENT.'</label></th>
					<th class="desc">
						<div class="desc" id="desc_'.($descCount++).'" title="'.ML_LABEL_INFOS.'"><span>'.ML_TEXT_TAB_IDENT.'</span></div>
					</th>
					<td class="input" colspan="3">
						<input type="text" id="config_tabident" name="tabident" value="'.
							str_replace(
								array('<', '>', '"'),
								array('&lt;', '&gt;', '&quot;'),
								$tabLabel
							)
						.'"/>
					</td>
				</tr>
			';
		}
		if (!empty($this->topHTML)) {
			$html .= '
				<tr class="text"><td colspan="5">
					'.$this->topHTML.'
				</td></tr>';
		}
		
		$hiddenFields = '';
		foreach ($this->form as $section) {
			foreach ($section['fields'] as $sKey => $item) { //clean fields
				if (
					(empty($item) || !is_array($item))
					|| ((!defined('MAGNA_SECRET_DEV') || !MAGNA_SECRET_DEV)
						&& array_key_exists('MAGNA_SECRET_DEV_SETTING', $item)
						&& $item['MAGNA_SECRET_DEV_SETTING']
					)
					|| (
						(!array_key_exists('expert', $_GET) || ($_GET['expert'] != 'true'))
						&& array_key_exists('expertsetting', $item)
						&& $item['expertsetting'] 
					)
				) {
					unset($section['fields'][$sKey]); 
				}
			}
			if (empty($section['fields'])) {
				continue;
			}
			if (isset($section['headline']) && !empty($section['headline'])) {
				$html .= '
					<tr class="text"><td colspan="5">
						<h3>'.$section['headline'].'</h3>
					</td></tr>';
			}
			if (isset($section['desc']) && !empty($section['desc'])) {
				$class = 'text'.((isset($section['headline']) && !empty($section['headline'])) ? '' : ' noheadline');
				$html .= '
					<tr class="'.$class.'"><td colspan="5">
						<p>'.$section['desc'].'</p>
					</td></tr>';
			}
			
			foreach ($section['fields'] as $item) {
				$isExpert = array_key_exists('expertsetting', $item) && $item['expertsetting'];
				if (!isset($item['key'])) {
					$item['key'] = '';
				}
				$idkey = str_replace('.', '_', $item['key']);
				$input = $this->renderInput($item);
				if ($item['type'] != 'hidden') {
					if (isset($item['rightlabel'])) {
						$input .= $this->renderLabel($item['rightlabel'], $idkey);
					}
					if (isset($item['morefields'])) {
						foreach ($item['morefields'] as $mfItem) {
							$mfidkey = str_replace('.', '_', $mfItem['key']);
							if (isset($mfItem['label'])) {
								#$input .= '&nbsp;'.$this->renderLabel($mfItem['label'], $mfidkey);
								$input .= $this->renderLabel($mfItem['label'], $mfidkey);
							}
							if (isset($mfItem['desc'])) {
								$input .= '&nbsp;<div class="desc" id="desc_'.($descCount++).'" title="'.ML_LABEL_INFOS.'"><span>'.$mfItem['desc'].'</span></div>';
							}
							if (isset($mfItem['label'])) {
								$input .= ':&nbsp;';
							}
															
							$input .= $this->renderInput($mfItem);
							
							if (isset($mfItem['rightlabel'])) {
								$input .= $this->renderLabel($mfItem['rightlabel'], $mfidkey);
							}
							if ($mfItem['type'] != 'hidden') {
								if (array_key_exists($mfItem['key'], $this->notCorrect)) {
									$this->notCorrect[$item['key']] .= ' '.$this->notCorrect[$mfItem['key']];
								}
							}
						}
					}

					$labelClasses = $isExpert ? 'expert ' : '';
					if (in_array($item['key'], $this->missingConfigKeys)) {
						$labelClasses .= 'missing ';
					}
					$html .= '
						<tr class="conf">
							'.(!empty($item['label'])
								? (
									'<th class="ml-label">'.
										'<label for="config_'.$idkey.'" class="'.$labelClasses.'">'.$item['label'].'</label>'.
									'</th>' 
								)
								: ''
							);
					$cfgRow = '
							<th class="desc">';
					if (isset($item['desc'])) {
						$cfgRow .= '<div class="desc" id="desc_'.($descCount++).'" title="'.ML_LABEL_INFOS.'"><span>'.$item['desc'].'</span></div>';
					} else {
						$cfgRow .= '&nbsp;';
					}
					$colspan = 3;
					if (isset($item['hint'])) {
						$colspan = 2;
					}
					if (array_key_exists($item['key'], $this->notCorrect)) {
						$colspan = 1;
					}
					if ($item['type'] == 'textarea') {
						if (isset($item['buttons']) && !empty($item['buttons']) && is_array($item['buttons'])) {
							$content = '';
							foreach ($item['buttons'] as $button) {
								$content .= $this->renderButton($button, $idkey);
							}
						} else {
							$content = '&nbsp;';
						}
						$cfgRow .= '</th>
								<th class="space textright" colspan="'.$colspan.'">'.$content.'</th>';
					} else {
						$cfgRow .= '</th>
								<td class="input" '.(isset($item['inputCellStyle']) ? 'style="'.$item['inputCellStyle'].'" ' : '').'colspan="'.$colspan.'">'.
									$input.
								'</td>';
					}
					$html .= !empty($item['label']) ? 
									$cfgRow : 
									'<td class="subtable" colspan="'.(2 + $colspan).'"><table><tbody><tr>'.$cfgRow.'</tr></tbody></table></td>';
					if (array_key_exists($item['key'], $this->notCorrect)) {
						$html .= '
							<td class="error"'.(!isset($item['hint']) ? ' colspan="2"' : '').'>'.$this->notCorrect[$item['key']].'</td>';
					}
					if (isset($item['hint'])) {
						$html .= '
							<td class="hint">'.$item['hint'].'</td>';
					}
					$html .= '
						</tr>';
					if ($item['type'] == 'textarea') {
						if (isset($item['externalDesc']) && !empty($item['externalDesc'])) {
							$html .= '
							<tr>
								<td colspan="5" class="subconf"><table class="subtable"><tbody><tr>
									<td class="noborder editor">'.$input.'</td>
									<td class="noborder externalDesc">'.$item['externalDesc'].'</td>
								</tr></tbody></table></td>
							</tr>';							
						} else {
							$html .= '
							<tr>
								<td colspan="5" class="editor">'.$input.'</td>
							</tr>';
						}
					}
				} else {
					$hiddenFields .= $input."\n";
				}
			}
		}
		/* Eine Leere Zeile mit allen Spalten um mein Freund den IE gluecklich zu machen -.-' */
		$html .= '
					</tbody>
				</table>
				'.$hiddenFields.'
				<table class="actions">
					<thead><tr><th>'.ML_LABEL_ACTIONS.'</th></tr></thead>
					<tbody>
						<tr><td>
							<table><tbody><tr>
								<td class="firstChild">
									<a href="'.toUrl(
										$this->realUrl, array('expert' => 'true')
									).'" title="'.ML_BUTTON_LABEL_EXPERTVIEW.'" class="ml-button">'.
										ML_BUTTON_LABEL_EXPERTVIEW.
									'</a>
								</td>
								<td class="lastChild">
									<input type="hidden" value="MagnaConfigurator" name="configtool"/>
									<input class="ml-button" type="reset" value="'.ML_BUTTON_LABEL_RESET.'"/>
									<input class="ml-button mlbtn-action" type="submit" value="'.ML_BUTTON_LABEL_SAVE_DATA.'"/>
								</td>
							</tr></tbody></table>
						</td></tr>
					</tbody>
				</table>
			</form>
			<div id="infodiag" class="dialog2" title="'.ML_LABEL_INFORMATION.'"></div>';
        if (    ('tinyMCE' == getDBConfigValue('general.editor',0,'tinyMCE'))
		     && (strpos($html, 'tinymce') !== false)) {
			$langCode = MagnaDB::gi()->fetchOne('
				SELECT code FROM '.TABLE_LANGUAGES.' WHERE languages_id=\''.$_SESSION['languages_id'].'\' LIMIT 1
			');
			if (!empty($langCode) && file_exists(DIR_MAGNALISTER_FS.'js/tinymce/langs/'.$langCode.'.js')) {
				$langCode = 'language: "'.$langCode.'",';
			} else {
				$langCode = '';
			}
			echo '
			<script type="text/javascript" src="'.DIR_MAGNALISTER_WS.'js/tinymce/tinymce.min.js"></script>';
			ob_start();?>
	        <script type="text/javascript">/*<![CDATA[*/
	        	<?php echo getTinyMCEDefaultConfigObject(); ?>
				$(window).load(function() {
					tinyMCE.init(tinyMCEMagnaDefaultConfig);
				});
			/*]]>*/</script><?php
			$html .= ob_get_contents();
			ob_end_clean();
	
		}
		$html .= '
	        <script type="text/javascript">/*<![CDATA[*/';
	        
		if ($descCount > 0) {
			$html .= '
				$(document).ready(function() {';
			for (; $descCount > 0; --$descCount) {
				$html .= '
					$(\'#desc_'.($descCount - 1).'\').click(function () {
						var d = $(\'#desc_'.($descCount - 1).' span\').html();
						$(\'#infodiag\').html(d).jDialog({\'width\': (d.length > 1000) ? \'700px\' : \'500px\'});
					});';
			}
			$html .= '
				});';
		}

		$html .= '
				$(document).ready(function() {
					$(\'form#'.($this->id ? $this->id : 'config').' input[type="password"]\').focus(function() {
						$(\'label.savedPassword\', $(this).parent()).addClass(\'partial\');
					}).blur(function() {
						$(\'label.savedPassword\', $(this).parent()).removeClass(\'partial\');
					}).keyup(function() {
						if ($(this).val() != \'\') {
							$(\'label.savedPassword\', $(this).parent()).addClass(\'hidden\');
						} else {
							$(\'label.savedPassword\', $(this).parent()).removeClass(\'hidden\');
						}
					});
				});
				/* Disable autocompleted passwords though browser. Can\'t use autocomplete="off" for the entire form. */
				$(window).load(function() {
					$(\'form#'.($this->id ? $this->id : 'config').' input[type="password"]\').each(function() {
						if (jQuery.trim($(this).val()) != \'\') {
							// remove from browser autocompleted field
						 	$(this).val(\'\');
						}
					});
				});';
		if (!empty($this->ajaxUpdateFuncs)) {
			$funcCall = '';
			foreach ($this->ajaxUpdateFuncs as $ajx) {
				$funcCall .= '
					$(\'#'.$ajx['fromid'].'\').change(function() {
						magna'.$ajx['func'].'();
					});
					'.((!array_key_exists('initload', $ajx) || $ajx['initload']) 
						? 'magna'.$ajx['func'].'();' 
						: ''
					);

				$html .= '
				function magna'.$ajx['func'].'() {
					jQuery.blockUI(blockUILoading); 
					jQuery.ajax({
						type: \'POST\',
						url: \''.toURL($this->realUrl, array('kind' => 'ajax'), true).'\',
						data: {
							\'action\': \'update\',
							\'function\': \''.$ajx['func'].'\',
							\'key\': \''.$ajx['key'].'\',
							\'value\': $(\'#'.$ajx['fromid'].'\').val()
						},
						success: function(data) {
							jQuery.unblockUI();
							el = $(\'#'.$ajx['toid'].'\');
							if (el.is(\'select\')) {
								el.html(data);
							} else {
								el.val(data);
							}
						},
						error: function (xhr, status, error) {
							jQuery.unblockUI();
						},
						dataType: \'html\'
					});
				}';
			}
			$html .= '
				$(document).ready(function() {
					'.$funcCall.'
				});';
		}
		if ($this->renderResetJS) {
			$html .= '
				function resetDefaults(configKey) {
					confField = $(\'#\'+configKey);
					myConsole.log(confField);
					if (confField.length > 0) {
						jQuery.ajax({
							type: \'POST\',
							url: \''.toURL($this->realUrl, array('kind' => 'ajax'), true).'\',
							data: {
								\'action\': \'getDefault\',
								\'key\': configKey
							},
							success: function(data) {
								confField.val(data);
								if (confField.hasClass(\'tinymce\')) {
									tinyMCE.get(configKey).setContent(confField.val());
								}
							},
							dataType: \'html\'
						});
					}
				}';
		}

		$html .= '				
			/*]]>*/</script>';
		return $html;
	}

	/**
	 * popup dialog for checkboxes, appears when activating,
	 * leaves the checkbox active if clicked yes, or switches it of if clicked no
	 *
	 * currently used for exchangeRateAlert (in ALL module configs, so be careful when changing things here)
	 */
	public function checkboxAlert($sCheckboxId, $sTitle, $sText, $yes = ML_BUTTON_LABEL_YES, $no = ML_BUTTON_LABEL_NO) {
		ob_start();?>
		<script type="text/javascript">/*<!CDATA[*/
		$('input[id="<?php echo $sCheckboxId;?>"]').change(function() {
    		var chbx = $(this);
    		if (chbx.attr('checked') != 'checked') return true;
			chbx.removeAttr('checked');
    		$('<div></div>').html('<?php echo $sText ?>').jDialog({
				title: '<?php echo $sTitle ?>',
				buttons: {
					'<?php echo ML_BUTTON_LABEL_NO; ?>': function() {
						chbx.removeAttr('checked');
						jQuery(this).dialog('close');
					},
					'<?php echo ML_BUTTON_LABEL_YES; ?>': function() {
						chbx.attr('checked', 'checked');
						jQuery(this).dialog('close');
					}
				}
			});
		});
		/*]]>*/</script><?php
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	public function exchangeRateAlert($sCheckboxId = false) {
		global $_MagnaSession;
		if (!$sCheckboxId) {
			if (    (!array_key_exists('currentPlatform',$_MagnaSession))
			     || empty($_MagnaSession['currentPlatform'])
			) {
				return '';
			}
			// it's mostly like this, only hood has other name
			$sCheckboxId = 'conf_'.$_MagnaSession['currentPlatform'].'.exchangerate_update';
		}
		return $this->checkboxAlert($sCheckboxId,
			ML_TITLE_WARNING_AUTO_EXCHANGE_RATE_UPDATE,
			ML_TEXT_WARNING_AUTO_EXCHANGE_RATE_UPDATE,
			ML_BUTTON_LABEL_YES,
			ML_BUTTON_LABEL_NO);
	}

	/**
	 * popup dialog for radio buttons, appears when chosen yes,
	 * leaves on yes if clicked yes in dialog, or goes back to no if no.
	 *
	 */
	public function radioAlert($sRadio, $sTitle, $sText, $yes = ML_BUTTON_LABEL_YES, $no = ML_BUTTON_LABEL_NO) {
		ob_start();?>
		<script type="text/javascript">/*<!CDATA[*/
		$('input[id="<?php echo $sRadio.'_true';?>"]').change(function() {
    		var rdio = $(this);
    		if (rdio.attr('checked') != 'checked') return true;
			$('input[id="<?php echo $sRadio.'_false';?>"]').attr('checked', 'checked');
			rdio.removeAttr('checked');
    		$('<div></div>').html('<?php echo $sText ?>').jDialog({
				title: '<?php echo $sTitle ?>',
				buttons: {
					'<?php echo ML_BUTTON_LABEL_NO; ?>': function() {
						jQuery(this).dialog('close');
					},
					'<?php echo ML_BUTTON_LABEL_YES; ?>': function() {
						$('input[id="<?php echo $sRadio.'_false';?>"]').removeAttr('checked');
						rdio.attr('checked', 'checked');
						jQuery(this).dialog('close');
					}
				}
			});
		});
		/*]]>*/</script><?php
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}

	/*
	 * disable one or more fields when a 2-value radio button is set to true
	 * field types implemented so far: selects, checkboxes, texts
	 * 
	 * currently not used (was intended for eBay, it's tested and works, but then
	 * we need addionally an alert there, which is too complex for an universal function)
	 * 
	 * format:
	 * disableFieldsIfRadioOn (array (
	 *		'selects' => array ('sel1', 'sel2', ...),
	 *		'checkboxes' => array ('chb1', 'chb2', ...),
	 *		'texts' => array ('txt1', 'txt2', ...),
	 *		),
	 *		'radioFieldIdWithoutTrueOrFalse'
	 *		);
	 */
	public function disableFieldsIfRadioOn($aFields, $sRadio) {
		if (!is_array($aFields)) {
			if (is_string($aFields) && !empty($aFields)) {
				$aFields = array('texts' => array($aFields));
			} else {
				return '';
			}
		}
		ob_start();?>
		<script type="text/javascript">/*<!CDATA[*/
		if ($('input[id="<?php echo $sRadio.'_true';?>"]').attr('checked') == 'checked') {
			<?php if (array_key_exists('selects', $aFields) && is_array($aFields['selects'])) {
				foreach ($aFields['selects'] as $sField) { ?>
			$('select[id="<?php echo $sField ?>"]').prop('disabled', true);
			<?php } 
			  }
			      if (array_key_exists('checkboxes', $aFields) && is_array($aFields['checkboxes'])) {
				foreach ($aFields['checkboxes'] as $sField) { ?>
			$('input[id="<?php echo $sField ?>"]').prop('checked', false);
			$('input[id="<?php echo $sField ?>"]').prop('disabled', true);
			<?php }
			  }
			      if (array_key_exists('texts', $aFields) && is_array($aFields['texts'])) {
				foreach ($aFields['texts'] as $sField) { ?>
			$('input[id="<?php echo $sField ?>"]').prop('disabled', true);
			<?php }
			  } ?>
		}
		$('input[id="<?php echo $sRadio.'_true';?>"]').change(function() {
    		var rdio = $(this);
    		if (rdio.attr('checked') == 'checked') {
			<?php if (array_key_exists('selects', $aFields) && is_array($aFields['selects'])) {
				foreach ($aFields['selects'] as $sField) { ?>
			$('select[id="<?php echo $sField ?>"]').prop('disabled', true);
			<?php } 
			  }
			      if (array_key_exists('checkboxes', $aFields) && is_array($aFields['checkboxes'])) {
				foreach ($aFields['checkboxes'] as $sField) { ?>
			$('input[id="<?php echo $sField ?>"]').prop('checked', false);
			$('input[id="<?php echo $sField ?>"]').prop('disabled', true);
			<?php }
			  }
			      if (array_key_exists('texts', $aFields) && is_array($aFields['texts'])) {
				foreach ($aFields['texts'] as $sField) { ?>
			$('input[id="<?php echo $sField ?>"]').prop('disabled', true);
			<?php }
			  } ?>
			}
		});
		$('input[id="<?php echo $sRadio.'_false';?>"]').change(function() {
    		var rdio = $(this);
    		if (rdio.attr('checked') == 'checked') {
			<?php if (array_key_exists('selects', $aFields) && is_array($aFields['selects'])) {
				foreach ($aFields['selects'] as $sField) { ?>
			$('select[id="<?php echo $sField ?>"]').prop('disabled', false);
			<?php } 
			  }
			      if (array_key_exists('checkboxes', $aFields) && is_array($aFields['checkboxes'])) {
				foreach ($aFields['checkboxes'] as $sField) { ?>
			$('input[id="<?php echo $sField ?>"]').prop('disabled', false);
			<?php } 
			  }
			      if (array_key_exists('texts', $aFields) && is_array($aFields['texts'])) {
				foreach ($aFields['texts'] as $sField) { ?>
			$('input[id="<?php echo $sField ?>"]').prop('disabled', false);
			<?php }
			  } ?>
			}
		});
		/*]]>*/</script><?php
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}

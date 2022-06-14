<?php
/* -----------------------------------------------------------------------------------------
   $Id: message_stack.php 9918 2016-06-01 12:23:58Z GTB $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(message_stack.php,v 1.1 2003/05/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (message_stack.php,v 1.9 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License
   Example usage:
   $messageStack = new messageStack();
   $messageStack->add('general', 'Error: Error 1', 'error');
   $messageStack->add('general', 'Error: Error 2', 'warning');
   if ($messageStack->size('general') > 0) echo $messageStack->output('general');
   ---------------------------------------------------------------------------------------*/

  class messageStack {

    function __construct() {
      $this->messages = array();
      if (isset($_SESSION['messageToStack'])) {
        for ($i=0, $n=sizeof($_SESSION['messageToStack']); $i<$n; $i++) {
          $this->add($_SESSION['messageToStack'][$i]['class'], $_SESSION['messageToStack'][$i]['text'], $_SESSION['messageToStack'][$i]['type']);
        }
        unset($_SESSION['messageToStack']);
      }
    }

    function add($class, $message, $type = 'error') {
      $this->messages[$class][$type][] = $message;
    }

    function add_session($class, $message, $type = 'error') {
      if (!isset($_SESSION['messageToStack'])) {
        $_SESSION['messageToStack'] = array();
      }
      $_SESSION['messageToStack'][] = array('class' => $class, 'text' => $message, 'type' => $type);
    }

    function reset() {
      $this->messages = array();
    }

    function size($class, $type = 'error') {
      $count = 0;
      if (isset($this->messages[$class][$type])) {
        $count = count($this->messages[$class][$type]);
      }
      return $count;
    }

    function output($class, $type = 'error') {
      $output = '';
      if ($this->size($class, $type) > 0) {
        foreach ($this->messages[$class][$type] as $message) {
          $output .= '<p>'.$message.'</p>';
        }
      }
      return $output;
    }
  }
?>
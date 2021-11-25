<?php
/* -----------------------------------------------------------------------------------------
   $Id: orders_paypal_data.php 13104 2020-12-18 11:28:52Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

if (isset($order) && is_object($order)) {
  if ($order->info['payment_method'] == 'paypalclassic' 
      || $order->info['payment_method'] == 'paypalcart'
      || $order->info['payment_method'] == 'paypalplus'
      || $order->info['payment_method'] == 'paypallink'
      || $order->info['payment_method'] == 'paypalpluslink'
      || $order->info['payment_method'] == 'paypalsubscription'
      ) 
  {
    require_once (DIR_FS_INC.'xtc_format_price_order.inc.php');

    require_once(DIR_FS_EXTERNAL.'paypal/classes/PayPalInfo.php');
    $paypal = new PayPalInfo($order->info['payment_method']);
      
    if ($order->info['payment_method'] == 'paypalsubscription') {
      $admin_info_array = $paypal->subscription_info($order->info['order_id']);
    } else {
      // payment
      $admin_info_array = $paypal->order_info($order->info['order_id']);
    }
  
    if (count($admin_info_array) > 0) {
      ?>          
      <table border="0" width="100%" cellspacing="0" cellpadding="2" class="dataTableRow paypal_data" style="display:none;">
        <tr>
          <td width="100%" valign="top">
            <div class="pp_transactions pp_box">
              <div class="pp_boxheading"><?php echo TEXT_PAYPAL_TRANSACTION; ?></div>
              <dl class="pp_transaction">
                <dt><?php echo TEXT_PAYPAL_TRANSACTION_ADDRESS; ?></dt>
                <dd><?php echo xtc_address_format($order->customer['address_format_id'], $admin_info_array['address'], 1, '', '<br />'); ?></dd>
              </dl>
              <dl class="pp_transaction">
                <dt><?php echo TEXT_PAYPAL_TRANSACTION_METHOD; ?></dt>
                <dd><?php echo $admin_info_array['payment_method']; ?></dd>
              </dl>
              <dl class="pp_transaction">
                <dt><?php echo TEXT_PAYPAL_TRANSACTION_ACCOUNT_OWNER; ?></dt>
                <dd><?php echo $admin_info_array['address']['name']; ?></dd>
              </dl>
              <dl class="pp_transaction">
                <dt><?php echo TEXT_PAYPAL_TRANSACTION_EMAIL; ?></dt>
                <dd><?php echo $admin_info_array['email_address']; ?></dd>
              </dl>
              <?php if ($admin_info_array['account_status'] != '') { ?>
              <dl class="pp_transaction">
                <dt><?php echo TEXT_PAYPAL_TRANSACTION_ACCOUNT_STATE; ?></dt>
                <dd><?php echo $admin_info_array['account_status']; ?></dd>
              </dl>
              <?php } ?>
              <?php if ($admin_info_array['intent'] != '') { ?>
              <dl class="pp_transaction">
                <dt><?php echo TEXT_PAYPAL_TRANSACTION_INTENT; ?></dt>
                <dd><?php echo $admin_info_array['intent']; ?></dd>
              </dl>
              <?php } ?>
              <?php if ($admin_info_array['total'] > 0) { ?>
              <dl class="pp_transaction">
                <dt><?php echo TEXT_PAYPAL_TRANSACTIONS_TOTAL; ?></dt>
                <dd><?php echo xtc_format_price_order($admin_info_array['total'], 1, $admin_info_array['transactions'][0]['relatedResource'][0]['currency'], 1); ?></dd>
              </dl>
              <?php } ?>
              <dl class="pp_transaction">
                <dt><?php echo TEXT_PAYPAL_TRANSACTION_STATE; ?></dt>
                <dd><?php echo $admin_info_array['state']; ?></dd>
              </dl>
            </div>
            
            <?php
            if (isset($admin_info_array['billing'])
                && count($admin_info_array['billing']) > 0
                )
            {
              ?>
              <div class="pp_txstatus pp_box">
                <div class="pp_boxheading"><?php echo TEXT_PAYPAL_BILLING; ?></div>
                <dl class="pp_transaction">
                  <dt><?php echo TEXT_PAYPAL_BILLING_OUTSTANDING; ?></dt>
                  <dd><?php echo xtc_format_price_order($admin_info_array['billing']['outstanding_balance'], 1, $admin_info_array['billing']['currency'], 1); ?></dd>
                </dl>
                <dl class="pp_transaction">
                  <dt><?php echo TEXT_PAYPAL_BILLING_CYCLES_COMPLETED; ?></dt>
                  <dd><?php echo $admin_info_array['billing']['cycle_executions']['cycles_completed']; ?></dd>
                </dl>
                <dl class="pp_transaction">
                  <dt><?php echo TEXT_PAYPAL_BILLING_CYCLES_REMAINING; ?></dt>
                  <dd><?php echo $admin_info_array['billing']['cycle_executions']['cycles_remaining']; ?></dd>
                </dl>
                <dl class="pp_transaction">
                  <dt><?php echo TEXT_PAYPAL_BILLING_CYCLES_TOTAL; ?></dt>
                  <dd><?php echo $admin_info_array['billing']['cycle_executions']['total_cycles']; ?></dd>
                </dl>
                <dl class="pp_transaction">
                  <dt><?php echo TEXT_PAYPAL_BILLING_TIME_NEXT; ?></dt>
                  <dd><?php echo xtc_datetime_short($admin_info_array['billing']['next_billing_time']); ?></dd>
                </dl>
                <dl class="pp_transaction">
                  <dt><?php echo TEXT_PAYPAL_BILLING_TIME_FINAL; ?></dt>
                  <dd><?php echo xtc_datetime_short($admin_info_array['billing']['final_payment_time']); ?></dd>
                </dl>
                <dl class="pp_transaction">
                  <dt><?php echo TEXT_PAYPAL_BILLING_FAILED; ?></dt>
                  <dd><?php echo $admin_info_array['billing']['failed_payments_count']; ?></dd>
                </dl>
              </div>
              <div style="clear:both;"></div>
            <?php } ?>
            
            <?php
            if (isset($admin_info_array['transactions'])
                && count($admin_info_array['transactions']) > 0
                )
            {
              ?>
              <div class="pp_txstatus pp_box">
              <div class="pp_boxheading"><?php echo TEXT_PAYPAL_TRANSACTIONS_STATUS; ?></div>
              <?php
              $status_array = array();
              $type_array = array();
              $amount_array = array();
              
              for ($t=0, $z=count($admin_info_array['transactions']); $t<$z; $t++) {
                for ($i=0, $n=count($admin_info_array['transactions'][$t]['relatedResource']); $i<$n; $i++) {
                  $status_array[] = $admin_info_array['transactions'][$t]['relatedResource'][$i]['state'];
                  $type_array[] = $admin_info_array['transactions'][$t]['relatedResource'][$i]['type'];
                  
                  if (!isset($amount_array[$admin_info_array['transactions'][$t]['relatedResource'][$i]['type']])) {
                    $amount_array[$admin_info_array['transactions'][$t]['relatedResource'][$i]['type']] = 0;
                  }
                  $amount_array[$admin_info_array['transactions'][$t]['relatedResource'][$i]['type']] += (($admin_info_array['transactions'][$t]['relatedResource'][$i]['total'] < 0) ? ($admin_info_array['transactions'][$t]['relatedResource'][$i]['total'] * (-1)) : $admin_info_array['transactions'][$t]['relatedResource'][$i]['total']);
                  ?>
                  <div class="pp_txstatus">
                    <div class="pp_txstatus_received pp_received_icon">
                      <?php echo xtc_datetime_short($admin_info_array['transactions'][$t]['relatedResource'][$i]['date']) . ' ' . $admin_info_array['transactions'][$t]['relatedResource'][$i]['type']; ?>
                    </div>
                    <div class="pp_txstatus_data">
                      <?php
                      if ($admin_info_array['transactions'][$t]['relatedResource'][$i]['payment'] != '') {
                      ?>
                        <dl class="pp_txstatus_data_list">
                          <dt><?php echo TEXT_PAYPAL_TRANSACTIONS_PAYMENT; ?></dt>
                          <dd><?php echo $admin_info_array['transactions'][$t]['relatedResource'][$i]['payment']; ?></dd>
                        </dl>
                      <?php
                      }
                      if ($admin_info_array['transactions'][$t]['relatedResource'][$i]['reason'] != '') {
                      ?>
                        <dl class="pp_txstatus_data_list">
                          <dt><?php echo TEXT_PAYPAL_TRANSACTIONS_REASON; ?></dt>
                          <dd><?php echo $admin_info_array['transactions'][$t]['relatedResource'][$i]['reason']; ?></dd>
                        </dl>
                      <?php
                      }
                      ?>
                      <dl class="pp_txstatus_data_list">
                        <dt><?php echo TEXT_PAYPAL_TRANSACTIONS_STATE; ?></dt>
                        <dd><?php echo $admin_info_array['transactions'][$t]['relatedResource'][$i]['state']; ?></dd>
                      </dl>
                      <dl class="pp_txstatus_data_list">
                        <dt><?php echo TEXT_PAYPAL_TRANSACTIONS_TOTAL; ?></dt>
                        <dd><?php echo xtc_format_price_order($admin_info_array['transactions'][$t]['relatedResource'][$i]['total'], 1, $admin_info_array['transactions'][$t]['relatedResource'][$i]['currency'], 1); ?></dd>
                      </dl>
                      <?php
                      if ($admin_info_array['transactions'][$t]['relatedResource'][$i]['valid'] != '') {
                      ?>
                        <dl class="pp_txstatus_data_list">
                          <dt><?php echo TEXT_PAYPAL_TRANSACTIONS_VALID; ?></dt>
                          <dd><?php echo xtc_datetime_short($admin_info_array['transactions'][$t]['relatedResource'][$i]['valid']); ?></dd>
                        </dl>
                      <?php
                      }
                      ?>
                      <dl class="pp_txstatus_data_list">
                        <dt><?php echo TEXT_PAYPAL_TRANSACTIONS_ID; ?></dt>
                        <dd><?php echo $admin_info_array['transactions'][$t]['relatedResource'][$i]['id']; ?></dd>
                      </dl>
                    </div>
                  </div>
                  <?php
                }
              }
              ?>
            </div>
            <div style="clear:both;"></div>
            <?php
            }
            
            if (isset($admin_info_array['instruction'])) {
              ?>
              <div class="pp_transactions pp_box">
                <div class="pp_boxheading"><?php echo TEXT_PAYPAL_INSTRUCTIONS; ?></div>
                <dl class="pp_transaction">
                  <dt><?php echo TEXT_PAYPAL_INSTRUCTIONS_AMOUNT; ?></dt>
                  <dd><?php echo $admin_info_array['instruction']['amount']['total'].' '.$admin_info_array['instruction']['amount']['currency']; ?></dd>
                </dl>
                <dl class="pp_transaction">
                  <dt><?php echo TEXT_PAYPAL_INSTRUCTIONS_REFERENCE; ?></dt>
                  <dd><?php echo $admin_info_array['instruction']['reference']; ?></dd>
                </dl>
                <dl class="pp_transaction">
                  <dt><?php echo TEXT_PAYPAL_INSTRUCTIONS_PAYDATE; ?></dt>
                  <dd><?php echo $admin_info_array['instruction']['date']; ?></dd>
                </dl>
                <dl class="pp_transaction">
                  <dt><?php echo TEXT_PAYPAL_INSTRUCTIONS_ACCOUNT; ?></dt>
                  <dd><?php echo $admin_info_array['instruction']['bank']['name']; ?></dd>
                </dl>
                <dl class="pp_transaction">
                  <dt><?php echo TEXT_PAYPAL_INSTRUCTIONS_HOLDER; ?></dt>
                  <dd><?php echo $admin_info_array['instruction']['bank']['holder']; ?></dd>
                </dl>
                <dl class="pp_transaction">
                  <dt><?php echo TEXT_PAYPAL_INSTRUCTIONS_IBAN; ?></dt>
                  <dd><?php echo $admin_info_array['instruction']['bank']['iban']; ?></dd>
                </dl>
                <dl class="pp_transaction">
                  <dt><?php echo TEXT_PAYPAL_INSTRUCTIONS_BIC; ?></dt>
                  <dd><?php echo $admin_info_array['instruction']['bank']['bic']; ?></dd>
                </dl>
              </div>
              <?php
            }

            if ($admin_info_array['state'] == 'ACTIVE') {
              ?>
              <div class="pp_capture pp_box">
                <div class="pp_boxheading"><?php echo TEXT_PAYPAL_CANCEL; ?></div>
                <?php 
                  echo xtc_draw_form('capture', xtc_href_link(FILENAME_ORDERS, xtc_get_all_get_params(array('action','subaction', 'ext', 'sec')).'action=custom&subaction=paypalaction', 'NONSSL'), 'post');
                  if (CSRF_TOKEN_SYSTEM == 'true' && isset($_SESSION['CSRFToken']) && isset($_SESSION['CSRFName'])) {
                    echo xtc_draw_hidden_field($_SESSION['CSRFName'], $_SESSION['CSRFToken']);
                  }
                  echo xtc_draw_hidden_field('cmd', 'cancel');
                ?>
                <br />
                <input type="submit" class="button" name="capture_submit" value="<?php echo TEXT_PAYPAL_CANCEL_SUBMIT; ?>">
                </form>
              </div>
              <?php 
            } 

            $count = array_count_values($type_array);
            if (!isset($count['capture'])) $count['capture'] = 0;
            if (!isset($count['refund'])) $count['refund'] = 0;
            
            if ($admin_info_array['intent'] == 'authorize' 
                && (!isset($amount_array['capture'])
                    || $admin_info_array['total'] > $amount_array['capture']
                    )
                )
            {
              ?>
              <div class="pp_capture pp_box">
                <div class="pp_boxheading"><?php echo TEXT_PAYPAL_CAPTURE; ?></div>
                <?php 
                  echo xtc_draw_form('capture', xtc_href_link(FILENAME_ORDERS, xtc_get_all_get_params(array('action','subaction', 'ext', 'sec')).'action=custom&subaction=paypalaction', 'NONSSL'), 'post');
                  if (CSRF_TOKEN_SYSTEM == 'true' && isset($_SESSION['CSRFToken']) && isset($_SESSION['CSRFName'])) {
                    echo xtc_draw_hidden_field($_SESSION['CSRFName'], $_SESSION['CSRFToken']);
                  }
                  echo xtc_draw_hidden_field('cmd', 'capture');

                  echo '<div class="refund_row">';
                  echo '<div class="'.(((10 - $count['capture']) > 0) ? 'info_message' : 'error_message').'">'.TEXT_PAYPAL_CAPTURE_LEFT . ' ' . (10 - $count['capture']).'</div>';
                  echo '<br/>';
                  echo '<label for="final_capture">'.TEXT_PAYPAL_CAPTURE_IS_FINAL.'</label>';
                  echo xtc_draw_checkbox_field('final_capture', '1', '', 'id="final_capture"');
                  echo '<br/>';
                  echo '<label for="capture_price">'.TEXT_PAYPAL_CAPTURE_AMOUNT.'</label>';
                  echo xtc_draw_input_field('capture_price', '', 'id="capture_price" style="width: 135px"');
                  echo '</div>';
                ?>
                <br />
                <input type="submit" class="button" name="capture_submit" value="<?php echo TEXT_PAYPAL_CAPTURE_SUBMIT; ?>">
                </form>
              </div>
              <?php 
            } 

            if ((in_array('captured', $status_array)
                 || in_array('completed', $status_array)
                 ) && (!isset($amount_array['refund'])
                       || $admin_info_array['total'] > $amount_array['refund']
                       )
                )
            {
              ?>
              <div class="pp_capture pp_box">
                <div class="pp_boxheading"><?php echo TEXT_PAYPAL_REFUND; ?></div>
                <?php 
                  echo xtc_draw_form('capture', xtc_href_link(FILENAME_ORDERS, xtc_get_all_get_params(array('action','subaction', 'ext', 'sec')).'action=custom&subaction=paypalaction', 'NONSSL'), 'post');
                  if (CSRF_TOKEN_SYSTEM == 'true' && isset($_SESSION['CSRFToken']) && isset($_SESSION['CSRFName'])) {
                    echo xtc_draw_hidden_field($_SESSION['CSRFName'], $_SESSION['CSRFToken']);
                  }
                  echo xtc_draw_hidden_field('cmd', 'refund');

                  echo '<div class="refund_row">';
                  echo '<div class="'.(((10 - $count['refund']) > 0) ? 'info_message' : 'error_message').'">'.TEXT_PAYPAL_REFUND_LEFT . ' ' . (10 - $count['refund']).'</div>';
                  echo '<br/>';
                  echo '<label for="refund_comment" style="vertical-align: top; margin-top: 5px;">'.TEXT_PAYPAL_REFUND_COMMENT.'</label>';
                  echo xtc_draw_textarea_field('refund_comment', '', '60', '8', '', 'id="refund_comment" maxlength="127"');
                  echo '<br/>';
                  echo '<label for="refund_price">'.TEXT_PAYPAL_REFUND_AMOUNT.'</label>';
                  echo xtc_draw_input_field('refund_price', '', 'id="refund_price" style="width: 135px"');
                  echo '</div>';
                ?>
                <br />
                <input type="submit" class="button" name="refund_submit" value="<?php echo TEXT_PAYPAL_REFUND_SUBMIT; ?>">
                </form>
              </div>
              <?php 
            } 
            ?>
          </td>
        </tr>
      </table>  
    <?php
    } else {
    ?>
      <table border="0" width="100%" cellspacing="0" cellpadding="2" class="dataTableRow paypal_data" style="display:none;">
        <tr>
          <td width="100%" valign="top">
            <div class="info_message"><?php echo TEXT_PAYPAL_NO_INFORMATION; ?></div>
          </td>
        </tr>
      </table>
    <?php
    }
  }
  ?>
  <script type="text/javascript">
    $(function() {
      $('div.pp_txstatus_received').not('.pp_txstatus_open').click(function(e) {
        if ($(this).hasClass('pp_txstatus_open')) {
          $('div.pp_txstatus_received').removeClass('pp_txstatus_open');
          $('div.pp_txstatus_data', $(this).parent()).hide();
        } else {
          $('div.pp_txstatus_received').removeClass('pp_txstatus_open');
          $(this).addClass('pp_txstatus_open');
          $('div.pp_txstatus_data').hide();
          $('div.pp_txstatus_data', $(this).parent()).show();
        }
      });
    });
  </script>
  <?php
}
?>
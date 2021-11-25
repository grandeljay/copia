<?php
/* --------------------------------------------------------------
  $Id: credits.php 12460 2019-12-04 10:04:20Z Tomcraft $

  modified eCommerce Shopsoftware
  http://www.modified-shop.org

  Copyright (c) 2009 - 2013 [www.modified-shop.org]
  --------------------------------------------------------------
  based on:
  (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
  (c) 2002-2003 osCommercecoding standards (a typical file) www.oscommerce.com
  (c) 2003 nextcommerce (start.php,v 1.6 2003/08/19); www.nextcommerce.org
  (c) 2006 XT-Commerce (credits.php 1263 2005-09-30)

  Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');
require (DIR_WS_INCLUDES.'head.php');
?>
  <style type="text/css">
    #credits {
      margin: 5px;
      padding: 0px 20px;
      background-color: #F7F7F7;
      font-family: Verdana, Arial, sans-serif;
      font-size: 12px;
      width: 980px;
    }
    dl dd {
      margin-left: 10px;
    }
    #contentHead dt {
      float: right;
    }
    #contentHead dd {
      margin-left: 80px;
    }
    #credits dl dt {
      color: #D68000;
      font-size: 12px;
      font-weight: bold;
      margin: 10px 0;
    }
    dl#person dt, dl#donate dt {
      color: black;
      font-weight: bold;
      float: left;
      font-size: 12px;
      margin:0;
    }
    dl#person dd {
      margin-left: 125px;
      font-size: 12px;
    }
    dl#donate dd {
      margin-left: 80px;
      font-size: 12px;
    }
  </style>
</head>
<body>
    <!-- header //-->
    <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
    <!-- header_eof //-->

    <!-- body //-->
    <table class="tableBody">
      <tr>
        <?php //left_navigation
        if (USE_ADMIN_TOP_MENU == 'false') {
          echo '<td class="columnLeft2">'.PHP_EOL;
          echo '<!-- left_navigation //-->'.PHP_EOL;       
          require_once(DIR_WS_INCLUDES . 'column_left.php');
          echo '<!-- left_navigation eof //-->'.PHP_EOL; 
          echo '</td>'.PHP_EOL;      
        }
        ?>
        <!-- body_text //-->
        <td class="boxCenter">         
          <div id="credits">
            <div class="pageHeadingImage"><?php echo xtc_image(DIR_WS_ICONS.'heading/icon_news.png'); ?></div>
            <div class="pageHeading pdg2"><?php echo HEADING_TITLE; ?></div>
            <span class="main"><?php echo HEADING_SUBTITLE; ?></span>
            <div class="clear"></div>
            <dl>
              <dt><?php echo PROJECT_VERSION; ?></dt>
              <dt><?php echo TEXT_DB_VERSION.' "'.DB_VERSION.'"'; ?></dt>
            </dl>
            <?php echo TEXT_HEADING_GPL; ?><br /><br />
            <?php echo TEXT_INFO_GPL; ?>
            <br />
            <br />
            <p><?php echo TEXT_INFO_THANKS; ?></p>
            <p><?php echo TEXT_INFO_DISCLAIMER; ?></p>
            <hr />
            <table style="border:0; padding:8px; width:100%;">
              <tr>
                <td style="width:50%; vertical-align:top">
                  <dl>
                    <dt><?php echo TEXT_HEADING_DEVELOPERS; ?></dt>
                    <dd>
                      <dl id="person"> <!-- sorted by board user-id -->
                        <dt>Tomcraft</dt><dd>&lt;tomcraft@modified-shop.org&gt;</dd> <!-- 88 -->
                        <dt>GTB</dt><dd>&lt;gtb@modified-shop.org&gt;</dd> <!-- 595 -->
                        <dt>Hetfield</dt><dd>&lt;hetfield@modified-shop.org&gt;</dd> <!-- 1027 -->
                        <dt>Markus</dt><dd>&lt;markus@modified-shop.org&gt;</dd> <!-- 1255 -->
                        <dt>vr</dt><dd>&lt;vr@modified-shop.org&gt;</dd> <!-- 1641 -->
                        <dt>h-h-h</dt><dd>&lt;h-h-h@modified-shop.org&gt;</dd> <!-- 3386 -->
                        <dt>cYbercOsmOnauT</dt><dd>&lt;cybercosmonaut@modified-shop.org&gt;</dd> <!-- 6446 -->
                        <dt>hellwanger</dt><dd>&lt;hellwanger@modified-shop.org&gt;</dd> <!-- 21189 -->
                        <dt>webald</dt><dd>&lt;webald@modified-shop.org&gt;</dd> <!-- 18826 -->
                        <dt>timopaul</dt><dd>&lt;timopaul@modified-shop.org&gt;</dd> <!-- 10390 -->
                        <dt>AGI</dt><dd>&lt;agi@modified-shop.org&gt;</dd> <!-- 10246 -->
                      </dl>
                    </dd>
                  </dl>
                  <dl>
                    <dt><?php echo TEXT_HEADING_FORMER_DEVELOPERS; ?></dt>
                    <dd>
                      <dl id="person"> <!-- sorted by board user-id -->
                        <dt>DokuMan</dt><dd>&lt;dokuman@modified-shop.org&gt;</dd> <!-- 190 -->
                        <dt><s>web28</s></dt><dd><s>&lt;web28@modified-shop.org&gt;</s> &dagger; 26.01.2018</dd> <!-- 308 -->
                        <dt>hendrik</dt><dd>&lt;hendrik@modified-shop.org&gt;</dd> <!-- 1281 -->
                        <dt>franky_n</dt><dd>&lt;franky_n@modified-shop.org&gt;</dd> <!-- 4516 -->
                      </dl>
                    </dd>
                  </dl>
                </td>
                <td style="width:50%; vertical-align:top">
                  <dl>
                    <dt><?php echo TEXT_HEADING_SUPPORT; ?></dt>
                    <dd>
                      <dl id="donate">
                        <dt><?php echo TEXT_HEADING_DONATIONS; ?></dt>
                        <dd><?php echo TEXT_INFO_DONATIONS; ?></dd>
                        <dt>&nbsp;</dt><dd>&nbsp;</dd>
                        <dt>&nbsp;</dt>
                        <dd>
                          <?php echo BUTTON_DONATE; ?>
                        </dd>
                      </dl>
                    </dd>
                  </dl>
                </td>
              </tr>
            </table>
            <hr />
            <dl>
              <dt style="color: #d68000; font-weight: bold;"><?php echo TEXT_HEADING_BASED_ON; ?></dt>
              <dd>
                <ul style="list-style: none; padding-left: 0px;">
                  <li><?php echo '&copy;2009-'.date('Y').'&nbsp;'; echo PROJECT_VERSION; ?> | http://www.modified-shop.org/</li>
                  <li>&copy;2006 xt:Commerce V3.0.4 SP2.1 | http://www.xtcommerce.de/</li>
                  <li>&copy;2003 neXTCommerce</li>
                  <li>&copy;2002-2003 osCommerce (Milestone2) by Harald Ponce de Leon | http://www.oscommerce.com/</li>
                  <li>&copy;2000-2001 The Exchange Project by Harald Ponce de Leon | http://www.oscommerce.com/</li>
                </ul>
              </dd>
            </dl>
          </div>
        </td>
        <!-- body_text_eof //-->
      </tr>
    </table>
    <!-- body_eof //-->
    <!-- footer //-->
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
    <!-- footer_eof //-->
  </body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
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
class ShopgateWrapper
{
    
    /**
     * Wraps for example: xtc_db_prepare_input
     *
     * @param string $input
     *
     * @return string
     */
    public static function db_prepare_input($input)
    {
        if (defined('PROJECT_MAJOR_VERSION')) {
            return xtc_db_input($input);
        } else {
            return xtc_db_prepare_input($input);
        }
    }
    
    /**
     * @param string $db_query
     *
     * @return mixed
     */
    public static function db_fetch_array($db_query)
    {
        return xtc_db_fetch_array($db_query);
        
    }
    
    /**
     * @param        $query
     * @param string $link
     *
     * @return mixed
     */
    public static function db_query($query, $link = 'db_link')
    {
        return xtc_db_query($query, $link);
    }
    
    /**
     * Checks if the column exists within the table
     *
     * @param $table
     * @param $column
     *
     * @return bool
     */
    public static function db_column_exists($table, $column)
    {
        $query  = "SHOW COLUMNS FROM {$table} LIKE '{$column}';";
        $result = xtc_db_query($query);
        
        return (bool)xtc_db_num_rows($result);
    }
}

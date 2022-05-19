<?php

/* -----------------------------------------------------------------------------------------
   $Id: check_permissions.php 13935 2022-01-12 12:28:33Z Tomcraft $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$permission_array = array(
    'file_permission'    => array(),
    'folder_permission'  => array(),
    'rfolder_permission' => array(),
);

$files_to_check = array(
    'files' => array(
        DIR_ADMIN . 'magnalister.php',
        'includes/configure.php',
        'magnaCallback.php',
        'sitemap.xml'
    ),
    'dirs'  => array(
        DIR_ADMIN . 'backups',
        DIR_ADMIN . 'images/graphs',
        DIR_ADMIN . 'images/icons',
        'cache',
        'export',
        'images',
        'images/banner',
        'images/categories',
        'images/content',
        'images/icons',
        'images/manufacturers',
        'images/product_images/original_images',
        'images/product_images/popup_images',
        'images/product_images/info_images',
        'images/product_images/midi_images',
        'images/product_images/thumbnail_images',
        'images/product_images/mini_images',
        'images/tags',
        'import',
        'log',
        'media/content',
        'media/content/backup',
        'media/products',
        'media/products/backup',
        'templates_c'
    ),
    'adirs' => array(
        'includes/external/magnalister',
        'templates/tpl_modified',
        'templates/xtc5'
    ),
    'rdirs' => array(
        'includes/external/magnalister'
    )
);

if (file_exists(DIR_FS_CATALOG . '/includes/local/configure.php')) {
    $files_to_check['files'][] = 'includes/local/configure.php';
}

foreach ($files_to_check['adirs'] as $dir) {
    if (is_dir(DIR_FS_CATALOG . $dir)) {
        $files_to_check['dirs'][] = $dir;
    }
}
unset($files_to_check['adirs']);

// login as ftp user to change permissions of every file and directory
if (isset($_POST['action']) && 'ftp' === $_POST['action']) {
    $anonymous = false;

    if (empty($_POST['ftp_user'])) {
        $_POST['ftp_user'] = 'anonymous';
        $anonymous         = true;
    }

    $ftp_host = $_POST['ftp_host'];
    $ftp_port = $_POST['ftp_port'];
    $ftp_path = trim($_POST['ftp_path'], '/');
    $ftp_user = $_POST['ftp_user'];
    $ftp_pass = $_POST['ftp_pass'];

    $ftp = ftp_connect($ftp_host, $ftp_port);
    if (!ftp_login($ftp, $ftp_user, $ftp_pass) || !is_resource($ftp)) {
        $error = true;
        $messageStack->add('ftp_message', ERROR_FTP_LOGIN_NOT_POSSIBLE);

        if (true === $anonymous) {
            $_POST['ftp_user'] = '';
        }
    }

    if (false === $error) {
        foreach ($files_to_check['rdirs'] as $dir) {
            if (is_dir(DIR_FS_CATALOG . $dir)) {
                $files_to_check = scanDirectories(DIR_FS_CATALOG . $dir, $files_to_check);
            }
        }

        foreach ($files_to_check as $type => $files) {
            if ('rdirs' !== $type) {
                foreach ($files as $file) {
                    if (ftp_chmod($ftp, CHMOD_WRITEABLE, '/' . $ftp_path . '/' . ltrim($file, '/')) === false) {
                        $messageStack->add('ftp_message', ERROR_FTP_CHMOD_WAS_NOT_SUCCESSFUL);
                        break 2;
                    }
                }
            }
        }
    }
    ftp_close($ftp);
}

// new testing of file permissions
foreach ($files_to_check as $type => $files) {
    foreach ($files as $file) {
        if ('rdirs' !== $type) {
            $current_permission = substr(sprintf('%o', fileperms(DIR_FS_CATALOG . $file)), -4);
            if (!is_make_writeable(DIR_FS_CATALOG . $file)) {
                if ('files' === $type) {
                    $error                                 = true;
                    $permission_array['file_permission'][] = $file;
                }
                if ('dirs' === $type) {
                    $error                                   = true;
                    $permission_array['folder_permission'][] = $file;
                }
            }
        } else {
            foreach ($files_to_check['rdirs'] as $dir) {
                if (is_dir(DIR_FS_CATALOG . $dir)) {
                    $rfiles_to_check[$dir] = scanDirectories(DIR_FS_CATALOG . $dir, array());
                }
            }
            if (is_array($rfiles_to_check)) {
                foreach ($rfiles_to_check as $key => $rdir) {
                    foreach ($rdir as $type => $files) {
                        foreach ($files as $file) {
                            if (!is_make_writeable(DIR_FS_CATALOG . $file) && $rfolder_flag != $key) {
                                $error                                    = true;
                                $rfolder_flag                             = true;
                                $permission_array['rfolder_permission'][] = $key;
                            }
                        }
                    }
                }
            }
        }
    }
}

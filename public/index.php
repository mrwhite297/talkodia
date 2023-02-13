<?php
$installationDir = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR. 'public/install';
if (is_dir($installationDir)) {
	if (is_file('install/install.php')) {
		require_once('install/install.php');
        die;
	} else {
        die('Error : Unable to locate installation files.');
    }
}
require_once dirname(__DIR__) . '/conf/conf.php';
require_once dirname(__FILE__) . '/application-top.php';
FatApp::unregisterGlobals();
if (file_exists(CONF_APPLICATION_PATH . 'utilities/prehook.php')) {
    require_once CONF_APPLICATION_PATH . 'utilities/prehook.php';
}
FatApplication::getInstance()->callHook();

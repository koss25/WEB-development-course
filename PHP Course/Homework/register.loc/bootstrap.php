<?php

defined('PROJECT') or die ('Access denied');

error_reporting(E_ALL);

require_once 'config.php';
require_once PATH.'/app/core/autoloader.php';
require_once PATH.'/app/core/traits/record.php';
spl_autoload_register('Autoloader::loadCoreClass');
spl_autoload_register('Autoloader::loadRecordClass');

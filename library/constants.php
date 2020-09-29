<?php

require_once 'credentials.php';

define('E_CSDD', 'https://e.csdd.lv/');
define('E_CSDD_LOGIN', $CSDD['login']);
define('E_CSDD_PASSWORD', $CSDD['password']);

define('DB_HOST', $DB['host']);
define('DB_BASE', $DB['base']);
define('DB_USER', $DB['user']);
define('DB_PASS', $DB['pass']);

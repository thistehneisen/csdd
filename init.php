<?php

require_once 'vendor/autoload.php';
require_once 'library/constants.php';

$db = new MysqliDb(DB_HOST, DB_USER, DB_PASS, DB_BASE);

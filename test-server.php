<?php
/*
 * PHP Simple HTTP Request
 *
 * Copyright (c) 2010, 2011 Igalia, S.L.
 * Licensed under the MIT license.
 */

echo '$_GET = ';
var_dump($_GET);

echo '$_POST = ';
var_dump($_POST);

echo '$_SERVER = ';
var_dump($_SERVER);

echo "php://input\n";
echo file_get_contents('php://input');
echo "\n";

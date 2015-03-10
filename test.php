<?php
/*
 * PHP Simple HTTP Request
 *
 * Copyright (c) 2010, 2011 Igalia, S.L.
 * Licensed under the MIT license.
 */

include('SimpleHttpRequest.php');

echo "---------GET request--------------------------------------------\n";

//GET request

$request = new SimpleHttpRequest("http://localhost/test-server.php");
$request->addParameter("parameter","value");

$request->init();
echo $request->doRequest();
$request->close();

echo "---------POST request-------------------------------------------\n";

//POST request

$request->setupPost('<?xml version="1.0"?><tag></tag>');

$request->init();
echo $request->doRequest();
$request->clearPost();
$request->close();

echo "---------request with HTTP header-------------------------------\n";

//request with parameters

$request->addHeader("Content-type", "text");

$request->init();
echo $request->doRequest();
$request->removeHeader("Content-type");
$request->close();

echo "---------request with error-------------------------------------\n";

//request with error

$request2 = new SimpleHttpRequest("http://this.url.doesnt.exist");

$request2->init();
if(!$request2->doRequest()) {
    echo $request2->getError() . "\n";
}
$request2->close();

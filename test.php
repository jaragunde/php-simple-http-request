<?php

include('SimpleHttpRequest.php');

//GET request

$request = new SimpleHttpRequest("http://www.example.com");
$request->addParameter("parameter","value");

$request->init();
echo $request->doRequest();
$request->close();

//POST request

$request->setupPost('<?xml version="1.0"?><tag></tag>');

$request->init();
echo $request->doRequest();
$request->clearPost();
$request->close();

//request with error

$request2 = new SimpleHttpRequest("http://this.url.doesnt.exist");

$request2->init();
if(!$request2->doRequest()) {
    echo $request2->getError() . "\n";
}
$request2->close();

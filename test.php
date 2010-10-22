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

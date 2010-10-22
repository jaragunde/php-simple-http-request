<?php

include('SimpleHttpRequest.php');

$request = new SimpleHttpRequest("http://www.example.com");
$request->addParameter("parameter","value");

$request->init();
echo $request->doRequest();
$request->close();
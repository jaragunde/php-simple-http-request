<?php

include('SimpleHttpRequest.php');

$request = new SimpleHttpRequest("http://www.example.com");

echo $request->doRequest();

<?php

/** Class to provide a simple http request.
 *
 * It uses libCURL internally, but it has a friendlier interface for the user.
 *
 * @author Jacobo Aragunde Pérez <jaragunde@igalia.com>
 */
class SimpleHttpRequest {

    private $url;
    private $parametersArray;

    private $curlHandle;

    public function __construct($url = null) {
        $this->url = $url;
        $this->parametersArray = array();
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getUrl() {
        return $this->url;
    }

    public function addParameter($name, $value) {
        $this->parametersArray[$name] = $value;
    }

    public function removeParameter($name) {
        unset($this->parametersArray[$name]);
    }

    public function getParameters() {
        return $this->parametersArray;
    }

    public function init() {
        // create curl resource
        $this->curlHandle = curl_init();
    }

    public function close() {
        curl_close($this->curlHandle);
    }

    public function doRequest() {
        if($this->url == null) {
            return false;
        }

        // set url
        $urlWithParameters = $this->url . $this->prepareParameters();
        curl_setopt($this->curlHandle, CURLOPT_URL, $urlWithParameters);

        // return the transfer as a string
        curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($this->curlHandle);

        return $output;
    }

    private function prepareParameters() {
        $parameterString = "?";
        foreach($this->parametersArray as $name => $value) {
            $parameterString .= urlencode($name) . "=" . urlencode($value). "&";
        }
        return $parameterString;
    }
}

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
    private $hasPost;
    private $postData;
    private $hasAuth;
    private $authLogin;
    private $authPassword;

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

    public function setupPost($postData) {
        $this->hasPost = true;
        $this->postData = $postData;
    }

    public function clearPost() {
        if($this->hasPost) {
            $this->hasPost = false;
            unset($this->postData);
            if($this->curlHandle) {
                curl_setopt($this->curlHandle, CURLOPT_POST, false);
                curl_setopt($this->curlHandle, CURLOPT_POSTFIELDS, null);
            }
        }
    }

    public function setupHttpAuthentication($login, $password) {
        $this->hasAuth = true;
        $this->authLogin = $login;
        $this->authPassword = $password;
    }

    public function clearHttpAuthentication() {
        if($this->hasAuth) {
            $this->hasAuth = false;
            $this->authLogin = null;
            $this->authPassword = null;
            if($this->curlHandle) {
                curl_setopt($this->curlHandle, CURLOPT_HTTPAUTH, null);
                curl_setopt($this->curlHandle, CURLOPT_USERPWD, null);
            }
        }
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

        // set post data
        if($this->hasPost) {
            curl_setopt($this->curlHandle, CURLOPT_POST, true);
            curl_setopt($this->curlHandle, CURLOPT_POSTFIELDS, $this->postData);
        }

        // set auth data
        if($this->hasAuth) {
            curl_setopt($this->curlHandle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($this->curlHandle,CURLOPT_USERPWD,
                $this->authLogin.":".$this->authPassword);
        }

        // return the transfer as a string
        curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($this->curlHandle);

        return $output;
    }

    public function getError() {
        return curl_error($this->curlHandle);
    }

    private function prepareParameters() {
        $parameterString = "?";
        foreach($this->parametersArray as $name => $value) {
            $parameterString .= urlencode($name) . "=" . urlencode($value). "&";
        }
        return $parameterString;
    }
}

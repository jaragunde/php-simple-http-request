<?php

/** Class to provide a simple http request.
 *
 * It uses libCURL internally, but it has a friendlier interface for the user.
 *
 * @author Jacobo Aragunde Pérez <jaragunde@igalia.com>
 */
class SimpleHttpRequest {

    private $url;

    public function __construct($url = null) {
        $this->url = $url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getUrl() {
        return $this->url;
    }

    public function doRequest() {
        if($this->url == null) {
            return false;
        }

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $this->url);

        // return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        return $output;
    }
}

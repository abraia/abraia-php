#!/usr/bin/env php
<?php

require_once('client.php');
require_once('config.php');


class APIError extends Exception {}


class Client {
    var $url = '';
    var $params = array();
    var $resp = '';

    function files() {
        $url = API_URL.'/images';
        $resp = session_get($url);
        return $resp;
    }

    function from_file($filename) {
        $url = API_URL.'/images';
        list($status, $resp) = upload_file($url, $filename);
        if ($status != 201)
            throw new APIError('POST ' . $url . ' ' . $status);
        $json = json_decode($resp, true);
        $this->url = $url.'/'.$json['filename'];
        $this->params['q'] = 'auto';
        return $this;
    }

    function from_url($url) {
        $this->url = API_URL.'/images';
        $this->params['url'] = $url;
        $this->params['q'] = 'auto';
        return $this;
    }

    function to_file($filename) {
        $url = $this->url.'?'.http_build_query($this->params);
        list($status, $resp) = download_file($url, $filename);
        if ($status != 200)
            throw new APIError('GET ' . $url . ' ' . $status);
        $fp = fopen($filename, 'w');
        fwrite($fp, $resp);
        fclose($fp);
        return $this;
    }

    function resize($width=null, $height=null) {
        if (!is_null($width)) $this->params['w'] = $width;
        if (!is_null($height)) $this->params['h'] = $height;
        return $this;
    }

    function delete($filename) {
        $url = API_URL.'/images/'.$filename;
        $resp = session_delete($url);
        return $resp;
    }
}

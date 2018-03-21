<?php

require_once('client.php');
require_once('config.php');

class Abraia {
    var $url = '';
    var $params = array();

    function files() {
        $url = API_URL.'/images';
        $resp = list_files($url);
        return $resp;
    }

    function from_file($filename) {
        $url = API_URL.'/images';
        $data = upload_file($url, $filename);
        $this->url = $url.'/'.$data['filename'];
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
        $data = download_file($url, $filename);
        $fp = fopen($filename, 'w');
        fwrite($fp, $data);
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
        $resp = remove_file($url);
        return $resp;
    }
}

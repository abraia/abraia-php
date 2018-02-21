#!/usr/bin/env php
<?php

require_once('config.php');


function session_get($url) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_USERPWD, API_KEY.':'.API_SECRET);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $resp = curl_exec($curl);
    curl_close($curl);
    return $resp;
}

function session_delete($url) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_USERPWD, API_KEY.':'.API_SECRET);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $resp = curl_exec($curl);
    curl_close($curl);
    return $resp;
}

function upload_file($url, $filename) {
    $curl = curl_init();
    $postData = array('file' => curl_file_create($filename, '', basename($filename)));
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://abraia.me/api/images',
        CURLOPT_USERPWD => API_KEY.':'.API_SECRET,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $postData,
    ));
    $resp = curl_exec($curl);
    curl_close($curl);
    return $resp;
}

function download_file($url, $filename) {
    $curl = curl_init ($url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_USERPWD, API_KEY.':'.API_SECRET);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_BINARYTRANSFER,1);
    $raw = curl_exec($curl);
    curl_close ($curl);

    $fp = fopen($filename, 'w');
    fwrite($fp, $raw);
    fclose($fp);
}


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
        $resp = upload_file($url, $filename);
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
        download_file($url, $filename);
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

$abraia = new Client();
// echo $abraia->files();
$abraia->from_file('images/lion.jpg')->to_file('images/optimized.jpg');
$abraia->from_file('images/lion.jpg')->resize(300, 300)->to_file('images/resized.jpg');
// echo $abraia->delete('lion.jpg');

?>

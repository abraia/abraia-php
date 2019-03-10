<?php

namespace Abraia;

require_once('Client.php');

class Abraia extends Client {
    protected $path;
    protected $params;
    protected $userid;

    function __construct($folder='') {
        parent::__construct();
        $this->folder = $folder;
        $this->userid = $this->getUserId();
    }

    function setKey($key) {
        list($apiKey, $apiSecret) = explode(':', base64_decode($key));
        $this->setApiKeys($apiKey, $apiSecret);
        $this->userid = $this->getUserId();
    }

    private function getUserId() {
        try {
            return $this->loadUser()['user']['id'];
        }
        catch (\Exception $e) {
            return NULL;
        }
    }

    function files($path='') {
        return $this->listFiles($this->userid . '/' . $path);
    }

    function fromFile($path) {
        $resp = $this->uploadFile($path, $this->userid . '/' . $this->folder);
        $this->path = $resp['source'];
        $this->params = array('q' => 'auto');
        return $this;
    }

    function fromUrl($url) {
        $resp = $this->uploadRemote($url, $this->userid . '/' . $this->folder);
        $this->path = $resp['source'];
        $this->params = array('q' => 'auto');
        return $this;
    }

    function fromStore($path) {
        $this->path = $this->userid . '/' . $path;
        $this->params = array();
        return $this;
    }

    function toFile($path) {
        if ($this->params) {
          $ext = pathinfo($path, PATHINFO_EXTENSION);
          if ($ext) $this->params['fmt'] = strtolower($ext);
        }
        $data = $this->transformImage($this->path, $this->params);
        $fp = fopen($path, 'w');
        fwrite($fp, $data);
        fclose($fp);
        return $this;
    }

    function resize($width=null, $height=null, $mode='auto') {
        if ($width) $this->params['w'] = $width;
        if ($height) $this->params['h'] = $height;
        $this->params['m'] = $mode;
        return $this;
    }

    function remove() {
        return $this->removeFile($this->path);
    }
}

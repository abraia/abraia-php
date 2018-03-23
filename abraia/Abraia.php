<?php

namespace Abraia;

require_once('Client.php');

class Abraia extends Client {
    protected $path;
    protected $params;

    function files() {
        return $this->listFiles();
    }

    function fromFile($path) {
        $data = $this->uploadFile($path);
        $this->path = $data['filename'];
        $this->params = array('q' => 'auto');
        return $this;
    }

    function fromUrl($url) {
        $this->path = '';
        $this->params = array(
            'url' => $url,
            'q' => 'auto',
        );
        return $this;
    }

    function toFile($path) {
        $data = $this->downloadFile($this->path, $this->params);
        $fp = fopen($path, 'w');
        fwrite($fp, $data);
        fclose($fp);
        return $this;
    }

    function resize($width=null, $height=null, $mode='auto') {
        if (!is_null($width)) $this->params['w'] = $width;
        if (!is_null($height)) $this->params['h'] = $height;
        $this->params['m'] = $mode;
        return $this;
    }

    function delete($path) {
        return $this->removeFile($path);
    }
}

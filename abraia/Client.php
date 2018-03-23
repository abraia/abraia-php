<?php

namespace Abraia;

class APIError extends \Exception {}

class Client {
    const API_URL = 'https://abraia.me/api';

    protected $apiKey;
    protected $apiSecret;

    public function __construct() {
        $apiKey = getenv('ABRAIA_API_KEY');
        $apiSecret = getenv('ABRAIA_API_SECRET');
        $this->apiKey = ($apiKey === false) ? '' : $apiKey;
        $this->apiSecret = ($apiSecret === false) ? '' : $apiSecret;
    }

    public function setApiKeys($apiKey, $apiSecret) {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    public function listFiles() {
        $curl = curl_init(self::API_URL . '/images');
        curl_setopt($curl, CURLOPT_USERPWD, $this->apiKey.':'.$this->apiSecret);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $resp = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($statusCode != 200)
            throw new APIError('GET ' . $statusCode);
        return json_decode($resp, true);
    }

    public function uploadFile($path) {
        $curl = curl_init(self::API_URL . '/images');
        $postData = array('file' => curl_file_create($path, '', basename($path)));
        curl_setopt_array($curl, array(
          CURLOPT_USERPWD => $this->apiKey.':'.$this->apiSecret,
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_POST => 1,
          CURLOPT_POSTFIELDS => $postData,
        ));
        $resp = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($statusCode != 201)
            throw new APIError('POST ' . $statusCode);
        return json_decode($resp, true);
    }

    public function downloadFile($path, $params=array()) {
        $url = self::API_URL . '/images';
        $url = ($path == '')  ? $url : $url . '/' . $path;
        $url = $url.'?'.http_build_query($params);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_USERPWD, $this->apiKey.':'.$this->apiSecret);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_BINARYTRANSFER,1);
        $resp = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close ($curl);
        if ($statusCode != 200)
            throw new APIError('GET ' . $statusCode);
        return $resp;
    }

    public function removeFile($path) {
        $curl = curl_init(self::API_URL . '/images/' . $path);
        curl_setopt($curl, CURLOPT_USERPWD, $this->apiKey.':'.$this->apiSecret);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $resp = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($statusCode != 200)
            throw new APIError('DELETE ' . $statusCode);
        return json_decode($resp, true);
    }
}

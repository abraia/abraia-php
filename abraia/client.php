<?php

class APIError extends Exception {}

function list_files($url) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_USERPWD, API_KEY.':'.API_SECRET);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $resp = curl_exec($curl);
    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    if ($statusCode != 200)
        throw new APIError('GET ' . $url . ' ' . $statusCode);
    return json_decode($resp, true);
}

function remove_file($url) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_USERPWD, API_KEY.':'.API_SECRET);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $resp = curl_exec($curl);
    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    if ($statusCode != 200)
        throw new APIError('DELETE ' . $url . ' ' . $statusCode);
    return json_decode($resp, true);
}

function upload_file($url, $filename) {
    $curl = curl_init($url);
    $postData = array('file' => curl_file_create($filename, '', basename($filename)));
    curl_setopt_array($curl, array(
        CURLOPT_USERPWD => API_KEY.':'.API_SECRET,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $postData,
    ));
    $resp = curl_exec($curl);
    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    if ($statusCode != 201)
        throw new APIError('POST ' . $url . ' ' . $statusCode);
    return json_decode($resp, true);
}

function download_file($url, $filename) {
    $curl = curl_init ($url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_USERPWD, API_KEY.':'.API_SECRET);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_BINARYTRANSFER,1);
    $resp = curl_exec($curl);
    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close ($curl);
    if ($statusCode != 200)
        throw new APIError('GET ' . $url . ' ' . $statusCode);
    return $resp;
}

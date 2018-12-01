<?php

require_once(dirname(__DIR__).'/abraia/Client.php');

$client = new Abraia\Client();

final class ClientTest extends \PHPUnit_Framework_TestCase {
    public function testLoadUser() {
        global $client;
        $result = $client->loadUser();
        $this->assertInternalType('array', $result);
    }

    public function testListFiles() {
        global $client;
        $result = $client->listFiles();
        $this->assertInternalType('array', $result);
    }

    public function testUploadFile() {
        global $client;
        $result = $client->uploadFile('images/lion.jpg', '0/');
        $this->assertInternalType('array', $result);
    }

    public function testDownloadFile() {
        global $client;
        $result = $client->downloadFile('0/lion.jpg');
        $this->assertInternalType('string', $result);
    }

    public function testTransformImage() {
        global $client;
        $result = $client->transformImage('0/lion.jpg', ['q' => 'auto']);
        $this->assertInternalType('string', $result);
    }

    public function testRemoveFile() {
        global $client;
        $result = $client->removeFile('0/lion.jpg');
        $this->assertInternalType('array', $result);
    }
}

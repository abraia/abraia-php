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

    public function testUploadRemote() {
        global $client;
        $result = $client->uploadRemote('https://api.abraia.me/files/demo/birds.jpg', '0/');
        $this->assertInternalType('array', $result);
    }

    public function testUploadFile() {
        global $client;
        $result = $client->uploadFile('images/lion.jpg', '0/');
        $this->assertInternalType('array', $result);
    }

    public function testMoveFile() {
        global $client;
        $result = $client->moveFile('0/birds.jpg', '0/test/birds.jpg');
        $result = $client->moveFile('0/test/birds.jpg', '0/birds.jpg');
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

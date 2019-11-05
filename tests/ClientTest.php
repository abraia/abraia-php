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
        $result = $client->listFiles('demo/');
        $this->assertInternalType('array', $result);
    }

    public function testUploadRemote() {
        global $client;
        $result = $client->uploadRemote('https://api.abraia.me/files/demo/tiger.jpg', 'demo/');
        $this->assertInternalType('array', $result);
    }

    public function testUploadFile() {
        global $client;
        $result = $client->uploadFile('images/lion.jpg', 'demo/');
        $this->assertInternalType('array', $result);
    }

    public function testMoveFile() {
        global $client;
        $result = $client->moveFile('demo/lion.jpg', 'demo/test/lion.jpg');
        $result = $client->moveFile('demo/test/lion.jpg', 'demo/lion.jpg');
        $this->assertInternalType('array', $result);
    }

    public function testDownloadFile() {
        global $client;
        $result = $client->downloadFile('demo/lion.jpg');
        $this->assertInternalType('string', $result);
    }

    public function testTransformImage() {
        global $client;
        $result = $client->transformImage('demo/lion.jpg', ['q' => 'auto']);
        $this->assertInternalType('string', $result);
    }

    public function testRemoveFile() {
        global $client;
        $result = $client->removeFile('demo/lion.jpg');
        $this->assertInternalType('array', $result);
    }
}

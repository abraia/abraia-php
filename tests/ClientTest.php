<?php

require_once(dirname(__DIR__).'/abraia/Client.php');

$client = new Abraia\Client();

final class ClientTest extends \PHPUnit_Framework_TestCase {
    public function testListFiles() {
        global $client;
        $data = $client->listFiles();
        $this->assertInternalType('array', $data);
    }

    public function testUploadFile() {
        global $client;
        $data = $client->uploadFile('images/lion.jpg');
        $this->assertInternalType('array', $data);
    }

    public function testDownloadFile() {
        global $client;
        $data = $client->downloadFile('0/lion.jpg');
        $this->assertInternalType('string', $data);
    }

    public function testRemoveFile() {
        global $client;
        $data = $client->removeFile('0/lion.jpg');
        $this->assertInternalType('array', $data);
    }
}

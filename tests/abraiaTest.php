<?php

require_once(dirname(__DIR__).'/abraia/abraia.php');

$abraia = new Client();

final class AbraiaTest extends PHPUnit_Framework_TestCase {
    public function testListFiles() {
        global $abraia;
        $files = $abraia->files();
        $this->assertInternalType('string', $files);
    }

    public function testUploadFile() {
        global $abraia;
        $client = $abraia->from_file('images/lion.jpg');
        $this->assertInstanceOf('Client', $client);
    }

    public function testDownloadFile() {
        global $abraia;
        // $abraia->from_file('images/lion.jpg')->resize(300, 300)->to_file('images/resized.jpg');
        $client = $abraia->from_file('images/lion.jpg')->to_file('images/optimized.jpg');
        $this->assertInstanceOf('Client', $client);
    }

    public function testRemoveFile() {
        global $abraia;
        $resp = $abraia->delete('lion.jpg');
        $this->assertInternalType('string', $resp);
    }
}

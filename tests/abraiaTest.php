<?php

require_once(dirname(__DIR__).'/abraia/abraia.php');

$abraia = new Abraia();

final class AbraiaTest extends PHPUnit_Framework_TestCase {
    public function testListFiles() {
        global $abraia;
        $data = $abraia->files();
        $this->assertInternalType('array', $data);
    }

    public function testUploadFile() {
        global $abraia;
        $client = $abraia->from_file('images/lion.jpg');
        $this->assertInstanceOf('Abraia', $client);
    }

    public function testDownloadFile() {
        global $abraia;
        // $abraia->from_file('images/lion.jpg')->resize(300, 300)->to_file('images/resized.jpg');
        $client = $abraia->from_file('images/lion.jpg')->to_file('images/optimized.jpg');
        $this->assertInstanceOf('Abraia', $client);
    }

    public function testRemoveFile() {
        global $abraia;
        $data = $abraia->delete('lion.jpg');
        $this->assertInternalType('array', $data);
    }
}

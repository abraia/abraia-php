<?php

require_once(dirname(__DIR__).'/abraia/Abraia.php');

$abraia = new Abraia\Abraia();

final class AbraiaTest extends \PHPUnit_Framework_TestCase {
    public function testListStoredFiles() {
        global $abraia;
        $result = $abraia->files();
        $this->assertInternalType('array', $result);
    }

    public function testUploadLocalFile() {
        global $abraia;
        $client = $abraia->fromFile('images/lion.jpg');
        $this->assertInstanceOf('Abraia\Abraia', $client);
    }

    public function testOptimizeImage() {
        global $abraia;
        $client = $abraia->fromFile('images/tiger.jpg')->toFile('images/optimized.jpg');
        $this->assertInstanceOf('Abraia\Abraia', $client);
    }

    public function testThumbResizeImage() {
        global $abraia;
        $client = $abraia->fromFile('images/tiger.jpg')->resize(500, 500, 'thumb')->toFile('images/roptim.jpg');
        $this->assertInstanceOf('Abraia\Abraia', $client);
    }

    public function testSmartResizeImage() {
        global $abraia;
        $client = $abraia->fromFile('images/tiger.jpg')->resize(500, 500)->toFile('images/resized.jpg');
        $this->assertInstanceOf('Abraia\Abraia', $client);
    }

    public function testRemoveStoredFile() {
        global $abraia;
        $result = $abraia->delete('0/lion.jpg');
        $this->assertInternalType('array', $result);
    }
}
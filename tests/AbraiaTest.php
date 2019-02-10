<?php

require_once(dirname(__DIR__).'/abraia/Abraia.php');

$abraia = new Abraia\Abraia();

final class AbraiaTest extends \PHPUnit_Framework_TestCase {
    public function testListStoredFiles() {
        global $abraia;
        $result = $abraia->list();
        $this->assertInternalType('array', $result);
    }

    public function testUploadLocalFile() {
        global $abraia;
        $client = $abraia->fromFile('images/lion.jpg');
        $this->assertInstanceOf('Abraia\Abraia', $client);
    }

    public function testUploadRemoteFile() {
        global $abraia;
        $client = $abraia->fromUrl('https://api.abraia.me/files/demo/birds.jpg');
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

    public function testRestoreStoredFile() {
        global $abraia;
        $client = $abraia->fromStore('lion.jpg')->toFile('images/lion.bak.jpg');
        $this->assertInstanceOf('Abraia\Abraia', $client);
    }
    public function testRemoveStoredFile() {
        global $abraia;
        $result = $abraia->fromStore('lion.jpg')->remove();
        $this->assertInternalType('array', $result);
    }
}

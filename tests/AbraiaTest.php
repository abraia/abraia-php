<?php

require_once(dirname(__DIR__).'/abraia/Abraia.php');

$abraia = new Abraia\Abraia();

final class AbraiaTest extends \PHPUnit_Framework_TestCase {
    public function testListFiles() {
        global $abraia;
        $data = $abraia->files();
        $this->assertInternalType('array', $data);
    }

    public function testUploadFile() {
        global $abraia;
        $client = $abraia->fromFile('images/lion.jpg');
        $this->assertInstanceOf('Abraia\Abraia', $client);
    }

    public function testDownloadStoredFile() {
        global $abraia;
        $client = $abraia->fromFile('images/tiger.jpg')->toFile('images/optimized.jpg');
        $this->assertInstanceOf('Abraia\Abraia', $client);
    }

    public function testDownloadRemoteFile() {
        global $abraia;
        $client = $abraia->fromUrl('https://abraia.me/images/random.jpg')->resize(500, 500, 'thumb')->toFile('images/roptim.jpg');
        $this->assertInstanceOf('Abraia\Abraia', $client);
    }

    public function testDownloadResizeFile() {
        global $abraia;
        $client = $abraia->fromFile('images/lion.jpg')->resize(500, 500)->toFile('images/resized.jpg');
        $this->assertInstanceOf('Abraia\Abraia', $client);
    }

    public function testRemoveFile() {
        global $abraia;
        $data = $abraia->delete('0/lion.jpg');
        $this->assertInternalType('array', $data);
    }
}

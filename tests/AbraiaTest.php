<?php

require_once(dirname(__DIR__).'/abraia/Abraia.php');

try {
    $dotenv = Dotenv\Dotenv::createMutable(dirname(__DIR__));
    $dotenv->load();
} catch (Exception $e) {
    echo 'Dotenv exception: ',  $e->getMessage(), '\n';
}

$abraia = new Abraia\Abraia();

final class AbraiaTest extends \PHPUnit_Framework_TestCase {
    public function testSetKeyUserId()
    {
        global $abraia;
        $result = $abraia->setKey('');
        $this->assertInternalType('null', $result);
    }

    public function testLoadUserData() {
        global $abraia;
        $result = $abraia->user();
        $this->assertInternalType('array', $result);
    }

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

    public function testUploadRemoteFile() {
        global $abraia;
        $client = $abraia->fromUrl('https://api.abraia.me/files/demo/tiger.jpg');
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

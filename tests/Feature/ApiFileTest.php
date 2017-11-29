<?php

namespace TapestryCloud\Api\Tests\Feature;

use TapestryCloud\Api\Tests\BootsApp;
use Zend\Diactoros\ServerRequestFactory;

class ApiFileTest extends BootsApp
{

    /**
     * Test route: /files
     */
    public function testFileIndex()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/files',
        ], [], [], [], []));

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/files.json', $response);
    }

    /**
     * Test route: /file/{id}
     */
	public function testFileView()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/file/1',
        ], [], [], [], []));

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/files.json', $response);
    }

    /**
     * Test route: /file/{id}?include=frontmatter
     */
    public function testFileViewWithFrontMatter()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/file/1?include=frontmatter',
        ], [], [], [], []));

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/files.json', $response);
    }
}
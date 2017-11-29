<?php

namespace TapestryCloud\Api\Tests\Feature;

use TapestryCloud\Api\Tests\BootsApp;
use Zend\Diactoros\ServerRequestFactory;

class ApiContentTypeTest extends BootsApp
{
    /**
     * Test route: /content-types
     */
    public function testContentTypesIndex()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/content-types',
        ], [], [], [], []));

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/content-types.json', $response);
    }

    /**
     * Test route: /content-type/{id}
     */
    public function testContentTypeView()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/content-type/1',
        ], [], [], [], []));

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/content-type-1.json', $response);

        $this->bootApp();

        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/content-type/2',
        ], [], [], [], []));

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/content-type-2.json', $response);
    }

    /**
     * Test route: /content-type/{id}/taxonomy
     */
    public function testContentTypeTaxonomy()
    {
        $this->assertTrue(false);
        // @todo
    }

    /**
     * Test route: /content-type/{id}/files
     */
    public function testContentTypeFiles()
    {
        $this->assertTrue(false);
        // @todo
    }

    /**
     * Test route: /content-type/{id}/files?include=frontmatter
     */
    public function testContentTypeFilesWithFrontMatter()
    {
        $this->assertTrue(false);
        // @todo
    }

}
<?php

namespace TapestryCloud\Api\Tests\Feature;

use TapestryCloud\Api\Tests\BootsApp;
use Zend\Diactoros\ServerRequestFactory;

class ApiContentTypeTest extends BootsApp
{
    /**
     * Test route: /content-types.
     */
    public function testContentTypesIndex()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST'      => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/content-types',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/../json/content-types.json', $response);
    }

    /**
     * Test route: /content-type/{id}.
     */
    public function testContentTypeView()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST'      => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/content-type/1',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/../json/content-type-1.json', $response);

        $this->bootApp();

        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST'      => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/content-type/2',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/../json/content-type-2.json', $response);
    }

    /**
     * Test route: /content-type/{id}/taxonomy.
     */
    public function testContentTypeTaxonomy()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST'      => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/content-type/1/taxonomy',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/../json/content-type-1-taxonomy.json', $response);

        $this->bootApp();

        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST'      => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/content-type/2/taxonomy',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/../json/content-type-2-taxonomy.json', $response);
    }

    /**
     * Test route: /content-type/{id}/files.
     */
    public function testContentTypeFiles()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST'      => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/content-type/1/files',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/../json/content-type-1-files.json', $response);

        $this->bootApp();

        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST'      => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/content-type/2/files',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/../json/content-type-2-files.json', $response);
    }

    /**
     * Test route: /content-type/{id}/files?include=frontmatter.
     */
    public function testContentTypeFilesWithFrontMatter()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST'      => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/content-type/1/files',
            'QUERY_STRING'   => '?include=frontmatter',
        ], [
            'include' => 'frontmatter',
        ], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/../json/content-type-1-files-include-frontmatter.json', $response);

        $this->bootApp();

        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST'      => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/content-type/2/files',
            'QUERY_STRING'   => '?include=frontmatter',
        ], [
            'include' => 'frontmatter',
        ], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/../json/content-type-2-files-include-frontmatter.json', $response);
    }
}

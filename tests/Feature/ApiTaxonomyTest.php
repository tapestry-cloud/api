<?php

namespace TapestryCloud\Api\Tests\Feature;

use TapestryCloud\Api\Tests\BootsApp;
use Zend\Diactoros\ServerRequestFactory;

class ApiTaxonomyTest extends BootsApp
{
    /**
     * Test route: /taxonomy
     */
    public function testTaxonomyIndex()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/taxonomy',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/taxonomy.json', $response);
    }

    /**
     * Test route: /taxonomy/{id}
     */
	public function testTaxonomyView()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/taxonomy/1',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/taxonomy-1.json', $response);

        $this->bootApp();

        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/taxonomy/2',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/taxonomy-2.json', $response);
    }

    /**
     * Test route: /taxonomy/{id}/classifications
     */
    public function testTaxonomyClassifications()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/taxonomy/1/classifications',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/taxonomy-1-classifications.json', $response);

        $this->bootApp();

        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/taxonomy/2/classifications',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/taxonomy-2-classifications.json', $response);
    }

    /**
     * This route returns files linked to the taxonomy via classification.
     * E.g. Files tagged with, Files in this category.
     *
     * Test route: /taxonomy/{id}/classification/{id}/files
     */
    public function testTaxonomyClassificationFiles()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/taxonomy/1/classification/1/files',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/taxonomy-1-classification-1-files.json', $response);

        $this->bootApp();

        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/taxonomy/1/classification/2/files',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/taxonomy-1-classification-2-files.json', $response);

        $this->bootApp();

        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/taxonomy/1/classification/3/files',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/taxonomy-1-classification-3-files.json', $response);

        $this->bootApp();

        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/taxonomy/1/classification/4/files',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/taxonomy-1-classification-4-files.json', $response);
    }
}
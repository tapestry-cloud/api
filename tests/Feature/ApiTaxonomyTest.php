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
        $this->assertTrue(false);
        // @todo
    }

    /**
     * Test route: /taxonomy/{id}
     */
	public function testTaxonomyView()
    {
        $this->assertTrue(false);
        // @todo
    }

    /**
     * Test route: /taxonomy/{id}/classifications
     */
    public function testTaxonomyClassifications()
    {
        $this->assertTrue(false);
        // @todo
    }

    /**
     * This route returns files linked to the taxonomy via classification.
     * E.g. Files tagged with, Files in this category.
     *
     * Test route: /taxonomy/{id}/classification/{id}/files
     */
    public function testTaxonomyClassificationFiles()
    {
        $this->assertTrue(false);
        // @todo
    }
}
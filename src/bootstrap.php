<?php

include __DIR__.'/../vendor/autoload.php';

date_default_timezone_set('UTC');

$app = new \TapestryCloud\Api\App();

//
// Services
//

$app->register(new \TapestryCloud\Api\Services\Routes());
$app->register(new \TapestryCloud\Api\Services\Configuration());
$app->register(new \TapestryCloud\Api\Services\Tapestry());
$app->register(new \TapestryCloud\Database\ServiceProvider());

return $app;

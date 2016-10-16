<?php
define("ROOT_DIR", __DIR__ . '/../');

require __DIR__ . '/../lib/vendor/autoload.php';

require __DIR__ . '/../config/config.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../config/settings.php';
$app = new \Slim\App($settings);

\Desirene\Routing\YamlRouteParser::parse($app, __DIR__ . '/../config/routes.yml');

// Run app
$app->run();

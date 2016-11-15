<?php
define("ROOT_DIR",realpath(__DIR__ . '/../'));
if(!defined('ENV'))
{
  define("ENV", require ROOT_DIR . '/config/env.php');
}
session_start();
require __DIR__ . '/../lib/vendor/autoload.php';
require ROOT_DIR . '/lib/Desirene/config/databases.php';

\Propel\Runtime\Propel::getServiceContainer()->setDefaultDatasource(ENV);

// Instantiate the app
$settings = require __DIR__ . '/../lib/Desirene/config/settings.php';
$app = new \Slim\App($settings);

require __DIR__ . '/../lib/Desirene/config/dependencies.php';
require __DIR__ . '/../lib/Desirene/config/middleware.php';
require __DIR__ . '/../config/dependencies.php';

require __DIR__ . '/../lib/Desirene/config/routing.php';

// Run app
$app->run();

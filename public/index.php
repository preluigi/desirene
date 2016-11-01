<?php
if(!defined('ENV'))
{
  define('ENV', 'dev');
}

define('ROOT_DIR', __DIR__ . '/../');

require __DIR__ . '/../lib/vendor/autoload.php';

require __DIR__ . '/../config/' . ENV . '/databases.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../lib/Desirene/config/settings.php';
$app = new \Slim\App($settings);

require __DIR__ . '/../lib/Desirene/config/dependencies.php';
require __DIR__ . '/../config/' . ENV . '/dependencies.php';

require __DIR__ . '/../lib/Desirene/config/routing.php';

// Run app
$app->run();

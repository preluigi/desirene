<?php
use \Desirene\Routing\YamlRouteParser;
$parser = new YamlRouteParser($app, ROOT_DIR . '/cache');
foreach(glob(ROOT_DIR . '/config/' . ENV . '/*routes.yml') as $routeFile)
{
  $parser->parse($routeFile);
}

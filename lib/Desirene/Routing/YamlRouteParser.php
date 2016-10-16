<?php
namespace Desirene\Routing;
use \Symfony\Component\Yaml\Yaml;

class YamlRouteParser
{
  public static function parse(&$app, $file)
  {
    try
    {
      $routes = Yaml::parse(file_get_contents($file));
      
      foreach($routes as $name => $config)
      {
        $method = strtolower(isset($config['method']) ? $config['method'] : 'any');
        $app->$method($config['url'], $config['action'])->setName($name);
      }
    }
    catch(Exception $e)
    {
      return false;
    }
    return true;
  }
}

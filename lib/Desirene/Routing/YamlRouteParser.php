<?php
namespace Desirene\Routing;
use \Symfony\Component\Yaml\Yaml;

class YamlRouteParser
{
  protected $app      = null;
  protected $cacheDir = null;
  
  public function __construct($app, $cacheDir)
  {
    $this->app      = $app;
    $this->cacheDir = $cacheDir;
  }
  
  public function parse($file)
  {
    $filename = basename($file);
    $cacheFilename = preg_replace("/(.*)\.([a-zA-Z0-9]+)$/", "$1.php", $filename);
    
    if(!file_exists($this->cacheDir . '/' . $cacheFilename))
    {
      try
      {
        $fpCacheFile = fopen($this->cacheDir . '/' . $cacheFilename, 'w');
        fwrite($fpCacheFile, "<?php\n");
        if('routes.yml' == $filename)
        {
          fwrite($fpCacheFile, "\$this->app->options('/[{uri:.*}]', function(\$request, \$response, \$attrs = null){})->setName('preflight');\n");
        }
        $routes = Yaml::parse(file_get_contents($file));
        foreach((array)$routes as $name => $config)
        {
          $method = strtolower(isset($config['method']) ? $config['method'] : 'any');
          
          fwrite($fpCacheFile, "\$this->app->{$method}('{$config['url']}', '{$config['action']}')->setName('{$name}');\n");
        }
        fclose($fpCacheFile);
      }
      catch(Exception $e)
      {
        return false;
      }
    }
    require $this->cacheDir . '/' . $cacheFilename;
    return true;
  }
}

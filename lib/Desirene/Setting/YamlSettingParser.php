<?php
namespace Desirene\Setting;
use \Symfony\Component\Yaml\Yaml;

class YamlSettingParser
{
  const DEFAULT_ENV = 'dev';
  protected $cacheDir = null;
  
  public function __construct($cacheDir)
  {
    $this->cacheDir = $cacheDir;
  }
  
  public function parse($file, $env = null, $defaults = [])
  {
    $env = $env ?? static::DEFAULT_ENV;
    $filename = basename($file);
    $cacheFilename = preg_replace("/(.*)\.([a-zA-Z0-9]+)$/", "$1.php", $filename);
    
    if(!file_exists($this->cacheDir . '/' . $cacheFilename))
    {
      try
      {
        $settings = Yaml::parse(file_get_contents($file));
        $managers = $settings['manager'] ?? [];
        $settings = $settings[$env] ?? null;
        if(!$settings)
        {
          throw new EnvironmentNotFoundException(sprintf("The requested environment '%s' was not found in %s", $env, $file));
        }
        
        foreach($settings as $section => $values)
        {
          $settingsClassName = $managers[$section] ?? null;
          if(null !== $settingsClassName && class_exists($settingsClassName))
          {
            $settings[$section] = $settingsClassName::parse($values);
          }
        }
        
        $settings = array_replace_recursive($defaults, $settings);
        
        file_put_contents(
          $this->cacheDir . '/' . $cacheFilename,
          sprintf(
            "<?php\nreturn %s;",
            var_export((array)$settings, true)
          )
        );
      }
      catch(Exception $e)
      {
        return false;
      }
    }
    return require $this->cacheDir . '/' . $cacheFilename;
  }
}

<?php
namespace Desirene\Setting;
use \Symfony\Component\Yaml\Yaml;

class YamlSettingParser
{
  protected $cacheDir = null;
  
  public function __construct($cacheDir)
  {
    $this->cacheDir = $cacheDir;
  }
  
  public function parse($file, $defaultSettings = [])
  {
    $filename = basename($file);
    $cacheFilename = preg_replace("/(.*)\.([a-zA-Z0-9]+)$/", "$1." . filemtime($file) . ".php", $filename);
    
    if(!file_exists($this->cacheDir . '/' . $cacheFilename))
    {
      try
      {
        $settings = Yaml::parse(file_get_contents($file));
        $settings = array_replace_recursive($defaultSettings, (array)$settings);
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

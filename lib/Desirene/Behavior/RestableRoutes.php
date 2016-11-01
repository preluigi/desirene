<?php
namespace Desirene\Behavior;

class RestableRoutes
{
  protected static $instance  = null;
  protected $file             = null;
  protected $freshFile        = true; 
  
  protected function __construct($file)
  {
    $this->setFile($file);
  }
  
  public static function getInstance($file)
  {
    if(!static::$instance)
    {
      static::$instance = new static($file);
    }
    return static::$instance;
  }
  
  public function writeRoutes($baseRouteName, $className, $primaryKeys)
  {
    $primaryKeys = array_map(
      function($column)
      {
        return sprintf("{%s}", $column->getName());
      },
      $primaryKeys
    );
    $primaryKeysUriParams = implode('/', $primaryKeys);
    
    $routes = <<<eos
## {$className} REST routes
{$baseRouteName}_rest_list:
  url: /{$baseRouteName}
  method: 'get'
  action: '{$className}Rest:listAction'
{$baseRouteName}_rest_get:
  url: /{$baseRouteName}/{$primaryKeysUriParams}
  method: 'get'
  action: '{$className}Rest:getAction'
{$baseRouteName}_rest_post:
  url: /{$baseRouteName}
  method: 'post'
  action: '{$className}Rest:postAction'
{$baseRouteName}_rest_put:
  url: /{$baseRouteName}/{$primaryKeysUriParams}
  method: 'put'
  action: '{$className}Rest:putAction'
{$baseRouteName}_rest_put:
  url: /{$baseRouteName}/{$primaryKeysUriParams}
  method: 'patch'
  action: '{$className}Rest:patchAction'
{$baseRouteName}_rest_put:
  url: /{$baseRouteName}/{$primaryKeysUriParams}
  method: 'delete'
  action: '{$className}Rest:deleteAction'


eos;
    if($this->isFreshFile())
    {
      file_put_contents($this->getFile(), $routes);
      $this->setFreshFile(false);
    }
    else
    {
      file_put_contents($this->getFile(), $routes, FILE_APPEND);
    }
  }
  
  /**
   * Get the value of File
   *
   * @return mixed
   */
  public function getFile()
  {
  	return $this->file;
  }
  /**
   * Set the value of File
   *
   * @param mixed file
   *
   * @return self
   */
  public function setFile($file)
  {
  	$this->file = $file;
  	return $this;
  }
  /**
   * Get the value of Fresh File
   *
   * @return mixed
   */
  public function getFreshFile()
  {
  	return $this->freshFile;
  }
  public function isFreshFile()
  {
    return $this->getFreshFile();
  }
  /**
   * Set the value of Fresh File
   *
   * @param mixed freshFile
   *
   * @return self
   */
  public function setFreshFile($freshFile)
  {
  	$this->freshFile = $freshFile;
  	return $this;
  }
}

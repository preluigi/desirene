<?php
namespace Desirene\Behavior;
use \Propel\Generator\Builder\Om\AbstractOMBuilder;

class RestableBehaviorBaseBuilder extends AbstractOMBuilder
{
  const ROUTING_FILE = __DIR__ . '/../../../config/generated-routes.rest.yml';
  public function getPackage()
  {
    return parent::getPackage() . ".Rest";
  }
  
  public function getNamespace()
  {
    if ($namespace = parent::getNamespace()) {
      return $namespace . '\\Rest';
    }
    return 'Rest';
  }
  
  public function getUnprefixedClassName()
  {
    return 'Base' . $this->getStubObjectBuilder()->getUnprefixedClassName() . 'Rest';
  }
  
  protected function addClassOpen(&$script)
  {
    $script .= <<<eos
use {$this->getStubObjectBuilder()->getClassName()} as {$this->getStubObjectBuilder()->getUnprefixedClassName()};
use {$this->getStubQueryBuilder()->getClassName()} as {$this->getStubQueryBuilder()->getUnprefixedClassName()};
/*
 * {$this->getClassname()} class.
 */
class {$this->getUnprefixedClassName()} extends {$this->getStubObjectBuilder()->getUnprefixedClassName()}
{
eos;
  }
  
  protected function addClassBody(&$script)
  {
    $script .= <<<eos

    
{$this->addRestMethods($this->getStubObjectBuilder()->getClassName())}
eos;
    $this->generateRoutingFile();
  }
  
  protected function addClassClose(&$script)
  {
    $script .= <<<eos
  
}
eos;
  }
  
  protected function generateRoutingFile()
  {
    $writer = RestableRoutes::getInstance(self::ROUTING_FILE);
    
    $baseRouteName = preg_replace('/([A-Z])/', "_$1", $this->getStubObjectBuilder()->getUnprefixedClassName());
    $baseRouteName = strtolower($baseRouteName[0] == '_' ? substr($baseRouteName, 1) : $baseRouteName);
    
    $writer->writeRoutes($baseRouteName, $this->getStubObjectBuilder()->getClassName(), $this->getTable()->getPrimaryKey());
  }
  
  protected function addRestMethods($modelName)
  {
    return <<< eos
  public static function listAction(\$request, \$response, \$args)
  {
    \$query = {$this->getStubQueryBuilder()->getUnprefixedClassName()}::create();
    foreach(\$args as \$key => \$value)
    {
      \$filterMethod = 'filterBy' . str_replace(' ', '', ucwords(str_replace('_', ' ', \$key)));
      if(method_exists(\$query, \$filterMethod))
      {
        \$query->\$filterMethod(\$value);
      }
    }
    \$response->getBody()->write(
      \$query->find()->toJSON(false)
    );
    
    return \$response->withHeader('Content-type', 'application/json');
  }

  public static function getAction(\$request, \$response, \$args)
  {
    \$query = {$this->getStubQueryBuilder()->getUnprefixedClassName()}::create();
    foreach(\$args as \$key => \$value)
    {
      \$filterMethod = 'filterBy' . str_replace(' ', '', ucwords(str_replace('_', ' ', \$key)));
      if(method_exists(\$query, \$filterMethod))
      {
        \$query->\$filterMethod(\$value);
      }
    }
    \$response->getBody()->write(
      (\$instance = \$query->findOne()) ? \$instance->toJSON(false) : null
    );
    
    return \$response->withHeader('Content-type', 'application/json');
  }

  public static function postAction(\$request, \$response, \$args)
  {
    \$payload = json_decode(\$request->getBody()->getContents());
    \$payload = is_array(\$payload) ? \$payload : [\$payload];
    
    \$insertedObjects = new \\Propel\\Runtime\\Collection\\ObjectCollection;
    \$insertedObjects->setModel('$modelName');
    
    foreach(\$payload as \$reqObject)
    {
      \$instance = new static;
      \$instance->fromArray((array)\$reqObject);
      
      foreach(\$args as \$key => \$value)
      {
        \$setMethod = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', \$key)));
        if(method_exists(\$instance, \$setMethod))
        {
          \$instance->\$setMethod(\$value);
        }
      }
      \$instance->save();
      
      \$insertedObjects->push(\$instance);
    }
    
    \$insertedObjects = \$insertedObjects->count() == 1 ? \$insertedObjects->pop() : \$insertedObjects;
    
    \$response->getBody()->write(
      \$insertedObjects->toJSON(false)
    );
    
    return \$response->withHeader('Content-type', 'application/json');
  }

  public static function putAction(\$request, \$response, \$args)
  {
    \$query = {$this->getStubQueryBuilder()->getUnprefixedClassName()}::create();
    foreach(\$args as \$key => \$value)
    {
      \$filterMethod = 'filterBy' . str_replace(' ', '', ucwords(str_replace('_', ' ', \$key)));
      if(method_exists(\$query, \$filterMethod))
      {
        \$query->\$filterMethod(\$value);
      }
    }
    \$instance = \$query->findOne();
    \$instance->importFrom('JSON', \$request->getBody()->getContents());
    \$instance->save();
    \$response->getBody()->write(
      \$instance->toJSON(false)
    );
    
    return \$response->withHeader('Content-type', 'application/json');
  }

  public static function patchAction(\$request, \$response, \$args)
  {
    \$query = {$this->getStubQueryBuilder()->getUnprefixedClassName()}::create();
    foreach(\$args as \$key => \$value)
    {
      \$filterMethod = 'filterBy' . str_replace(' ', '', ucwords(str_replace('_', ' ', \$key)));
      if(method_exists(\$query, \$filterMethod))
      {
        \$query->\$filterMethod(\$value);
      }
    }
    \$instance = \$query->findOne();
    \$instance->importFrom('JSON', \$request->getBody()->getContents());
    \$instance->save();
    \$response->getBody()->write(
      \$instance->toJSON(false)
    );
    
    return \$response->withHeader('Content-type', 'application/json');
  }

  public static function deleteAction(\$request, \$response, \$args)
  {
    \$query = {$this->getStubQueryBuilder()->getUnprefixedClassName()}::create();
    foreach(\$args as \$key => \$value)
    {
      \$filterMethod = 'filterBy' . str_replace(' ', '', ucwords(str_replace('_', ' ', \$key)));
      if(method_exists(\$query, \$filterMethod))
      {
        \$query->\$filterMethod(\$value);
      }
    }
    \$instance = \$query->findOne();
    \$instance->delete();
    \$response->getBody()->write(
      \$instance->toJSON(false)
    );
    
    return \$response->withHeader('Content-type', 'application/json');
  }
eos;
  }
}

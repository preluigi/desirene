<?php
namespace Desirene\Behavior;
use \Propel\Generator\Builder\Om\AbstractOMBuilder;

class RestableBehaviorBaseBuilder extends AbstractOMBuilder
{
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

    
{$this->addRestMethods()}
eos;
  }
  
  protected function addClassClose(&$script)
  {
    $script .= <<<eos
  
}
eos;
  }
  
  protected function addRestMethods()
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
    \$instance = new static;
    \$instance->importFrom('JSON', \$request->getBody()->getContents());
    \$instance->save();
    \$response->getBody()->write(
      \$instance->toJSON(false)
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

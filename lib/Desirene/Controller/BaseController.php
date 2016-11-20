<?php
namespace Desirene\Controller;
use Interop\Container\ContainerInterface;

class BaseController
{
  protected $container;
  
  public function __construct(ContainerInterface $ci)
  {
    $this->setContainer($ci);
  }
  
  public function setContainer(ContainerInterface $ci)
  {
    $this->container = $ci;
  }
  
  public function getContainer()
  {
    return $this->container;
  }
  
  public function __get($name)
  {
    return $this->container->$name;
  }
  
  public function __call($name, $args)
  {
    return call_user_func_array(array($this->container, $name), $args);
  }
}
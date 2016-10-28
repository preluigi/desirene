<?php
namespace Desirene\Routing;

class Router extends \Slim\Router
{
  public function pathFor($name, array $data = [], array $queryParams = [])
  {
    if(($jwt = $this->container->request->getParam('jwt', null)))
    {
      $queryParams['jwt'] = $jwt;
    }
    return parent::pathFor($name, $data, $queryParams);
  }
}

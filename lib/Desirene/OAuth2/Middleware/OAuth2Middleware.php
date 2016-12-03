<?php
namespace Desirene\OAuth2\Middleware;
use League\OAuth2\Server\ResourceServer;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Middleware\ResourceServerMiddleware;
use League\OAuth2\Server\Middleware\AuthorizationServerMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class OAuth2Middleware
{
  protected $middleware;
  protected $authorizationServer;
  protected $resourceServer;
  
  public function __construct(AuthorizationServer $authorizationServer = null, ResourceServer $resourceServer = null)
  {
    $this->authorizationServer = $authorizationServer;
    $this->resourceServer = $resourceServer;
  }
  
  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
  {
    $route = $request->getAttribute('route');
    
    if(!$route || $request->isOptions())
    {
      return $next($request, $response);
    }
    
    switch($route->getName())
    {
      case 'authorize':
      case 'access_token':
        //$this->middleware = new AuthorizationServerMiddleware($this->authorizationServer);
        return $next($request, $response);
        break;
      default:
        $this->middleware = new ResourceServerMiddleware($this->resourceServer);
    }
    
    return $this->middleware->__invoke($request, $response, $next);
  }
}
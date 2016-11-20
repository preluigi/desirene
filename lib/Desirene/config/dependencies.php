<?php
use Desirene\OAuth2\Repositories\UserRepository;
use Desirene\OAuth2\Repositories\ScopeRepository;
use Desirene\OAuth2\Repositories\ClientRepository;
use Desirene\OAuth2\Repositories\AuthCodeRepository;
use Desirene\OAuth2\Repositories\AccessTokenRepository;
use Desirene\OAuth2\Repositories\RefreshTokenRepository;
use League\OAuth2\Server\ResourceServer;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\Grant\AuthCodeGrant;
$ci = $app->getContainer();

$ci['router'] = function($container)
{
  $routerCacheFile = false;
  if(isset($container->get('settings')['routerCacheFile']))
  {
    $routerCacheFile = $container->get('settings')['routerCacheFile'];
  }
  
  $router = (new \Desirene\Routing\Router)->setCacheFile($routerCacheFile);
  if(method_exists($router, 'setContainer'))
  {
    $router->setContainer($container);
  }
  return $router;
};

$ci['logger'] = function ($container)
{
    $settings = $container->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$ci['mailer'] = function($container)
{
  return new \Nette\Mail\SendmailMailer;
};

$ci[ResourceServer::class] = function($container)
{
  return new ResourceServer(
    new AccessTokenRepository(),
    'file://' . ROOT_DIR . '/config/keys/public.key'
  );
};

$ci[AuthorizationServer::class] = function($container)
{
  $server = new AuthorizationServer(
    new ClientRepository,
    new AccessTokenRepository,
    new ScopeRepository,
    ROOT_DIR . '/config/keys/private.key',
    ROOT_DIR . '/config/keys/public.key'
  );
  
  $grant = new AuthCodeGrant(
    new AuthCodeRepository,
    new RefreshTokenRepository,
    new \DateInterval('PT10M')
  ); 
  
  $server->enableGrantType(
    $grant,
    new \DateInterval('PT1H')
  );
  
  $grant = new PasswordGrant(
    new UserRepository,
    new RefreshTokenRepository
  );
  $grant->setRefreshTokenTTL(new \DateInterval('P1M'));
  
  $server->enableGrantType(
    $grant,
    new \DateInterval('PT1H')
  );
  
  return $server;
};

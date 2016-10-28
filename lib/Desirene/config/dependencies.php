<?php
$ci = $app->getContainer();

$ci['router'] = function($container)
{
  $routerCacheFile = false;
  if (isset($container->get('settings')['routerCacheFile'])) {
    $routerCacheFile = $container->get('settings')['routerCacheFile'];
  }
  
  $router = (new \Desirene\Routing\Router)->setCacheFile($routerCacheFile);
  if (method_exists($router, 'setContainer')) {
    $router->setContainer($container);
  }
  return $router;
};

$ci['logger'] = function ($container) {
    $settings = $container->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$ci['mailer'] = function($container){
  return new \Nette\Mail\SendmailMailer;
};

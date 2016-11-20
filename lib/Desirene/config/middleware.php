<?php
use Desirene\OAuth2\Middleware\OAuth2Middleware;
use League\OAuth2\Server\ResourceServer;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Middleware\ResourceServerMiddleware;

// $app->add(
//   new ResourceServerMiddleware(
//     $app->getContainer()->get(ResourceServer::class)
//   )
// );
$app->add(
  new OAuth2Middleware(
    $app->getContainer()->get(AuthorizationServer::class),
    $app->getContainer()->get(ResourceServer::class)
  )
);
<?php
namespace Desirene\OAuth2\Controllers;
use Desirene\Controller\BaseController;
use Desirene\OAuth2\Entities\UserEntity;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;

class AuthController extends BaseController
{
  public function authorize($request, $response, $args)
  {
    $server = $this->get(AuthorizationServer::class);
    
    try
    {
      $authRequest = $server->validateAuthorizationRequets($request);
      $authRequest->setUser(new UserEntity);
      $authRequest->setAuthorizationApproved(true);
      
      return $server->completeAuthorizationRequest($authRequest, $response);
    }
    catch(OAuthServerException $e)
    {
      return $e->generateHttpResponse($response);
    }
    catch(\Exception $e)
    {
      $response->getBody()->write($e->getMessage());
      return $response->withStatus(500);
    }
  }
  
  public function accessToken($request, $response, $args)
  {
    $server = $this->get(AuthorizationServer::class);
    
    try
    {
      return $server->respondToAccessTokenRequest($request, $response);
    }
    catch(OAuthServerException $e)
    {
      return $e->generateHttpResponse($response);
    }
    catch(\Exception $e)
    {
      $response->getBody()->write($e->getMessage());
      return $response->withStatus(500);
    }
    
  }
}
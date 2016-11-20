<?php
namespace Desirene\OAuth2\Repositories;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use Model\AuthClientQuery;

class ClientRepository implements ClientRepositoryInterface
{
  public function getClientEntity($clientIdentifier, $grantType, $clientSecret = null, $mustValidateSecret = null)
  {
    $client = AuthClientQuery::create()->findOneByClientId($clientIdentifier);
    
    if($client)
    {
      if(
        true === $mustValidateSecret
        &&
        ! $client->checkSecret($clientSecret)
      )
      {
        return;
      }
      
      return $client->toClientEntity();
    }
    
    return;
  }
}
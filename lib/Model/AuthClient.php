<?php

namespace Model;

use Desirene\OAuth2\Entities\ClientEntity;
use Model\Base\AuthClient as BaseAuthClient;

/**
 * Skeleton subclass for representing a row from the 'auth_clients' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class AuthClient extends BaseAuthClient
{
  public function toClientEntity()
  {
    $client = new ClientEntity;
    $client->setIdentifier($this->getId());
    $client->setName($this->getClientId());
    $client->setRedirectUri($this->getRedirectUrl());
    
    return $client;
  }
  
  public function checkSecret($secret)
  {
    return password_verify($secret, $this->client_secret);
  }
}

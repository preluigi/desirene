<?php
namespace Desirene\OAuth2\Repositories;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Model\UserQuery;

class UserRepository implements UserRepositoryInterface
{
  public function getUserEntityByUserCredentials($username, $password, $grantType, ClientEntityInterface $clientEntity)
  {
    $user = UserQuery::create()->findOneByEmail($username);
    if(
      null != $user
      &&
      $user->checkPassword($password)
    )
    {
      return $user;
    }
    
    return ;
  }
}
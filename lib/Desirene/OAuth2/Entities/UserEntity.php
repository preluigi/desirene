<?php
namespace Desirene\OAuth2\Entities;
use League\OAuth2\Server\Entities\UserEntityInterface;
use Model\User;

class UserEntity extends User implements UserEntityInterface
{
  public function getIdentifier()
  {
    return $this->getId();
  }
}
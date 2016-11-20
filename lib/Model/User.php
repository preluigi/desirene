<?php

namespace Model;

use League\OAuth2\Server\Entities\UserEntityInterface;
use Model\Base\User as BaseUser;

/**
 * Skeleton subclass for representing a row from the 'users' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class User extends BaseUser implements UserEntityInterface
{
  public function setPassword($value)
  {
    if(!empty($value))
    {
      $this->password = password_hash($value, PASSWORD_BCRYPT);
    }
  }
  
  public function getPassword()
  {
    return null;
  }
  
  public function getPasswordHash()
  {
    return $this->password;
  }
  
  public function checkPassword($password)
  {
    return password_verify($password, $this->password);
  }
  
  public function getIdentifier()
  {
    return $this->getId();
  }
}

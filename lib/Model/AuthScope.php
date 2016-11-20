<?php

namespace Model;

use Desirene\OAuth2\Entities\ScopeEntity;
use Model\Base\AuthScope as BaseAuthScope;

/**
 * Skeleton subclass for representing a row from the 'auth_scopes' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class AuthScope extends BaseAuthScope
{
  public function toScopeEntity()
  {
    $scope = new ScopeEntity;
    $scope->setIdentifier($this->getName());
    
    return $scope;
  }
}

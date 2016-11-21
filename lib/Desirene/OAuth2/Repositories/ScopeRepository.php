<?php
namespace Desirene\OAuth2\Repositories;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use Model\AuthScopeQuery;

class ScopeRepository implements ScopeRepositoryInterface
{
  public function getScopeEntityByIdentifier($scopeIdentifier)
  {
    $scope = AuthScopeQuery::create()->findOneByName($scopeIdentifier);
    
    if($scope)
    {
      return $scope->toScopeEntity();
    }
    
    return;
  }
  
  public function finalizeScopes(array $scopes, $grantType, ClientEntityInterface $clientEntity, $userIdentifier = null)
  {
    if($userIdentifier)
    {
      $user = UserQuery::create()->findOneById($userIdentifier);
      
      foreach($user->getUserGroupsJoinGroup() as $userGroup)
      {
        $group = $userGroup->getGroup();
        $authScopes = $group->getGroupAuthScopesJoinAuthScope();
        
        
        
        foreach($userGroup->getGroup()->getGroupAuthScopesJoinAuthScope() as $groupScope)
        {
          $s = new ScopeEntity;
          $s->setIdentifier($groupScope->getAuthScope()->getName());
          $scopes[] = $s;
        }
      }
    }
    return $scopes;
  }
}
<?php
namespace Desirene\OAuth2\Repositories;
use DateTime;
use DateTimeInterface;
use Desirene\OAuth2\Entities\AccessTokenEntity;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use Model\AuthToken;
use Model\AuthTokenQuery;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
  public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
  {
    $token = new AuthToken;
    $token->setType('access');
    $token->setToken($accessTokenEntity->getIdentifier());
    $token->setExpires($accessTokenEntity->getExpiryDateTime());
    $token->setScope($accessTokenEntity->getScopes());
    $token->setUserId($accessTokenEntity->getUserIdentifier());
    $token->setClientId($accessTokenEntity->getClient()->getIdentifier());
    $token->setRedirectUrl($accessTokenEntity->getClient()->getRedirectUri());
    
    $token->save();
  }
  
  public function revokeAccessToken($tokenId)
  {
    $token = AuthTokenQuery::create()->findOneByToken($tokenId);
    
    if($token)
    {
      $token->delete();
    }
  }
  
  public function isAccessTokenRevoked($tokenId)
  {
    $token = AuthTokenQuery::create()->findOneByToken($tokenId);
    
    if(
      null != $token
      &&
      (
        $token->getExpires() instanceof DateTimeInterface
        &&
        $token->getExpires() > (new DateTime)
      )
    )
    {
      return false;
    }
    
    return true;
  }
  
  public function getNewToken(ClientEntityInterface $clientEntity, array $scopes = [], $userIdentifier = null)
  {
    $accessToken = new AccessTokenEntity();
    $accessToken->setClient($clientEntity);
    foreach ($scopes as $scope) {
      $accessToken->addScope($scope);
    }
    $accessToken->setUserIdentifier($userIdentifier);

    return $accessToken;
  }
}
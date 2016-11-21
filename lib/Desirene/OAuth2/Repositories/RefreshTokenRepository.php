<?php
namespace Desirene\OAuth2\Repositories;
use DateTime;
use DateTimeInterface;
use Desirene\OAuth2\Entities\RefreshTokenEntity;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use Model\AuthToken;
use Model\AuthTokenQuery;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
  public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
  {
    $token = new AuthToken;
    $token->setType('refresh');
    $token->setToken($refreshTokenEntity->getIdentifier());
    $token->setExpires($refreshTokenEntity->getExpiryDateTime());
    $token->setScope($refreshTokenEntity->getAccessToken()->getScopes());
    $token->setUserId($refreshTokenEntity->getAccessToken()->getUserIdentifier());
    $token->setClientId($refreshTokenEntity->getAccessToken()->getClient()->getIdentifier());
    $token->setRedirectUrl($refreshTokenEntity->getAccessToken()->getClient()->getRedirectUri());
    
    $token->save();
  }
  
  public function revokeRefreshToken($tokenId)
  {
    $token = AuthTokenQuery::create()->findOneByToken($tokenId);
    
    if($token)
    {
      $token->delete();
    }
  }
  
  public function isRefreshTokenRevoked($tokenId)
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
  
  public function getNewRefreshToken()
  {
    return new RefreshTokenEntity;
  }
}
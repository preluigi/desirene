<?php
namespace Desirene\OAuth2\Repositories;
use DateTime;
use DateTimeInterface;
use Desirene\OAuth2\Entities\AuthCodeEntity;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use Model\AuthCode;
use Model\AuthCodeQuery;

class AuthCodeRepository implements AuthCodeRepositoryInterface
{
  public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
  {
    $authCode = new AuthCode;
    $authCode->setAuthCode($authCodeEntity->getIdentifier());
    $authCode->setExpires($authCodeEntity->getExpiryDateTime());
    $authCode->setUserId($authCodeEntity->getUserIdentifier());
    $authCode->setClientId($authCodeEntity->getClient()->getIdentifier());
    $authCode->setRedirectUrl($authCodeEntity->getClient()->getRedirectUri());
    
    $authCode->save();
  }
  
  public function revokeAuthCode($codeId)
  {
    $authCode = AuthCodeQuery::create()->findOneByAuthCode($codeId);
    
    if($authCode)
    {
      $authCode->delete();
    }
  }
  
  public function isAuthCodeRevoked($codeId)
  {
    $authCode = AuthCodeQuery::create()->findOneByAuthCode($codeId);
    
    if(
      null != $authCode
      &&
      (
        $authCode->getExpires() instanceof DateTimeInterface
        &&
        $authCode->getExpires() > (new DateTime)
      )
    )
    {
      return false;
    }
    
    return true;
  }
  
  public function getNewAuthCode()
  {
    return new AuthCodeEntity;
  }
}
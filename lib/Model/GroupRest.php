<?php

namespace Model;

use \Model\Rest\BaseGroupRest as BaseGroupRest;
use Propel\Runtime\Collection\ObjectCollection;
/*
 * \Model\GroupRest class.
 */
class GroupRest extends BaseGroupRest
{
  public static function currentUserGroups($request, $response, $args)
  {
    $user = UserQuery::create()->findOneById($request->getAttribute('oauth_user_id'));
    $groups = [];
    foreach($user->getUserGroupsJoinGroup() as $userGroup)
    {
      $groups[] = $userGroup->getGroup()->getName();
    }
    $response->getBody()->write(
      json_encode($groups)
    );

    return $response->withHeader('Content-type', 'application/json');
  }
}

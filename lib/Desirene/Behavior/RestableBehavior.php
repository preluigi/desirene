<?php
namespace Desirene\Behavior;
use \Propel\Generator\Model\Behavior;

class RestableBehavior extends Behavior
{
  protected $additionalBuilders = ['\Desirene\Behavior\RestableBehaviorBaseBuilder', '\Desirene\Behavior\RestableBehaviorBuilder'];
}

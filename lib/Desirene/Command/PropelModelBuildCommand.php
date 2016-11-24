<?php
namespace Desirene\Command;
use Propel\Generator\Command\ModelBuildCommand;

class PropelModelBuildCommand extends ModelBuildCommand
{
  protected $cmdName = "propel:build";
  
  use PropelConfigurationCommandTrait;
}
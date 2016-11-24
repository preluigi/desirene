<?php
namespace Desirene\Command;
use Propel\Generator\Command\SqlBuildCommand;

class PropelSqlBuildCommand extends SqlBuildCommand
{
  protected $cmdName = "propel:sql:build";
  
  use PropelConfigurationCommandTrait;
}
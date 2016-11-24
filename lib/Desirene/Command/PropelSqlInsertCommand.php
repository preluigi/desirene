<?php
namespace Desirene\Command;
use Propel\Generator\Command\SqlInsertCommand;
use Desirene\Propel\Generator\Manager\SqlManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PropelSqlInsertCommand extends SqlInsertCommand
{
  protected $cmdName = "propel:sql:insert";
  
  use PropelConfigurationCommandTrait;
}
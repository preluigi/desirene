<?php
namespace Desirene\Command;
use Propel\Generator\Command\MigrationStatusCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PropelMigrationStatusCommand extends MigrationStatusCommand
{
  protected $cmdName = "propel:migration:status";
  
  use PropelConfigurationCommandTrait;
  
}
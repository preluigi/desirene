<?php
namespace Desirene\Command;
use Propel\Generator\Command\MigrationMigrateCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PropelMigrationMigrateCommand extends MigrationMigrateCommand
{
  protected $cmdName = "propel:migration:migrate";
  
  use PropelConfigurationCommandTrait;
  
}
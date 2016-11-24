<?php
namespace Desirene\Command;
use Propel\Generator\Command\MigrationUpCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PropelMigrationUpCommand extends MigrationUpCommand
{
  protected $cmdName = "propel:migration:up";
  
  use PropelConfigurationCommandTrait;
  
}
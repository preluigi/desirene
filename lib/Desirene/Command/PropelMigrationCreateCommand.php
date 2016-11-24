<?php
namespace Desirene\Command;
use Propel\Generator\Command\MigrationCreateCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PropelMigrationCreateCommand extends MigrationCreateCommand
{
  protected $cmdName = "propel:migration:create";
  
  use PropelConfigurationCommandTrait;
  
}
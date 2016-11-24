<?php
namespace Desirene\Command;
use Propel\Generator\Command\MigrationDiffCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PropelMigrationDiffCommand extends MigrationDiffCommand
{
  protected $cmdName = "propel:migration:diff";
  
  use PropelConfigurationCommandTrait;
  
}
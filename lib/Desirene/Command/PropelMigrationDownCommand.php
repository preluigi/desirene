<?php
namespace Desirene\Command;
use Propel\Generator\Command\MigrationDownCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PropelMigrationDownCommand extends MigrationDownCommand
{
  protected $cmdName = "propel:migration:down";
  
  use PropelConfigurationCommandTrait;
  
}
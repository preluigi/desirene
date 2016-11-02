<?php
namespace Desirene\Command;
use Propel\Generator\Command\ModelBuildCommand;

class PropelModelBuildCommand extends ModelBuildCommand
{
  const CONFIG_DIR = '../config';
  
  public function configure()
  {
    parent::configure();
    
    $options = $this->getDefinition()->getOptions();
    if(isset($options['config-dir']))
    {
      $options['config-dir']->setDefault(static::CONFIG_DIR);
    }
    $this->getDefinition()->setOptions($options);
    
    $this->setName('propel:build');
    $this->setAliases([]);
  }
}
<?php
namespace Desirene\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

trait PropelConfigurationCommandTrait
{
  protected $configDir = ROOT_DIR . '/config';
  
  public function configure()
  {
    parent::configure();
    
    $options = $this->getDefinition()->getOptions();
    if(isset($options['config-dir']))
    {
      $options['config-dir']->setDefault($this->configDir);
    }
    
    if(isset($options['connection']))
    {
      $options['connection']->setDefault([require(ROOT_DIR . '/config/env.php')]);
    }
    
    $this->getDefinition()->setOptions($options);
    
    $this->setName($this->getCmdName());
    $this->setAliases([]);
  }
  
  protected function getCmdName()
  {
    return $this->cmdName ?? 'command:name:needed';
  }
  
  public function execute(InputInterface $input, OutputInterface $output)
  {
    
    if($input->hasOption('connection'))
    {
      $connections = $input->getOption('connection') ?? [require(ROOT_DIR . '/env.php')];
      
      foreach($connections as &$connection)
      {
        if(false === strpos($connection, ':'))
        {
          $propelConfig = Yaml::parse(file_get_contents(ROOT_DIR . '/config/propel.yml.dist'));
          $propelConfig = array_replace_recursive($propelConfig, Yaml::parse(file_get_contents(ROOT_DIR . '/config/propel.yml')));
          
          $propelConnections = $propelConfig['propel']['database']['connections'];
          
          $connectionConfig = $propelConnections[$connection] ?? null;
          
          if(null === $connectionConfig)
          {
            unset($connection);
          }
          else
          {
            $connection = sprintf("%s=%s;user=%s;password=%s", 'default', preg_replace("/;port=([0-9]+)/", "", $connectionConfig['dsn']), $connectionConfig['user'], $connectionConfig['password']);
          }
        }
      }
      
      $input->setOption('connection', $connections);
    }
    
    parent::execute($input, $output);
  }
}

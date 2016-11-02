<?php
namespace Desirene\Command;
use Propel\Generator\Command\SqlInsertCommand;
use Desirene\Propel\Generator\Manager\SqlManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PropelSqlInsertCommand extends SqlInsertCommand
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
    if(isset($options['connection']))
    {
      $options['connection']->setDefault(['dev']);
    }
    $this->getDefinition()->setOptions($options);
    
    $this->setName('propel:sql-insert');
    $this->setAliases([]);
  }
  
  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
      $manager = new SqlManager();
      
      $configOptions = [];
      if($sqlDir = $input->getOption('sql-dir'))
      {
        $configOptions['propel']['paths']['sqlDir'] = $sqlDir;
      }

      $generatorConfig = $this->getGeneratorConfig($configOptions, $input);
      
      $connections = [];
      $optionConnections = $input->getOption('connection');
      if(!$optionConnections)
      {
        $connections = $generatorConfig->getBuildConnections();
      }
      else
      {
        $filterConnections = array_filter(
          $optionConnections,
          function($connection)
          {
            return false === strpos($connection, ":");
          }
        );
        
        $optionConnections = array_filter(
          $optionConnections,
          function($connection)
          {
            return false !== strpos($connection, ":");
          }
        );
        
        if(!empty($filterConnections))
        {
          $connections = $generatorConfig->getBuildConnections();
          $connections = array_filter(
            $connections,
            function($c, $name) use($filterConnections)
            {
              return in_array($name, $filterConnections);
            },
            ARRAY_FILTER_USE_BOTH
          );
        }
        else
        {
          foreach ($optionConnections as $connection) {
            list($name, $dsn, $infos) = $this->parseConnection($connection);
            $connections[$name] = array_merge(['dsn' => $dsn], $infos);
          }
        }
      }

      $manager->setConnections($connections);
      $manager->setLoggerClosure(function ($message) use ($input, $output) {
          if ($input->getOption('verbose')) {
              $output->writeln($message);
          }
      });
      $manager->setWorkingDirectory($generatorConfig->getSection('paths')['sqlDir']);

      if(isset($filterConnections) && !empty($filterConnections))
      {
        $manager->insertSql(array_pop($filterConnections));
      }
      else
      {
        $manager->insertSql();
      }
  }
}
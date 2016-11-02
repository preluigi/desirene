<?php
use Propel\Common\Config\ConfigurationManager;
use Propel\Generator\Config\ArrayToPhpConverter;

$configManager = new ConfigurationManager(ROOT_DIR . '/config');

$outputFilePath = ROOT_DIR . '/cache/databases.php';

if(!file_exists($outputFilePath))
{
  $options['connections'] = $configManager->getConnectionParametersArray();
  $options['defaultConnection'] = $configManager->getSection('runtime')['defaultConnection'];
  $options['log'] = $configManager->getSection('runtime')['log'];
  $options['profiler'] = $configManager->getConfigProperty('runtime.profiler');

  $phpConf = ArrayToPhpConverter::convert($options);
  $phpConf = "<?php
  " . $phpConf;

  file_put_contents($outputFilePath, $phpConf);
}
return require $outputFilePath;
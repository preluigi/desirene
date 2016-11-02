<?php
use Propel\Common\Config\ConfigurationManager;
use Propel\Generator\Config\ArrayToPhpConverter;

$configManager = new ConfigurationManager(ROOT_DIR . '/config');

$outputFilePath = ROOT_DIR . '/cache/databases.php';

if(!file_exists($outputFilePath))
{
  $connections = $configManager->getConnectionParametersArray();
  
  $phpCode = "<?php\n\n";
  
  foreach($connections as $name => $connection)
  {
    $phpConf = ArrayToPhpConverter::convert([
      'connections'       => [$name => $connection],
      'defaultConnection' => $configManager->getSection('runtime')['defaultConnection'],
      'log'               => $configManager->getSection('runtime')['log'],
      'profiler'          => $configManager->getConfigProperty('runtime.profiler')
    ]);
    
    $phpCode .= sprintf("\n\$connections['%s'] = function(){\n%s\n};\n", $name, $phpConf);
  }
  
  file_put_contents($outputFilePath, $phpCode);
}
require $outputFilePath;

$connection = $connections[ENV] ?? null;

if(null !== $connection)
{
  $connection();
}
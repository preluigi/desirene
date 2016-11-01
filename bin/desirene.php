<?php
require_once __DIR__.'/../lib/vendor/autoload.php';

use Symfony\Component\Finder\Finder;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputOption;

use Propel\Runtime\Propel;
use Propel\Generator\Application;

$app = new Application('Desirene framework', 'v0.1');

$finder = new Finder();
$finder->files()->name('*.php')->in(__DIR__.'/../lib/Desirene/Command')->depth(0);

$ns = '\\Desirene\\Command\\';

foreach ($finder as $file) {
    $r  = new \ReflectionClass($ns.$file->getBasename('.php'));
    if ($r->isSubclassOf('Symfony\\Component\\Console\\Command\\Command') && !$r->isAbstract()) {
        $cmd = $r->newInstance();
        $app->add($cmd);
    }
}

$finder = new Finder();
$finder->files()->name('*.php')->in(__DIR__.'/../lib/vendor/propel/propel/src/Propel/Generator/Command')->depth(0);

$ns = '\\Propel\\Generator\\Command\\';

foreach ($finder as $file) {
    $r  = new \ReflectionClass($ns.$file->getBasename('.php'));
    if ($r->isSubclassOf('Symfony\\Component\\Console\\Command\\Command') && !$r->isAbstract()) {
        $cmd = $r->newInstance();
        $cmd->setName(sprintf("propel:%s", str_replace(":", "-", $cmd->getName())));
        $options = $cmd->getDefinition()->getOptions();
        if(isset($options['config-dir']))
        {
          $options['config-dir']->setDefault('../config');
          if(isset($options['output-file']))
          {
            $options['output-file']->setDefault('databases.php');
          }
          $cmd->getDefinition()->setOptions($options);
        }
        $app->add($cmd);
    }
}

$app->run();
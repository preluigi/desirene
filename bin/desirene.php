<?php
define("ROOT_DIR",realpath(__DIR__ . '/../'));
require_once ROOT_DIR . '/lib/vendor/autoload.php';
define("ENV", require ROOT_DIR . '/config/env.php');
require ROOT_DIR . '/lib/Desirene/config/databases.php';

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
$finder->files()->name('*.php')->in(__DIR__.'/../lib/Command')->depth(0);

$ns = '\\Command\\';

foreach ($finder as $file) {
  $r  = new \ReflectionClass($ns.$file->getBasename('.php'));
  if ($r->isSubclassOf('Symfony\\Component\\Console\\Command\\Command') && !$r->isAbstract()) {
    $cmd = $r->newInstance();
    $app->add($cmd);
  }
}

$finder = new Finder();
$finder->files()->name('*.php')->in(__DIR__.'/../lib/Command')->depth(0);

$ns = '\\Command\\';

foreach ($finder as $file) {
  $r  = new \ReflectionClass($ns.$file->getBasename('.php'));
  if ($r->isSubclassOf('Symfony\\Component\\Console\\Command\\Command') && !$r->isAbstract()) {
    $cmd = $r->newInstance();
    $app->add($cmd);
  }
}

$app->run();

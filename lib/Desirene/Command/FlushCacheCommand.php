<?php
namespace Desirene\Command;

use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use \Symfony\Component\Filesystem\Filesystem;
use \Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class FlushCacheCommand extends Command
{
  const CACHE_DIR = __DIR__ . '/../../../cache';
  protected function configure()
  {
    $this
      ->setName('flush-cache')
      ->setDescription("Flush the cache directory content.");
  }
  
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $output->writeln('Flushing cache directory content...');
    $finder = new Finder();
    $finder->in(self::CACHE_DIR)->depth(0);
    $fs = new Filesystem;
    try
    {
      foreach($finder as $path)
      {
        $fs->remove($path);
      }
      $output->writeln('...flush complete!');
    }
    catch(IOExceptionInterface $e)
    {
      echo $e->getMessage();
    }
  }
}

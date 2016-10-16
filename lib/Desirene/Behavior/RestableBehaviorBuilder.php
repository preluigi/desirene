<?php
namespace Desirene\Behavior;
use \Propel\Generator\Builder\Om\AbstractOMBuilder;

class RestableBehaviorBuilder extends AbstractOMBuilder
{
  public $overwrite = false;
  
  public function getUnprefixedClassName()
  {
    return $this->getStubObjectBuilder()->getUnprefixedClassName() . 'Rest';
  }
  
  protected function addClassOpen(&$script)
  {
    $script .= <<<eos
use \\{$this->getNamespace()}\\Rest\\Base{$this->getUnprefixedClassName()} as Base{$this->getUnprefixedClassName()};
/*
 * {$this->getClassname()} class.
 */
class {$this->getUnprefixedClassName()} extends Base{$this->getUnprefixedClassName()}
{
  
eos;
  }
  
  protected function addClassBody(&$script)
  {
    $script .= <<<eos
eos;
  }
  
  protected function addClassClose(&$script)
  {
    $script .= <<<eos

}
eos;
  }
}

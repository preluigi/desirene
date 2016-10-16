<?php
namespace Desirene\Behavior;

class RestableBehaviorBuilder extends \OMBuilder
{
  public function getUnprefixedClassname()
  {
    return $this->getStubObjectBuilder()->getUnprefixedClassname() . 'Rest';
  }
  
  protected function addClassOpen(&$script)
  {
    $script .= <<<eos
/*
 * {$this->getClassname()} class.
 */
class {$this->getClassname()} extends {$this->getStubObjectBuilder()}
{
eos;
  }
  
  protected function addClassBody(&$script)
  {
    $script .= <<<eos
  //ToDo
eos;
  }
  
  protected function addClassClose(&$script)
  {
    $script .= <<<eos
}
eos;
  }
}

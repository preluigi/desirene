<?php
namespace Desirene\Setting;

class LoggerSetting
{
  public static function parse($settings = [])
  {
    if(isset($settings['path']))
    {
      $settings['path'] = ROOT_DIR . $settings['path'];
    }
    if(isset($settings['level']))
    {
      $settings['level'] = constant("\Monolog\Logger::{$settings['level']}");
    }
    
    return $settings;
  }
}
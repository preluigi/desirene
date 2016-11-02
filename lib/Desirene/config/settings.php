<?php
$parser = new \Desirene\Setting\YamlSettingParser(ROOT_DIR . '/cache');
$defaultSettings = $parser->parse(ROOT_DIR . '/lib/Desirene/config/settings.yml', ENV);
$defaultSettings['http_host'] = (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
return $parser->parse(ROOT_DIR . '/config/settings.yml', ENV, $defaultSettings);

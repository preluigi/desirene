<?php
$settings = [
    'env' => 'dev',
    'http_host' => (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'],
    'settings' => [
      'displayErrorDetails' => true,
      'addContentLengthHeader' => false,
    ],
    'logger' => [
      'name' => 'slim-app',
      'path' => __DIR__ . '/../logs/app.log',
      'level' => \Monolog\Logger::DEBUG,
    ]
];

$parser = new \Desirene\Setting\YamlSettingParser(ROOT_DIR . '/cache');

$cacheFilename = sprintf("cached-settings-%d.php", filemtime(ROOT_DIR . '/config/settings.yml'));

if(!file_exists(ROOT_DIR . '/cache/' . $cacheFilename))
{
  $settings = array_replace_recursive($settings, $parser->parse(ROOT_DIR . '/config/settings.yml'));

  file_put_contents(
    ROOT_DIR . '/cache/' . $cacheFilename,
    sprintf(
      "<?php\nreturn %s;",
      var_export((array)$settings, true)
    )
  );
}

return require ROOT_DIR . '/cache/' . $cacheFilename;

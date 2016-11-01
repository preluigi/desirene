<?php
$settings = [
    'env' => ENV,
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

return $parser->parse(ROOT_DIR . '/config/' . ENV . '/settings.yml', $settings);

<?php 
session_start();
require_once __DIR__ . '/vendor/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => $info['app_id'],
  'app_secret' => $info['app_secret'],
  'default_graph_version' => 'v2.10',
  ]);

?>
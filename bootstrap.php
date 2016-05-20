<?php
// Copyright 2016 Jannis Fink
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

require_once __DIR__ . '/vendor/autoload.php';

if (!defined('HIGHSCORE_CONFIG')) {
  $highscoreConfig = __DIR__ . '/highscore.ini';
  if (!file_exists($highscoreConfig)) {
    throw new RuntimeException('Configuration file (' . $highscoreConfig . ') does not exists. You have to copy
    the highscore.sample.ini in the same directory and change it\'s values to match your environment');
  }
  define('HIGHSCORE_CONFIG', $highscoreConfig);
}

// doctrine configuration
$configuration = new \Fink\config\Configuration(HIGHSCORE_CONFIG);

$paths = array('src');
$devMode = $configuration->get('general', 'devmode');

$dbConnection = array(
  'driver' => $configuration->get('database', 'driver'),
  'user' => $configuration->get('database', 'user'),
  'password' => $configuration->get('database', 'password'),
  'dbname' => $configuration->get('database', 'dbname')
);

$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, $devMode);
$entityManager = \Doctrine\ORM\EntityManager::create($dbConnection, $config);
\Highscore\core\Doctrine::setEntityManager($entityManager);

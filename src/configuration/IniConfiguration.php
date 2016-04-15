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

namespace Highscore\configuration;

/**
 * Class IniConfiguration
 *
 * Class to load configuration stored in ini format
 *
 * @package Pong\configuration
 */
class IniConfiguration {

  private static $configuration = array();

  private $parsedConfiguration;

  /**
   * IniConfiguration constructor.
   * @param $filename string path to the configuration file
   * @throws \RuntimeException if the given file does not exist
   */
  public function __construct($filename) {
    if (array_key_exists($filename, self::$configuration)) {
      $this->parsedConfiguration = self::$configuration[$filename];
    } else {
      if (!file_exists($filename)) {
        throw new \RuntimeException($filename . 'does not exist');
      }
      self::$configuration[$filename] = parse_ini_file($filename, true);
      $this->parsedConfiguration = self::$configuration[$filename];
    }
  }

  /**
   * Gets a specific entry in the configuration.
   *
   * @param array ...$keys
   * @return mixed the value of stored in the configuration file
   * @throws \Exception if one of the keys given does not exists
   */
  public function get(...$keys) {
    $configuration = $this->parsedConfiguration;
    foreach ($keys as $key) {
      if (!array_key_exists($key, $configuration)) {
        throw new \Exception($key . ' is not present in the configuration');
      }
      $configuration = $configuration[$key];
    }
    return $configuration;
  }

}

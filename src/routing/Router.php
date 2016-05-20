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

namespace Highscore\routing;


use Fink\config\Configuration;
use Klein\Klein;

class Router extends Klein {

  /**
   * Overwrite {@link Klein} respond method to allow easier sub paths
   *
   * @param array|string $method HTTP Method to match
   * @param string $path Route URI path to match
   * @param null $callback Callable callback method to execute on route match
   * @return \Klein\Route
   */
  public function respond($method, $path = '*', $callback = null) {
    $configuration = new Configuration(HIGHSCORE_CONFIG);
    $subDirectory = $configuration->get('general', 'webroot');
    if ($path !== '*') {
      $path = $subDirectory . $path;
    }
    return parent::respond($method, $path, $callback);
  }

}

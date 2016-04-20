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

require_once __DIR__ . '/bootstrap.php';

$router = new \Highscore\routing\Router();

$router->respond('GET', '/highscores', function ($request, $response) {
  $response->json(\Highscore\score\Score::getTopScores(10));
});

$callback = function ($request, $response) {
  // FIXME find better way to get data
  $requestBody = $request->body();
  $requestData = json_decode($requestBody, true);
  $configuration = new \Highscore\configuration\IniConfiguration(HIGHSCORE_CONFIG);

  if ($requestData !== null &&
    array_key_exists('name', $requestData) &&
    array_key_exists('score', $requestData) &&
    array_key_exists('token', $requestData) &&
    $requestData['token'] === $configuration->get('security', 'token')
  ) {
    $score = new \Highscore\score\Score($requestData['name'], $requestData['score']);
    \Highscore\core\Doctrine::getEntityManager()->persist($score);
    \Highscore\core\Doctrine::getEntityManager()->flush();

    $response->json(array(
      'score' => $score->toArray(),
      'success' => true
    ));
  } else {
    $response->json(array(
      'success' => false
    ));
  }
};

$router->respond('PUT', '/highscore', $callback);
$router->respond('POST', '/highscore', $callback);

$router->dispatch();

\Highscore\core\Doctrine::getEntityManager()->flush();

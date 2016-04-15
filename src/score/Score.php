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

namespace Highscore\score;

use Highscore\core\Doctrine;

/**
 * Class Score
 *
 * Class to represent a score on database level
 *
 * @package Highscore\score
 *
 * @Entity
 * @Table(name="score")
 */
class Score {

  /**
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  private $id;

  /**
   * @Column(length=140)
   */
  private $name;

  /**
   * @Column(type="integer")
   */
  private $score;

  /**
   * @Column(type="datetime", name="date_played")
   */
  private $datePlayed;

  /**
   * Score constructor. Create a new Score object
   *
   * @param $name string name of the player
   * @param $score int his score
   * @param $datePlayed \DateTime|null the date played
   */
  public function __construct($name, $score, $datePlayed = null) {
    if ($datePlayed === null) {
      $datePlayed = new \DateTime();
    }
    $this->name = $name;
    $this->score = $score;
    $this->datePlayed = $datePlayed;
  }

  /**
   * @return string name of the player
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return int score achieved by this player
   */
  public function getScore() {
    return $this->score;
  }

  /**
   * @return \DateTime when the player played this
   */
  public function getDatePlayed() {
    return $this->datePlayed;
  }

  /**
   * @param $number int how many of the best players you want to show
   * @return array an associative array containing rank, name and score
   */
  public static function getTopScores($number) {
    $entityManager = Doctrine::getEntityManager();
    $result = array();

    $queryBuilder = $entityManager->createQueryBuilder();
    $queryBuilder->select('s')->from(static::class, 's')->orderBy('s.score', 'DESC')->setMaxResults($number);
    $scores = $queryBuilder->getQuery()->getResult();

    for ($i = 0; $i < count($scores); $i++) {
      $score = $scores[$i];
      array_push($result, array(
        'name' => $score->getName(),
        'score' => $score->getScore(),
        'rank' => $i + 1
      ));
    }

    return $result;
  }

}

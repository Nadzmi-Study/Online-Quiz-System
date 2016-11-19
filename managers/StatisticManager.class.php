<?php
/**
 * Created using PhpStorm.
 * Project: Online-Quiz-System
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 2:40 PM
 */

require_once "Manager.class.php";

class StatisticManager extends Manager {
    private $SC; // statistic controller

    public function __construct(StatisticController $SC) {
        $this->SC = $SC;
    }

    /**
     * calculate and display statistics
     *
     * @param Quiz[] $quizes
     */
    public function calculateStatistic($quizes) {}
}
?>
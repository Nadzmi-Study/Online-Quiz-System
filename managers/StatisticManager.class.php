<?php
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
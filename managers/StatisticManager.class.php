<?php
require_once "Manager.class.php";

class StatisticManager extends Manager {
    private $SC; // statistic controller

    /**
     * StatisticManager constructor.
     *
     * @param StatisticController|null $SC
     */
    public function __construct(StatisticController $SC=null) {
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
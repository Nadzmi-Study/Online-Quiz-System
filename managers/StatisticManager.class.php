<?php
require_once "Manager.class.php";

/**
 * Class StatisticManager
 *
 * @todo implement other StatisticManager's methods
 */
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
}
?>
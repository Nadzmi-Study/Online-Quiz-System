<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 14/11/2016
 * Time: 11:21 PM
 */
class Subject
{
    private $typeValue;
    private $typeDesc;

    public function __construction($typeValue="", $typeDesc="")
    {
        $this->typeValue = $typeValue;
        $this->typeDesc = $typeDesc;
    }

    public function getValue()
    {
        return $this->typeValue;
    }

    public function getDesc()
    {
        return $this->typeDesc;
    }
}
?>
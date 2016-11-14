<?php
/**
 * Created using PhpStorm.
 * Project: OnlineQuizSystem
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 12:08 AM
 */

class Controller {
    public function select($conn, $attr, $table, $where=null, $single=false) {
        if(isset($where))
            $sql = "SELECT $attr FROM $table WHERE $where";
        else
            $sql = "SELECT $attr FROM $table";

        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if(mysqli_num_rows($query) > 0) {
            $result = array();

            while($row = mysqli_fetch_assoc($query))
                array_push($result, $row);

            if($single)
                return $result[0];
            else
                return $result;
        } else
            return null;
    }

    public function insert($conn, $table, $attr, $values, $where=null) {}

    public function update($conn, $table, $set, $where=null) {}

    public function delete($conn, $table, $where=null) {}
}
?>
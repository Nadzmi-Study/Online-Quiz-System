<?php
/**
 * Created using PhpStorm.
 * Project: OnlineQuizSystem
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 12:08 AM
 */

class Controller {
    /**
     * function for select statement
     *
     * @param $conn -> Connection variables (passed in the global include file)
     * @param $attr -> Attribute(column name) to select from database
     * @param $table -> Table name to select from database
     * @param null $where -> Where condition. (if not specified, the default value is null)
     * @param bool $single -> true = select single record from table, false = select multi record from table (default is false)
     * @return array|mixed|null -> if there are no record, it will return null, else it will return array of associations
     */
    public function select($conn, $table, $attr, $where=null, $single=false) {
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

    /**
     * function for insert statement
     *
     * @param $conn -> Connection variables (passed in the global include file)
     * @param $table -> Table name to insert into database
     * @param $attr -> Attribute(column name) to insert into database
     * @param $values -> Values to insert together with the new record
     * @param null $where -> Where condition. (if not specified, the default value is null)
     * @return int|string -> Return the id resulting from the insert process
     */
    public function insert($conn, $table, $attr, $values, $where=null) {
        if(isset($where))
            $sql = "INSERT INTO $table($attr) VALUES($values) WHERE $where";
        else
            $sql = "INSERT INTO $table($attr) VALUES($values)";

        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        return mysqli_insert_id($conn);
    }

    /**
     * @param $conn -> Connection variables (passed in the global include file)
     * @param $table -> Table name to update in database
     * @param $set -> Set values to update in database
     * @param null $where -> Where condition. (if not specified, the default value is null)
     * @return bool -> Will return true if successful, but display error if failed.(from 'mysqli_query() or die(mysqli_error())')
     */
    public function update($conn, $table, $set, $where=null) {
        if(isset($where))
            $sql = "UPDATE $table SET $set WHERE $where";
        else
            $sql = "UPDATE $table SET $set";

        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        return true;
    }

    /**
     * @param $conn -> Connection variables (passed in the global include file)
     * @param $table -> Table name to be deleted in database
     * @param null $where -> Where condition. (if not specified, the default value is null)
     * @return bool -> Will return true if successful, but display error if failed.(from 'mysqli_query() or die(mysqli_error())')
     */
    public function delete($conn, $table, $where=null) {
        if(isset($where))
            $sql = "DELETE $table WHERE $where";
        else
            $sql = "DELETE $table WHERE $where";

        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        return true;
    }
}
?>
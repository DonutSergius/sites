<?php

namespace Sites\Services;

use mysqli;

class DBService
{
    public function getDBConf()
    {
        return  mysqli_connect('localhost', 'root', '', 'sites');;
    }

    public function getData($select_labels, $table, $conditions = "")
    {
        $select_labels = $this->setLabel($select_labels);
        $sql = "SELECT " . $select_labels . " FROM " . $table . $conditions;
        $conn = $this->getDBConf();
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);

        return $result;
    }

    private function setLabel($labels)
    {
        $fields = implode(', ', $labels);
        return $fields;
    }

    public function setData($select_labels, $table, $data)
    {
        $select_labels = $this->setLabel($select_labels);
        $values = array_map(function ($value) {
            return "'" . addslashes($value) . "'";
        }, $data);

        $values_string = implode(", ", $values);
        $sql = "INSERT INTO " . $table . " (" . $select_labels . ") VALUES (" . $values_string . ")";

        $connection = $this->getDBConf();

        if (mysqli_query($connection, $sql)) {
            mysqli_close($connection);
            return TRUE;
        } else {
            mysqli_close($connection);
            return "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
    }
}

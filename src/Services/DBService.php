<?php

namespace Sites\Services;

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
        $sql = "INSERT INTO " . $table . "( " . $select_labels . " )";
        return NULL;
    }
}

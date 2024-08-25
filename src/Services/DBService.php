<?php

namespace Sites\Services;

class DBService
{
    public function getDBConf()
    {
        return  mysqli_connect('localhost', 'root', '', 'sites');;
    }

    public function getData($query, $table)
    {
        $sql = $query . $table;
        $conn = $this->getDBConf();
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);

        return $result;
    }

    public function setLabel($labels)
    {
        if (empty($labels)) {
            return "SELECT * FROM ";
        }
        $fields = implode(', ', $labels);
        $sql = "SELECT $fields FROM ";
        return $sql;
    }

    private function setData($table, array $data)
    {
        return NULL;
    }
}

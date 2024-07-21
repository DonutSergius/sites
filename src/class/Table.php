<?php

class Table
{
    private $table_name;
    private $header_labels = [];
    private $body_rows = [];

    public function __construct($table_name, $header_labels, $body_rows)
    {
        $this->table_name = $table_name;
        $this->header_labels = $header_labels;
        $this->body_rows = $body_rows;
    }

    public function getTableName()
    {
        return $this->table_name;
    }

    public function getHeaderLabels()
    {
        return $this->header_labels;
    }

    public function getBodyRows()
    {
        return $this->body_rows;
    }

    public function toArray()
    {
        return [
            'table_name' => $this->getTableName(),
            'header_labels' => $this->getHeaderLabels(),
            'body_rows' => $this->getBodyRows(),
        ];
    }
}

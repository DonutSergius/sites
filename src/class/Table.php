<?php

namespace Sites\Class;

class Table
{
    private $table_name;
    private $header_labels = [];
    private $body_rows = [];

    public function __construct($table_name = NULL, $header_labels = NULL, $body_rows = NULL)
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

    public function getVacationLabels($columns)
    {
        $all_headers = [
            'user_nickname' => 'User',
            'vacation_type' => 'Type',
            'vacation_date_type' => 'Time type',
            'vacation_date_start' => 'Date start',
            'vacation_date_end' => 'Date end',
            'vacation_reason' => 'Reason',
            'vacation_status' => 'Status',
            'vacation_approval' => 'Approval',
        ];

        $header_labels = [];
        foreach ($columns as $column) {
            if (isset($all_headers[$column])) {
                $header_labels[] = [
                    'title' => $all_headers[$column],
                    'machine_name' => $column
                ];
            }
        }

        return $header_labels;
    }

    public function getOperationLabels($columns)
    {
        $all_headers = [
            'operation_name' => 'Name',
            'operation_count_before' => 'Before',
            'operation_count' => 'Action',
            'operation_count_after' => 'Result',
            'operation_date' => 'Date',
        ];

        $header_labels = [];
        foreach ($columns as $column) {
            if (isset($all_headers[$column])) {
                $header_labels[] = [
                    'title' => $all_headers[$column],
                    'machine_name' => $column
                ];
            }
        }

        return $header_labels;
    }

    public function getCertificateLabels($columns)
    {
        $all_headers = [
            'certificate_name' => 'Name',
            'certificate_date_start' => 'Date Start',
            'certificate_date_end' => 'Date End',
            'certificate_count_days' => 'Count Days',
            'certificate_type' => 'Type',
        ];

        $header_labels = [];
        foreach ($columns as $column) {
            if (isset($all_headers[$column])) {
                $header_labels[] = [
                    'title' => $all_headers[$column],
                    'machine_name' => $column
                ];
            }
        }

        return $header_labels;
    }

    public function formatDate($date_value, $format = 'Y-m-d')
    {
        $date = new \DateTime($date_value);
        return $date->format($format);
    }
}

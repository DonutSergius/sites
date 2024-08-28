<?php

namespace Sites\Table;

use Sites\Class\Table;

class MyCertificatesTable
{
    private $table;

    public function __construct()
    {
        $this->table = new Table();
    }

    function buildTable($vacation_data)
    {
        $table_name = 'my-certificates-list';

        if (!empty($vacation_data)) {
            $first_row = $vacation_data[0];
            $header_labels = $this->table->getCertificateLabels(array_keys($first_row));
            $body_rows = $this->getBodyRows($vacation_data, array_keys($first_row));
        } else {
            $header_labels = [];
            $body_rows = [];
        }

        $this->table->setName($table_name);
        $this->table->setHeaders($header_labels);
        $this->table->setRows($body_rows);

        $loader = new \Twig\Loader\FilesystemLoader('templates/');
        $twig = new \Twig\Environment($loader);

        return $twig->render('table.twig.html', $this->table->toArray());
    }

    function getBodyRows($vacation_data, $columns)
    {
        $body_rows = [];
        foreach ($vacation_data as $row) {
            $body_row = [];
            foreach ($columns as $column_name) {
                $value = $row[$column_name];

                $body_row[] = [
                    'class' => $column_name,
                    'value' => $value
                ];
            }

            $body_rows[] = $body_row;
        }

        return $body_rows;
    }
}

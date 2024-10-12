<?php

namespace Sites\Page;

use Sites\Class\Page;
use Sites\Form\StatisticFilterForm;
use Sites\Table\HomePageTable;
use Sites\Services\DBService;

class StatisticPage
{

    public function buildPage()
    {
        $service = new DBService;
        $labels = ['*'];

        $data = $service->getData($labels, '`homepageview`');

        $content = [
            ['name' => 'coool-field', 'content' => (new StatisticFilterForm)->buildForm()],
            ['name' => 'statistic-table', 'content' => (new HomePageTable)->buildTable($data)],
        ];

        return new Page('Statistic', $content, '');
    }

    public function updatedPage()
    {
        $author = $_POST['vacation-author'] ?? null;
        $type = $_POST['vacation-type'] ?? null;
        $timeType = $_POST['vacation-time'] ?? null;

        $data = $this->getDataFiltered($author, $type, $timeType);
        $result = mysqli_fetch_all($data, MYSQLI_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function getDataFiltered($author, $type, $timeType)
    {
        $service = new DBService;
        $con = $service->getDBConf();
        // Створіть SQL запит на основі параметрів
        $query = "SELECT * FROM `homepageview` WHERE 1=1";

        if ($author) {
            $query .= " AND `user_nickname` = ?";
        }
        if ($type) {
            $query .= " AND `vacation_type` = ?";
        }
        if ($timeType) {
            $query .= " AND `vacation_date_type` = ?";
        }

        // Підготуйте запит
        $stmt = $con->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($con->error));
        }

        // Підготовка параметрів
        $params = [];
        $types = '';

        if ($author) {
            $params[] = $author;
            $types .= 's'; // 's' для string
        }
        if ($type) {
            $params[] = $type;
            $types .= 's';
        }
        if ($timeType) {
            $params[] = $timeType;
            $types .= 's';
        }

        // Прив'язування параметрів, якщо вони є
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }

        // Виконання запиту
        if (!$stmt->execute()) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }

        // Отримання результату
        $result = $stmt->get_result();

        // Закриття запиту
        $stmt->close();

        return $result;
    }
}
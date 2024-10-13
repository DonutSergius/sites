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

        $data = $service->getData($labels, '`homepageview`', 'ORDER BY `vacation_id` DESC');

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

        // Базовий запит
        $query = "SELECT * FROM `homepageview` WHERE 1=1";

        // Підготовка параметрів
        $params = [];
        $types = '';

        // Додаємо умови лише якщо параметри не порожні
        if ($author && $author != '*') {
            $query .= " AND `user_nickname` = ?";
            $params[] = $author;
            $types .= 's'; // 's' для string
        }
        if ($type && $type != '*') {
            $query .= " AND `vacation_type` = ?";
            $params[] = $type;
            $types .= 's';
        }
        if ($timeType && $timeType != '*') {
            $query .= " AND `vacation_date_type` = ?";
            $params[] = $timeType;
            $types .= 's';
        }

        // Додаємо сортування після всіх умов
        $query .= " ORDER BY `vacation_id` DESC";

        // Підготуйте запит
        $stmt = $con->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($con->error));
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
        $con->close();

        return $result;
    }

}
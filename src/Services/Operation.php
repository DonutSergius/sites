<?php

namespace Sites\Services;

use Sites\Services\DBService;

class Operation
{
    public function getOperation($user_id)
    {
        $conn = (new DBService)->getDBConf();
        return (new DBService)->getData(["*"], "operation");
    }

    public function setOperation($user_id, $op_name, $count_before, $count_days, $count_after, $start)
    {
        $conn = (new DBService)->getDBConf();
        $sql_op = "INSERT INTO operation (
            operation_user_id, operation_name, operation_count_before, operation_count, operation_count_after, operation_date)
            VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt_op = mysqli_prepare($conn, $sql_op)) {
            mysqli_stmt_bind_param(
                $stmt_op,
                "isiiis",
                $user_id,
                $op_name,
                $count_before,
                $count_days,
                $count_after,
                $start,
            );
            mysqli_stmt_execute($stmt_op);
        }

        mysqli_close($conn);
    }
}


<?php
header('Content-type: application/json');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../config/conn.php';




function get_sensor_report($conn)
{
    $from = trim($_POST['from'] ?? '');
    $to = trim($_POST['to'] ?? '');
    $type = trim($_POST['type'] ?? '0');
    // Shared data model — all users see all sensor data
    $where = "WHERE 1";

    if ($type === 'custom') {
        if ($from === '' || $to === '') {
            echo json_encode(array("status" => false, "data" => "Custom date range requires both From and To dates."));
            return;
        }

        $from_date = $conn->real_escape_string($from);
        $to_date = $conn->real_escape_string($to);
        $where .= " AND DATE(created_at) BETWEEN '$from_date' AND '$to_date'";
    }

    $count_query = "SELECT COUNT(*) AS total FROM `sensor_data` $where";
    $count_result = $conn->query($count_query);
    $total_records = 0;

    if ($count_result) {
        $count_row = $count_result->fetch_assoc();
        $total_records = intval($count_row['total']);
    } else {
        echo json_encode(array("status" => false, "data" => $conn->error));
        return;
    }

    $query = "SELECT * FROM `sensor_data` $where ORDER BY created_at DESC";
    $result = $conn->query($query);
    $array_data = array();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $array_data[] = $row;
        }

        $meta = array(
            "total_records" => $total_records,
        );

        echo json_encode(array("status" => true, "data" => $array_data, "meta" => $meta));
    } else {
        echo json_encode(array("status" => false, "data" => $conn->error));
    }
}

if (isset($_POST['action'])) {
    $action = $_POST['action']; //userka function-ka uu rabo buu ugudbiyaaa
    if (function_exists($action)) {
        $action($conn);
    } else {
        echo json_encode(array("status" => false, "data" => "Invalid action: $action"));
    }
} else {
    echo json_encode(array("status" => false, "data" => "Action is Required"));
}
?>

<?php
header('Content-type: application/json');
include __DIR__ . '/../config/conn.php';
include __DIR__ . '/../config/validation.php';



function register_admin($conn)
{
    extract($_POST);
    $data = array();

    // Username validation
    $username_error = validate_username(isset($username) ? $username : "");
    if ($username_error !== null) {
        echo json_encode(array("status" => false, "data" => $username_error));
        return;
    }

    // Password validation
    $password_error = validate_password(isset($password) ? $password : "");
    if ($password_error !== null) {
        echo json_encode(array("status" => false, "data" => $password_error));
        return;
    }

    try {
        $query = "INSERT INTO `admin`(`id`, `username`, `password`, `email`) VALUES ('', '$username', MD5('$password'), '$email')";

        $result = $conn->query($query); //Excute

        // Check if there is error or not
        if ($result) {
            $data = array("status" => true, "data" => "Registered Successfully");
        } else {
            $duplicate = duplicate_entry_message($conn->error);
            $data = array("status" => false, "data" => $duplicate !== null ? $duplicate : $conn->error);
        }
    } catch (mysqli_sql_exception $e) {
        // This "catches" the crash and turns it into a clean message
        $duplicate = duplicate_entry_message($e->getMessage());
        $data = array("status" => false, "data" => $duplicate !== null ? $duplicate : "Database Error: " . $e->getMessage());
    }


    echo json_encode($data);
}

function update_admin($conn)
{

    extract($_POST); // wax kasto post sheegta extract ku same waxa dhexda ku jira un sa uqaato
    $data = array();


    try {
        $query = "UPDATE `admin` SET `username`='$username',`password`=MD5('$password'),`email`='$email' WHERE id = '$update_id'";

        $result = $conn->query($query); //Excute

        // Check if there is error or not
        if ($result) {
            $data = array("status" => true, "data" => "Updated Successfully");
        } else {
            $data = array("status" => false, "data" => $conn->error);
        }
    } catch (mysqli_sql_exception $e) {

        $data = array("status" => false, "data" => "Database Error: " . $e->getMessage());
    }

    echo json_encode($data);
}

function readAll($conn)
{
    $data = array();
    $array_data = array();

    $query = "SELECT `id`, `username`, `email`, `created_at` FROM `admin` WHERE 1;";
    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $array_data[] = $row;
        }
        $data = array("status" => true, "data" => $array_data);
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}

function get_admin_info($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();

    $query = "SELECT * FROM admin where id = '$id'";
    $result = $conn->query($query);

    if ($result) {
        $row = $result->fetch_assoc();

        $data = array("status" => true, "data" => $row);
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}

function delete_admin_info($conn)
{
    extract($_POST);
    $data = array();


    $query = "DELETE FROM admin WHERE id = '$id'";
    $result = $conn->query($query);

    if ($result) {
        $data = array("status" => true, "data" => "Admin deleted successfully!");
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }


    echo json_encode($data);
}



if (isset($_POST['action'])) {
    $action = $_POST['action']; //userka function-ka uu rabo buu ugudbiyaaa
    $action($conn);
} else {
    echo json_encode(array("status" => false, "data" => "Action is Required"));
}
?>
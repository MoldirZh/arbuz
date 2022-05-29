<?php
$host = "localhost"; 
$user = "root"; 
$password = ""; 
$dbname = "arbuz";

$con = mysqli_connect($host, $user, $password,$dbname);

$method = $_SERVER['REQUEST_METHOD'];
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

switch ($method) {
  case 'POST':
    $row = $_POST["row"];
    $column = $_POST["column"];
    $status = $_POST["status"];
    $quantity = $_POST["quantity"];
    $weight = $_POST["weight"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $cut = $_POST["cut"];

    $select_row_col_sql = "SELECT * FROM `place` WHERE `row` = $row AND `col` = $column";
    if(mysqli_num_rows(mysqli_query($con, $select_row_col_sql)) < 1) {
      die(mysqli_error($con));
      echo "This row does not exist";
      break;
    }

    $sql = "INSERT INTO `orders`(`row`, `col`, `status`, `quantity`, 
      `weight`, `address`, `phone`, `date`, `time`, `cut`) VALUES ('$row', '$column', 
      '$status', '$quantity', '$weight', '$address', '$phone', '$date', '$time', 
      '$cut')";
    
    $delete_sql = "DELETE FROM `place` WHERE `row` = $row AND `col` = $column";
    $delete_result = mysqli_query($con, $delete_sql);
    if (!$delete_result) {
      http_response_code(404);
      die(mysqli_error($con));
    }
    break;
}

$result = mysqli_query($con,$sql);

if (!$result) {
  http_response_code(404);
  die(mysqli_error($con));
}

echo json_encode($result);
echo mysqli_affected_rows($con);

$con->close();
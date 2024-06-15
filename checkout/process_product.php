<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "buy_shu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['PRODUCT_ID']) && is_numeric($_GET['PRODUCT_ID'])) {
    $product_id = intval($_GET['PRODUCT_ID']);

    $stmt = $conn->prepare("SELECT PRODUCT_NAME, PRODUCT_PRICE, PRODUCT_STOCK FROM PRODUCT WHERE PRODUCT_ID = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    $stmt->close();

    header('Content-Type: application/json');
    echo json_encode($items);
} else {
    header('Content-Type: application/json');
    echo json_encode(["error" => "Invalid PRODUCT_ID"]);
}

$conn->close();
?>

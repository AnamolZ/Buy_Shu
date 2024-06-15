<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "buy_shu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT PRODUCT_ID, PRODUCT_NAME, PRODUCT_PRICE, PRODUCT_STOCK, UPLOAD , CATEGORY_ID FROM PRODUCT";
$result = $conn->query($sql);

$productList = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $productList[] = [
            'product_id' => $row["PRODUCT_ID"],
            'product_name' => $row["PRODUCT_NAME"],
            'product_price' => (float) $row["PRODUCT_PRICE"],
            'product_stock' => (int) $row["PRODUCT_STOCK"],
            'upload' => $row["UPLOAD"],
            'category_id' => $row["CATEGORY_ID"]
        ];
    }
} else {
    $productList = [];
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($productList);
?>
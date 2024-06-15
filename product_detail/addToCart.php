<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "buy_shu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['operation']) || $data['operation'] !== 'AddToCart') {
        $response = ['success' => false, 'message' => 'Invalid operation'];
    } else {
        if (!isset($data['customer_id']) || !isset($data['product_id'])) {
            $response = ['success' => false, 'message' => 'Missing customer_id or product_id'];
        } else {
            $customer_id = $data['customer_id'];
            $product_id = $data['product_id'];

            // Check if the product already exists in the cart
            $check_sql = "SELECT COUNT(*) AS count FROM cart WHERE customer_id = ? AND product_id = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("ii", $customer_id, $product_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            $row = $check_result->fetch_assoc();

            if ($row['count'] > 0) {
                // Product already in cart
                $response = ['success' => false, 'message' => 'Product is already in cart'];
            } else {
                // Product not in cart, add it
                $add_sql = "INSERT INTO cart (customer_id, product_id, product_quantity) 
                            VALUES (?, ?, 1)";
                $add_stmt = $conn->prepare($add_sql);
                $add_stmt->bind_param("ii", $customer_id, $product_id);

                if ($add_stmt->execute()) {
                    $response = ['success' => true, 'message' => 'Product added to cart'];
                } else {
                    $response = ['success' => false, 'message' => 'Error adding product to cart'];
                }

                $add_stmt->close();
            }

            $check_stmt->close();
        }
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid request'];
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>

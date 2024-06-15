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
    $operation = $_POST['operation'];

    if ($operation === 'Update') {
        $customer_id = $_POST['customer_id'];
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        $sql = "UPDATE CART SET PRODUCT_QUANTITY = ? WHERE CUSTOMER_ID = ? AND PRODUCT_ID = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $quantity, $customer_id, $product_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Quantity updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating quantity: " . $stmt->error]);
        }

        $stmt->close();
        exit;
    } elseif ($operation === 'Delete') {
        $customer_id = $_POST['customer_id'];
        $product_id = $_POST['product_id'];

        $sql = "DELETE FROM CART WHERE CUSTOMER_ID = ? AND PRODUCT_ID = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $customer_id, $product_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Item deleted successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error deleting item: " . $stmt->error]);
        }

        $stmt->close();
        exit;
    }
}

$customer_id = isset($_GET['customer_id']) ? (int)$_GET['customer_id'] : 0;

$customer_sql = "SELECT FIRST_NAME, LAST_NAME, ADDRESS, EMAIL FROM CUSTOMER WHERE CUSTOMER_ID = $customer_id";
$customer_result = $conn->query($customer_sql);
$customer_info = $customer_result->fetch_assoc();

$order_sql = "SELECT ORDER_DETAIL.SHIPPING_ADDRESS, ORDER_DETAIL.ORDER_AMOUNT, ORDER_DETAIL.ORDER_STATUS
              FROM ORDERS 
              JOIN ORDER_DETAIL ON ORDERS.PAYMENT_ID = ORDER_DETAIL.PAYMENT_ID 
              WHERE ORDERS.CUSTOMER_ID = $customer_id";
$order_result = $conn->query($order_sql);
$order_details = [];
while ($row = $order_result->fetch_assoc()) {
    $order_details[] = $row;
}

$cart_sql = "SELECT PRODUCT.PRODUCT_ID, PRODUCT.PRODUCT_NAME, CART.PRODUCT_QUANTITY
             FROM CART 
             JOIN PRODUCT ON CART.PRODUCT_ID = PRODUCT.PRODUCT_ID 
             WHERE CART.CUSTOMER_ID = $customer_id";
$cart_result = $conn->query($cart_sql);
$cart_items = [];
while ($row = $cart_result->fetch_assoc()) {
    $cart_items[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/footer_section.css">
    <link rel="stylesheet" href="../styles/customer_profile.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const customerId = localStorage.getItem('customer_id');
            if (customerId && !window.location.search.includes(`customer_id=${customerId}`)) {
                window.location.href = `?customer_id=${customerId}`;
            } else if (!customerId) {
                alert('No customer ID found in localStorage.');
            }

            const updateButtons = document.querySelectorAll('.update-btn');
            updateButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const quantitySelect = document.querySelector(`.quantity-select[data-product-id="${productId}"]`);
                    const quantity = quantitySelect.value;

                    const formData = new FormData();
                    formData.append('operation', 'Update');
                    formData.append('customer_id', <?= $customer_id ?>);
                    formData.append('product_id', productId);
                    formData.append('quantity', quantity);

                    fetch('', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Quantity updated successfully');
                        } else {
                            alert('Error updating quantity');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error updating quantity');
                    });
                });
            });

            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');

                    const formData = new FormData();
                    formData.append('operation', 'Delete');
                    formData.append('customer_id', <?= $customer_id ?>);
                    formData.append('product_id', productId);
                    console.log(productId);

                    fetch('', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Item deleted successfully');
                        } else {
                            alert('Error deleting item');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error deleting item');
                    });
                });
            });
   
        });
    </script>
</head>
<body>
    <?php include '../navbar/navbar.php'; ?>

    <div class="demo-page">
        <div class="demo-page-navigation">
            <nav>
                <ul>
                    <li><a href="#information">Customer Information</a></li>
                    <li id="recent-link"><a href="#recent-purchase">Your Orders Details</a></li>
                    <li id="cart-link"><a href="#cart-section">Cart Products</a></li>
                    <li id="checkout-link"><a href="../checkout/checkout.php">Checkout Cart Product</a></li>
                </ul>
            </nav>
        </div>
        <main class="demo-page-content">
            <section>
                <div class="href-target" id="information"></div>
                <h1 class="package-name">Customer Information</h1>
                <p> 
                    Customers, in this context, refer to individuals or entities who purchase goods or services from traders. 
                    They play a crucial role in the trading process by providing the demand that drives traders' businesses. 
                    Customers benefit from traders' ability to manage their product offerings, which allows for a diverse selection of items, 
                    easy access to product information, and the ability to make informed purchasing decisions. 
                    This functionality enables customers to enjoy a seamless and satisfying shopping experience, 
                    encouraging repeat business and fostering positive relationships between traders and their clientele.
                </p>
                <strong>About Customer:</strong>
                <ul>
                    <li id="first_name">First Name: <?= htmlspecialchars($customer_info['FIRST_NAME']) ?></li>
                    <li id="last_name">Last Name: <?= htmlspecialchars($customer_info['LAST_NAME']) ?></li>
                    <li id="email_customer">Email Address: <?= htmlspecialchars($customer_info['EMAIL']) ?></li>
                    <li id="location">Location: <?= htmlspecialchars($customer_info['ADDRESS']) ?></li>
                </ul>
            </section>

            <section id="recent-link-pur">
                <div class="href-target" id="recent-purchase"></div>
                <h1 class="package-name">Order Details</h1>
                <p> 
                    Order Detail refers to a recent transaction details or acquisition, often used for customer engagement, inventory management, marketing, and gaining customer insights
                </p>
                <ul id="product_order_list" class="nice-list">
                <?php if (empty($order_details)): ?>
                    <p>No order details found. Buy some goods to get the order detail over here.</p>
                <?php else: ?>
                    <?php foreach ($order_details as $detail): ?>
                        <div style="display: flex; justify-content: space-between;">
                            <div>
                                <strong>Shipping Address:</strong> <?= htmlspecialchars($detail['SHIPPING_ADDRESS']) ?><br>
                                <strong>Order Amount:</strong> $<?= htmlspecialchars($detail['ORDER_AMOUNT']) ?><br>
                                <strong>Delivery Status:</strong> <?= htmlspecialchars($detail['ORDER_STATUS']) ?><br>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </ul>
            </section>

            <section id="cart-link-section">
                <div class="href-target" id="cart-section"></div>
                <h1 class="package-name">Cart Section</h1>
                <ul id="cart_list" class="cart-list">
                    <?php if (empty($cart_items)): ?>
                        <p>No items in the cart. Add some items to show them in this section.</p>
                    <?php else: ?>
                        <?php foreach ($cart_items as $item): ?>
                            <li>
                                <strong>Product Name:</strong> <?= htmlspecialchars($item['PRODUCT_NAME']) ?><br>
                                <strong>Quantity:</strong>
                                <select class="quantity-select" data-product-id="<?= $item['PRODUCT_ID'] ?>">
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?= $i ?>" <?= $i == $item['PRODUCT_QUANTITY'] ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <button class="update-btn" data-product-id="<?= $item['PRODUCT_ID'] ?>">Update</button>
                                <button class="delete-btn" data-product-id="<?= $item['PRODUCT_ID'] ?>">Delete</button>
                            </li>
                            <hr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </section>
        </main>
    </div>

    <?php include '../footer/footer_section.php'; ?>
</body>
</html>

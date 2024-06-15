<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "buy_shu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$trader_id = isset($_GET['trader_id']) ? (int)$_GET['trader_id'] : 0;
$trader_sql = "SELECT TRADER_ID, TRADER_NAME, TRADER_PASSWORD, TRADER_EMAIL FROM TRADER WHERE TRADER_ID = ?";
$stmt = $conn->prepare($trader_sql);
$stmt->bind_param("i", $trader_id);
$stmt->execute();
$trader_result = $stmt->get_result();
$trader_info = $trader_result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $operation = isset($_POST['operation']) ? $_POST['operation'] : '';

    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
    $product_price = isset($_POST['product_price']) ? (float)$_POST['product_price'] : 0;
    $product_stock = isset($_POST['product_stock']) ? (int)$_POST['product_stock'] : 0;
    $product_detail = isset($_POST['product_detail']) ? $_POST['product_detail'] : '';
    $allergy_information = isset($_POST['allergy_information']) ? $_POST['allergy_information'] : '';
    $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;

    if ($operation === 'Create Product') {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["upload"]["name"]);
        $upload_ok = 1;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["upload"]["tmp_name"]);
        if ($check === false) {
            echo "<p class='error'>File is not an image.</p>";
            $upload_ok = 0;
        }

        if (file_exists($target_file)) {
            echo "<p class='error'>Sorry, file already exists.</p>";
            $upload_ok = 0;
        }

        if ($_FILES["upload"]["size"] > 500000) {
            echo "<p class='error'>Sorry, your file is too large.</p>";
            $upload_ok = 0;
        }

        if (!in_array($image_file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "<p class='error'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
            $upload_ok = 0;
        }

        if ($upload_ok == 0) {
            echo "<p class='error'>Sorry, your file was not uploaded.</p>";
        } else {
            if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO PRODUCT (PRODUCT_NAME, PRODUCT_PRICE, PRODUCT_STOCK, PRODUCT_DETAIL, ALLERGY_INFORMATION, UPLOAD, CATEGORY_ID) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    die("Prepare failed: " . $conn->error);
                }
                $stmt->bind_param("sdiissi", $product_name, $product_price, $product_stock, $product_detail, $allergy_information, $target_file, $category_id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo "<p class='success'>Product inserted successfully.</p>";
                } else {
                    echo "<p class='error'>Error inserting product.</p>";
                }

                $stmt->close();
            } else {
                echo "<p class='error'>Sorry, there was an error uploading your file.</p>";
            }
        }
    } elseif ($operation === 'Delete Product') {
        $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

        $stmt = $conn->prepare("DELETE FROM PRODUCT WHERE PRODUCT_ID = ?");
        $stmt->bind_param("i", $product_id);

        if ($stmt->execute()) {
            echo "<p class='success'>Product deleted successfully.</p>";
        } else {
            echo "<p class='error'>Error deleting product: " . $conn->error . "</p>";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<link rel="stylesheet" href="../styles/navbar.css">
<link rel="stylesheet" href="../styles/footer_section.css">
<script src="../scripts/trader_login.js"></script>
<link rel="stylesheet" href="../styles/trader_profile.css">

<style>
  .toggle-code {
    margin-top: 10px;
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    color: #fff;
    background-color: #4CAF50;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.toggle-code:hover {
    background-color: #45a049;
}

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const traderId = localStorage.getItem('trader_id');
        if (traderId && !window.location.search.includes(`trader_id=${traderId}`)) {
            window.location.href = `?trader_id=${traderId}`;
        } else if (!traderId) {
            alert('No Trader ID found in localStorage.');
        }
    });
</script>
<?php include '../navbar/navbar.php'; ?>

<div class="demo-page">
  <div class="demo-page-navigation">
    <nav>
      <ul>
        <li>
          <a href="#structure">Trader Information</a>
        </li>
        <li>
          <a href="#edit-product">Manage - Trader Product</a>
        </li>
      </ul>
    </nav>
  </div>
  <main class="demo-page-content">
    <section>
      <div class="href-target" id="structure"></div>
      <h1 class="package-name">Trader Information</h1>
      <p>
        Traders, in this context, refer to individuals or businesses actively involved in selling goods and services.
        They possess the ability to manage their product offerings by adding new items, editing existing listings,
        and removing products from their inventory as needed. This functionality empowers traders to maintain an up-to-date
        and organized catalog of items available for sale, ensuring a smooth and efficient trading experience for
        both themselves and their customers.
      </p>
      <strong>About Traders:</strong>
      <ul>
          <li id="trader_id">Trader ID: <?= htmlspecialchars($trader_info['TRADER_ID']) ?></li>
          <li id="trader_name">Trader Name: <?= htmlspecialchars($trader_info['TRADER_NAME']) ?></li>
          <li id="trader_password">Trader Password: <?= htmlspecialchars($trader_info['TRADER_PASSWORD']) ?></li>
          <li id="trader_email">Trader Email: <?= htmlspecialchars($trader_info['TRADER_EMAIL']) ?></li>
      </ul>
    </section>

    <section>
      <div class="href-target" id="edit-product"></div>
      <h1>Delete - Edit Product</h1>
      <p>You Can Delete & Edit Your Store Products</p>

      <form method="POST" enctype="multipart/form-data">
        <div class="nice-form-group">
          <label>Product ID</label>
          <input name="product_id" id="product_id" type="number" placeholder="Your Product ID Number" value="" />
        </div>

        <div class="nice-form-group">
          <label>Product Name</label>
          <input name="product_name" id="product_name" type="text" placeholder="Your Product Name" value="" />
        </div>

        <div class="nice-form-group">
          <label for="product-image">Product Image</label>
          <input name="upload" type="file" id="upload" accept="image/*">
        </div>

        <div class="nice-form-group">
          <label>Product Price</label>
          <input name="product_price" id="product_price" type="number" placeholder="Your Product Price" value="" />
        </div>

        <div class="nice-form-group">
          <label>Product Stock</label>
          <input name="product_stock" id="product_stock" type="number" placeholder="Your Product Stock" value="" />
        </div>

        <div class="nice-form-group">
          <label>Product Details</label>
          <input name="product_detail" id="product_detail" type="text" placeholder="Your Product Details" value="" />
        </div>

        <div class="nice-form-group">
          <label>Allergy Information</label>
          <input name="allergy_information" id="allergy_information" type="text" placeholder="Your Product Allergy Information" />
        </div>

        <div class="nice-form-group">
          <label>Category ID</label>
          <input name="category_id" id="category_id" type="number" placeholder="Your Category ID" value="" />
        </div>

        <div class="nice-form-group">
          <label>Select Operation</label>
          <select name="operation" id="operation-select">
            <option value="Create Product">Create Product</option>
            <option value="Delete Product">Delete Product</option>
          </select>
        </div>

        <button type="submit" class="toggle-code">Save Changes</button>
      </form>
    </section>
  </main>
</div>

<?php include '../footer/footer_section.php'; ?>

<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "buy_shu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operation = $_POST['operation'] ?? '';
    $customer_id = $_POST['customer_id'] ?? null;
    $password = $_POST['password'] ?? null;
    $first_name = $_POST['first_name'] ?? null;
    $last_name = $_POST['last_name'] ?? null;
    $address = $_POST['address_customer'] ?? null;
    $email = $_POST['customer_email'] ?? null;

    if ($operation === 'sign_in' && $customer_id && $password) {
        $sql = "SELECT * FROM CUSTOMER WHERE CUSTOMER_ID = ? AND PASSWORD = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $customer_id, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response = ['status' => 'success', 'message' => 'Login successful', 'customer_id' => $customer_id];
        } else {
            $response = ['status' => 'error', 'message' => 'Login failed: Invalid ID or Password'];
        }
    } elseif ($operation === 'sign_up' && $first_name && $last_name && $address && $email && $password) {
        $sql = "SELECT * FROM CUSTOMER WHERE EMAIL = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response = ['status' => 'error', 'message' => 'Error creating account: Email already in use'];
        } else {
            $sql = "INSERT INTO CUSTOMER (FIRST_NAME, LAST_NAME, ADDRESS, EMAIL, PASSWORD) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $first_name, $last_name, $address, $email, $password);

            if ($stmt->execute()) {
                $customer_id = $stmt->insert_id;
                $response = ['status' => 'success', 'message' => 'Account created successfully', 'customer_id' => $customer_id];
            } else {
                $response = ['status' => 'error', 'message' => 'Error creating account: ' . $stmt->error];
            }
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid operation or missing parameters'];
    }

    echo json_encode($response);
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../styles/navbar.css">
    <script src="../scripts/navbar.js"></script>
    <link rel="stylesheet" href="../styles/footer_section.css">
    <link rel="stylesheet" href="../styles/customer_login.css" />
</head>
<body>
    <?php include '../navbar/navbar.php'; ?>

    <main>
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">
                    <form method="POST" action="#" autocomplete="off" class="sign-in-form" id="loginForm">
                        <div class="logo">
                            <img src="../images/loginsign/logo.png" alt="PantryParadise" />
                            <h4>Pantry Paradise</h4>
                        </div>

                        <div class="heading">
                            <h2>Welcome Back Customer</h2>
                            <h6>Not registered yet?</h6>
                            <a href="#" class="toggle">Sign up</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" class="input-field" autocomplete="off" name="customer_id" required id="customerId" />
                                <label>Customer ID</label>
                            </div>

                            <div class="input-wrap">
                                <input type="password" minlength="4" class="input-field" autocomplete="off" name="password" required id="password" />
                                <label>Password</label>
                            </div>

                            <input type="hidden" name="operation" value="sign_in">
                            <input type="submit" value="Sign In" class="sign-btn" />
                        </div>
                    </form>

                    <form method="POST" action="#" autocomplete="off" class="sign-up-form hidden" id="signupForm">
                        <div class="logo">
                            <img src="../images/loginsign/logo.png" alt="PantryParadise">
                            <h4>Pantry Paradise</h4>
                        </div>

                        <div class="heading">
                            <h2>Get Started</h2>
                            <h6>Already have an account?</h6>
                            <a href="#" class="toggle" id="showSignIn">Sign in</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" class="input-field" autocomplete="off" name="first_name" required id="firstName">
                                <label for="firstName">First Name</label>
                            </div>

                            <div class="input-wrap">
                                <input type="text" class="input-field" autocomplete="off" name="last_name" required id="lastName">
                                <label for="lastName">Last Name</label>
                            </div>

                            <div class="input-wrap">
                                <input type="text" class="input-field" autocomplete="off" name="address_customer" required id="addressCustomer">
                                <label for="addressCustomer">Address</label>
                            </div>                        

                            <div class="input-wrap">
                                <input type="email" class="input-field" autocomplete="off" name="customer_email" required id="customerEmail">
                                <label for="customerEmail">Email</label>
                            </div>                        

                            <div class="input-wrap">
                                <input type="password" minlength="4" class="input-field" autocomplete="off" name="password" required id="signupPassword">
                                <label for="signupPassword">Password</label>
                            </div>                                                

                            <input type="hidden" name="operation" value="sign_up">
                            <input type="submit" value="Sign Up" class="sign-btn">
                        </div>
                    </form>
                </div>

                <div class="carousel">
                    <div class="images-wrapper">
                        <img src="../images/loginsign/image1.png" class="image img-1 show" alt="" />
                        <img src="../images/loginsign/image2.png" class="image img-2" alt="" />
                    </div>

                    <div class="text-slider">
                        <div class="bullets">
                            <span class="active" data-value="1"></span>
                            <span data-value="2"></span>
                            <span data-value="3"></span>
                        </div>
                    </div> 
                </div> 
            </div>
        </div>
    </main>

    <?php include '../footer/footer_section.php'; ?>

    <script src="../scripts/customer_login.js"></script>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const response = await fetch(event.target.action, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            if (result.status === 'success') {
                localStorage.setItem('customer_id', result.customer_id);
                alert(result.message);
                window.location.href = '../';
            } else {
                alert(result.message);
            }
        });

        document.getElementById('signupForm').addEventListener('submit', async function(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const response = await fetch(event.target.action, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            if (result.status === 'success') {
                alert(result.message + ' Your Customer ID is: ' + result.customer_id);
                window.location.href = '../';
            } else {
                alert(result.message);
            }
        });

        document.querySelector('.toggle').addEventListener('click', function() {
            document.querySelector('.sign-in-form').classList.toggle('hidden');
            document.querySelector('.sign-up-form').classList.toggle('hidden');
        });

        document.getElementById('showSignIn').addEventListener('click', function() {
            document.querySelector('.sign-in-form').classList.remove('hidden');
            document.querySelector('.sign-up-form').classList.add('hidden');
        });
    </script>
</body>
</html>

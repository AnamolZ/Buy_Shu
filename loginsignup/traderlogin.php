<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "buy_shu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operation = $_POST['operation'] ?? '';

    if ($operation === 'sign_in') {
        $trader_id = $_POST['trader_id'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM TRADER WHERE TRADER_ID = ? AND TRADER_PASSWORD = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $trader_id, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response = ['status' => 'success', 'message' => 'Login successful', 'trader_id' => $trader_id];
        } else {
            $response = ['status' => 'error', 'message' => 'Login failed: Invalid ID or Password'];
        }
    } elseif ($operation === 'sign_up') {
        $trader_name = $_POST['trader_name'];
        $password = $_POST['password'];
        $email = $_POST['trader_email'];

        $sql = "SELECT * FROM TRADER WHERE TRADER_EMAIL = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response = ['status' => 'error', 'message' => 'Error creating account: Email already in use'];
        } else {
            $sql = "INSERT INTO TRADER (TRADER_NAME, TRADER_PASSWORD, TRADER_EMAIL) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $trader_name, $password, $email);

            if ($stmt->execute()) {
                $trader_id = $stmt->insert_id;
                $response = ['status' => 'success', 'message' => 'Account created successfully', 'trader_id' => $trader_id];
            } else {
                $response = ['status' => 'error', 'message' => 'Error creating account: ' . $stmt->error];
            }
        }
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
    <link rel="stylesheet" href="../styles/trader_login.css" />
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
                            <h2>Welcome Back Trader</h2>
                            <h6>Not registered yet?</h6>
                            <a href="#" class="toggle">Sign up</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" class="input-field" autocomplete="off" name="trader_id" required id="traderId" />
                                <label>Trader ID</label>
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
                                <input type="text" class="input-field" autocomplete="off" name="trader_name" required id="traderName">
                                <label for="traderName">Trader Name</label>
                            </div>

                            <div class="input-wrap">
                                <input type="password" minlength="4" class="input-field" autocomplete="off" name="password" required id="signupPassword">
                                <label for="signupPassword">Password</label>
                            </div>

                            <div class="input-wrap">
                                <input type="password" minlength="4" class="input-field" autocomplete="off" name="confirm_password" required id="confirmPassword">
                                <label for="confirmPassword">Confirm Password</label>
                            </div>

                            <div class="input-wrap">
                                <input type="email" class="input-field" autocomplete="off" name="trader_email" required id="traderEmail">
                                <label for="traderEmail">Email</label>
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

    <script src="../scripts/trader_login.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            formData.append('operation', 'sign_in');
            
            const response = await fetch(event.target.action, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            alert(result.message);
            if (result.status === 'success') {
                localStorage.setItem('trader_id', result.trader_id);
                window.location.href = '../';
            }
        });

        document.getElementById('signupForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const password = document.getElementById('signupPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (password !== confirmPassword) {
                alert('Passwords do not match');
                return;
            }

            const formData = new FormData(event.target);
            formData.append('operation', 'sign_up');
            
            const response = await fetch(event.target.action, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            if (result.status === 'success') {
                alert(result.message + ' Your Trader ID is: ' + result.trader_id);
                window.location.href = '../';
            } else {
                alert(result.message);
            }
        });

        document.querySelectorAll('.toggle').forEach(toggleButton => {
            toggleButton.addEventListener('click', () => {
                document.querySelector('.sign-in-form').classList.toggle('hidden');
                document.querySelector('.sign-up-form').classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>

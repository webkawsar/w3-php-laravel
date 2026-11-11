
<?php include 'header.php'; ?>

<?php
    if (isset($_POST['login_form_submit'])) {

        try {

            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validation
            if (empty($email)) {
                $_SESSION['error'] = "Email is required.";
            } elseif (empty($password)) {
                $_SESSION['error'] = "Password is required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email address.";
            } else {

                // Fetch user
                $stmt = $pdo->prepare("
                    SELECT id, name, email, phone, password
                    FROM users
                    WHERE email = ?
                    LIMIT 1
                ");

                $stmt->execute([$email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verify credentials
                if ($user && password_verify($password, $user['password'])) {

                    // Set session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['user'] = $user; // Store the entire user array in session
                    $_SESSION['success'] = "Login successful.";

                    // Redirect
                    header("Location: " . BASE_URL . "/index.php");
                    exit();

                } else {

                    $_SESSION['error'] = "Invalid email or password.";
                }
            }

        } catch (PDOException $e) {

            error_log($e->getMessage());
            $_SESSION['error'] = "Something went wrong. Please try again later.";
        }

    }

?>

<div class="container-login">
    <main class="form-signin w-100 m-auto">
        <h1 class="text-center">Admin Login</h1>

        <form action="" method="post">
            <div class="form-floating">
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    id="floatingInput"
                    placeholder="name@example.com"
                    autocomplete="username"
                >

                <label for="floatingInput">Email address</label>
            </div>

            <div class="form-floating">
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    id="floatingPassword"
                    placeholder="Password"
                    autocomplete="current-password"
                >

                <label for="floatingPassword">Password</label>
            </div>

            <button
                class="w-100 btn btn-lg btn-primary"
                type="submit"
                name="login_form_submit"
            >
                Login
            </button>
        </form>

        <div class="login-forget-password">
            <a href="forget-password.php">Forget Password</a>
        </div>
    </main>
</div>

<?php include 'footer.php'; ?>

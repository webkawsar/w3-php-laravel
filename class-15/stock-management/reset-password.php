<?php include 'header.php'; ?>

<?php

    if (!isset($_GET['email']) && !isset($_GET['token'])) {
        $_SESSION['error'] = "Invalid request.";
        header("Location:". BASE_URL . "/forget-password.php");
        exit;
    }

    $email = $_GET['email'];
    $token = $_GET['token'];

    // Fetch user
    $stmt = $pdo->prepare("
                SELECT *
                FROM users
                WHERE email = ?
                AND token = ?
                AND status = ?
            ");

    $stmt->execute([$email, $token, 'Active']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        $_SESSION['error'] = "Invalid request.";
        header("Location:". BASE_URL . "/forget-password.php");
        exit;
    }

    // Handle form submission
    if (isset($_POST['reset_password_submit'])) {

       try {
            $password = $_POST['password'] ?? '';
            $retype_password = $_POST['retype_password'] ?? '';

            // Validation
            if (empty($password)) {
                $_SESSION['error'] = "Password is required.";
            } elseif (empty($retype_password)) {
                $_SESSION['error'] = "Retype Password is required.";
            } elseif ($password !== $retype_password) {
                $_SESSION['error'] = "Passwords do not match.";
            } else {
                // Update password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $update_stmt = $pdo->prepare("UPDATE users SET password = ?, token = NULL WHERE email = ?");
                $update_stmt->execute([$hashed_password, $email]);

                $_SESSION['success'] = "Password has been reset successfully. You can now log in.";
                header("Location:". BASE_URL . "/login.php");
                exit;
            }
       } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
       }
    }

?>

<div class="container-login">
    <main class="form-signin w-100 m-auto">
        <form action="" method="post">
            <h1 class="text-center">Reset Password</h1>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password"
                    autocomplete="off">
                <label for="floatingPassword">New Password</label>
            </div>
            <div class="form-floating">
                <input type="password" name="retype_password" class="form-control" id="floatingPassword"
                    placeholder="Retype Password" autocomplete="off">
                <label for="floatingPassword">Retype Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="reset_password_submit">Submit</button>
        </form>
    </main>
</div>

<?php include 'footer.php'; ?>
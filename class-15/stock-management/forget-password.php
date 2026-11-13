<?php include 'header.php'; ?>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/vendor/autoload.php';

?>

<?php
    if (isset($_POST['forget_password_submit'])) {

        try {

            $email = trim($_POST['email'] ?? '');

            // Validation
            if (empty($email)) {
                throw new Exception("Email is required.");
            } 
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email address.");
            }
            
            // Fetch user
            $stmt = $pdo->prepare("
                SELECT *
                FROM users
                WHERE email = ?
                AND status = ?
            ");

            $stmt->execute([$email, 'Active']);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$user) {
                throw new Exception("No active user found with this email.");
            }

            // valid user found, generate a password reset token and send email
            $token = hash('sha256', bin2hex(random_bytes(16))); // Generate a random token
            $update_stmt = $pdo->prepare("UPDATE users SET token = ? WHERE email = ?");
            $update_stmt->execute([$token, $email]);

            // sending email to user
            $reset_link = BASE_URL . "/reset-password.php?email=" . $email . "&token=" . $token;
            $email_message = 'Please click on this link to reset your password: <br>';
            $email_message .= '<a href="'.$reset_link.'">Click Here</a>';
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->SMTPSecure = SMTP_ENCRYPTION;
            $mail->Port = SMTP_PORT;
            $mail->setFrom(SMTP_FROM);
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body = $email_message;
            $mail->send();

            $_SESSION['success'] = "Password reset instructions have been sent to your email.";
            header("Location: " . BASE_URL . "/login.php");
            exit();

        } catch (Exception $e) {

            $_SESSION['error'] = $e->getMessage();
        }

    }

?>


<div class="container-login">
    <main class="form-signin w-100 m-auto">
        <form action="" method="post">
            <h1 class="text-center">Forget Password</h1>
        
            <div class="form-floating">
                <input type="text" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="off">
                <label for="floatingInput">Email address</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="forget_password_submit">Submit</button>
        </form>
        <div class="login-forget-password">
            <a href="<?php echo BASE_URL; ?>/login.php">Back to Login Page</a>
        </div>
    </main>
</div>

<?php include 'footer.php'; ?>
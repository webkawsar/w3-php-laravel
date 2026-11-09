<?php include 'header.php'; ?>

<?php

    if(isset($_POST['login_form_submit'])) {
        
        try {

            $email = $_POST['email'];
            $password = $_POST['password'];

            // validation checking
            if(empty($email)) {
                $_SESSION['error'] = "Email is required.";
            }

            if(empty($password)) {
                $_SESSION['error'] = "Password is required.";
            }

            // If there are no validation errors, proceed with login
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user && password_verify($password, $user['password'])) {
                // Successful login
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['success'] = "Login successful.";
                header("Location:" . BASE_URL . "index.php");
                exit();
            } else {
                // Invalid credentials
                $_SESSION['error'] = "Invalid email or password.";
            }
            
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            
        }
    }

?>

<div class="container-login">
    <main class="form-signin w-100 m-auto">
        <h1 class="text-center">Admin Login</h1>
        <form action="" method="post">
            <div class="form-floating">
                <input type="text" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="off">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" autocomplete="off">
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="login_form_submit">Login</button>
        </form>
        <div class="login-forget-password">
            <a href="forget-password.php">Forget Password</a>
        </div>
    </main>
</div>

<?php include 'footer.php'; ?>
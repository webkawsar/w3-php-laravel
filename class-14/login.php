<?php include 'header.php'; ?>

<div class="container-login">
    <main class="form-signin w-100 m-auto">
        <h1 class="text-center">Admin Login</h1>
        <form action="index.php" method="post">
            <div class="form-floating">
                <input type="text" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="off">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" autocomplete="off">
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="form1">Login</button>
        </form>
        <div class="login-forget-password">
            <a href="forget-password.php">Forget Password</a>
        </div>
    </main>
</div>

<?php include 'footer.php'; ?>
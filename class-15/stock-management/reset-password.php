<?php include 'header.php'; ?>

<div class="container-login">
    <main class="form-signin w-100 m-auto">
        <form action="" method="post">
            <h1 class="text-center">Reset Password</h1>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" autocomplete="off">
                <label for="floatingPassword">New Password</label>
            </div>
            <div class="form-floating">
                <input type="password" name="retype_password" class="form-control" id="floatingPassword" placeholder="Retype Password" autocomplete="off">
                <label for="floatingPassword">Retype Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="form1">Submit</button>
        </form>
    </main>
</div>

<?php include 'footer.php'; ?>
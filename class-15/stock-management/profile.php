<?php include 'header.php'; ?>
<?php include 'top.php'; ?>

<?php
    if (isset($_POST['profile_edit_form_submit'])) {

        try {

            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $retype_password = trim($_POST['retype_password'] ?? '');

            // Validation
            if (empty($name)) {
                throw new Exception("Name is required.");  
            } 

            if(empty($email)) {
                throw new Exception("Email is required.");
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email address.");
            }

            // check if email already exists for another user
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$email, $_SESSION['user_id']]);
            if($stmt->rowCount() > 0) {
                throw new Exception("Email already exists.");
            }

            if(empty($phone)) {
                throw new Exception("Phone number is required.");
            }

            if(!empty($password) || !empty($retype_password)) {
                if(strlen($password) < 5) {
                    throw new Exception("Password must be at least 5 characters long.");
                }

                if($password !== $retype_password) {
                    throw new Exception("Passwords do not match.");
                }
            } else {
                
                $password = $_SESSION['user']['password']; // Keep the existing password if not changed
            }

            // Update user profile
            $stmt = $pdo->prepare("
                UPDATE users
                SET name = ?, email = ?, phone = ?, password = ?
                WHERE id = ?
            ");
            $stmt->execute([$name, $email, $phone, password_hash($password, PASSWORD_DEFAULT), $_SESSION['user_id']]);

            // updated session variables
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['user'] = array_merge($_SESSION['user'], ['name' => $name, 'email' => $email, 'phone' => $phone]);
            $_SESSION['success'] = "Profile updated successfully.";
            header("Location: " . BASE_URL . "/profile.php");
            exit();

        } catch (Exception $e) {

            $_SESSION['error'] = $e->getMessage();
        }

    }

?>


<div class="right-part container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4 pb-3">

            <h1 class="page-heading">Edit Profile</h1>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <!-- <div class="col-md-3">
                        <img src="images/admin.jpg" class="img-thumbnail mb_10" alt="">
                        <input type="file" name="photo" class="form-control">
                    </div> -->
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($_SESSION['name']); ?>">
                            </div>
                            <!-- <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="lastname" value="">
                            </div> -->
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Phone</label>
                                <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($_SESSION['user']['phone']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Retype Password</label>
                                <input type="password" class="form-control" name="retype_password">
                            </div>
                            <div class="col-md-12 mb-3">
                                <input type="submit" value="Update" name="profile_edit_form_submit" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </main>
    </div>
</div>

<?php include 'footer.php'; ?>
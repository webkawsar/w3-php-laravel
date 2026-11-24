<?php include '../header.php'; ?>
<?php include '../top.php'; ?>

<?php

    if(isset($_POST['customer_add_form_submit'])) {
        $name = trim($_POST['name']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $due_balance = trim($_POST['due_balance']);
        $status = $_POST['status'];

        try {
            if(empty($name)) {
                throw new Exception("Name is required");
            }

            if(empty($phone)) {
                throw new Exception("Phone is required");
            }

            if(empty($address)) {
                throw new Exception("Address is required");
            }

            if ($due_balance === '') {
                throw new Exception("Due Balance is required");
            }

            // check if customer phone already exists
            $sql = "SELECT * FROM customers WHERE phone = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$phone]);
            if($stmt->rowCount() > 0) {
                throw new Exception("Customer phone already exists");
            }

            $sql = "INSERT INTO customers (name, phone, address, due_balance, status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $phone, $address, $due_balance, $status]);

            $_SESSION['success'] = "Customer added successfully!";
            header("Location: " . BASE_URL . "/customers/index.php");
            exit();

        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }

?>

<div class="right-part container-fluid">
    <div class="row">
        <?php include '../sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4 pb-3">

            <h1 class="page-heading">
                Add New Customer
                <a href="<?php echo BASE_URL ?>/customers/index.php" class="btn btn-primary btn-sm right"><i class="fas fa-eye"></i> Show All</a>
            </h1>

            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Phone<span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Address<span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control" cols="30" rows="6"><?php if(isset($_POST['address'])) echo $_POST['address']; ?></textarea>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Due Balance<span class="text-danger">*</span></label>
                        <input type="text" name="due_balance" class="form-control" value="<?php if(isset($_POST['due_balance'])) echo $_POST['due_balance']; ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Status</label>
                        <select name="status" class="form-control select2">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <button type="submit" name="customer_add_form_submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<?php include '../footer.php'; ?>
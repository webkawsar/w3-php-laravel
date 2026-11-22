<?php include '../header.php'; ?>
<?php include '../top.php'; ?>

<?php

    if(isset($_POST['brand_add_form_submit'])) {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $status = $_POST['status'];

        try {
            if(empty($name)) {
                throw new Exception("Name is required");
            }

            // check if brand name already exists
            $sql = "SELECT * FROM brands WHERE name = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name]);
            if($stmt->rowCount() > 0) {
                throw new Exception("Brand name already exists");
            }

            $sql = "INSERT INTO brands (name, description, status) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $description, $status]);

            $_SESSION['success'] = "Brand added successfully!";
            header("Location: " . BASE_URL . "/brands/index.php");
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
                Add New Brand
                <a href="<?php echo BASE_URL ?>/brands/index.php" class="btn btn-primary btn-sm right"><i class="fas fa-eye"></i> Show All</a>
            </h1>

            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Description</label>
                        <textarea name="description" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Status</label>
                        <select name="status" class="form-control select2">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <!--                 
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">State</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Country</label>
                        <select name="" class="form-control select2">
                            <option value="">Bangladesh</option>
                            <option value="">USA</option>
                            <option value="">Canada</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Subject</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Map</label>
                        <textarea name="" class="form-control h_200" cols="30" rows="10"></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Message</label>
                        <textarea name="" class="form-control editor" cols="30" rows="10"></textarea>
                    </div> -->

                    <div class="col-md-12 mb-3">
                        <button type="submit" name="brand_add_form_submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<?php include '../footer.php'; ?>
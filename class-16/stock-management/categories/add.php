<?php include '../header.php'; ?>
<?php include '../top.php'; ?>

<?php

    if(isset($_POST['category_add_form_submit'])) {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $status = $_POST['status'];

        try {
            if(empty($name)) {
                throw new Exception("Name is required");
            }

            // check if category name already exists
            $sql = "SELECT * FROM categories WHERE name = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name]);
            if($stmt->rowCount() > 0) {
                throw new Exception("Category name already exists");
            }

            $sql = "INSERT INTO categories (name, description, status) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $description, $status]);

            $_SESSION['success'] = "Category added successfully!";
            header("Location: " . BASE_URL . "/categories/index.php");
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
                Add New Category
                <a href="<?php echo BASE_URL ?>/categories/index.php" class="btn btn-primary btn-sm right"><i class="fas fa-eye"></i> Show All</a>
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

                    <div class="col-md-12 mb-3">
                        <button type="submit" name="category_add_form_submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<?php include '../footer.php'; ?>
<?php include '../header.php'; ?>
<?php include '../top.php'; ?>

<?php

    if(isset($_POST['product_add_form_submit'])) {
        $brand_id = trim($_POST['brand_id']);
        $category_id = trim($_POST['category_id']);
        $sku = trim($_POST['sku']);
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $buying_price = trim($_POST['buying_price']);
        $selling_price = trim($_POST['selling_price']);
        $quantity = trim($_POST['quantity']);
        $alert_quantity = trim($_POST['alert_quantity']);
        $status = $_POST['status'];

        try {

            if(empty($brand_id)) {
                throw new Exception("Brand is required");
            }

            if(empty($category_id)) {
                throw new Exception("Category is required");
            }

            if(empty($sku)) {
                throw new Exception("SKU is required");
            }

            if(empty($name)) {
                throw new Exception("Name is required");
            }

            if(empty($buying_price)) {
                throw new Exception("Buying price is required");
            }

            if(empty($selling_price)) {
                throw new Exception("Selling price is required");
            }

            if(empty($quantity)) {
                throw new Exception("Quantity is required");
            }

            if(empty($alert_quantity)) {
                throw new Exception("Alert quantity is required");
            }

            // check if product name already exists
            $sql = "SELECT * FROM products WHERE name = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name]);
            if($stmt->rowCount() > 0) {
                throw new Exception("Product name already exists");
            }

            $sql = "INSERT INTO products (brand_id, category_id, sku, name, description, buying_price, selling_price, qty, alert_qty, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$brand_id, $category_id, $sku, $name, $description, $buying_price, $selling_price, $quantity, $alert_quantity, $status]);

            $_SESSION['success'] = "Product added successfully!";
            header("Location: " . BASE_URL . "/products/index.php");
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
                Add New Product
                <a href="<?php echo BASE_URL ?>/products/index.php" class="btn btn-primary btn-sm right"><i class="fas fa-eye"></i> Show All</a>
            </h1>

            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Select Brand<span class="text-danger">*</span></label>
                        <select name="brand_id" class="form-control select2">
                            <option value="">Select Brand</option>
                            <?php
                                $sql = "SELECT * FROM brands WHERE status = 'Active'";
                                $stmt = $pdo->query($sql);
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Select Category<span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control select2">
                            <option value="">Select Category</option>
                            <?php
                                $sql = "SELECT * FROM categories WHERE status = 'Active'";
                                $stmt = $pdo->query($sql);
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">SKU</label>
                        <input type="text" name="sku" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Description</label>
                        <textarea name="description" class="form-control" cols="30" rows="6"></textarea>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Buying Price</label>
                        <input type="number" name="buying_price" class="form-control" step="1">
                    </div>  

                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Selling Price</label>
                        <input type="number" name="selling_price" class="form-control" step="1">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control" step="1">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Alert Quantity</label>
                        <input type="number" name="alert_quantity" class="form-control" step="1">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Status</label>
                        <select name="status" class="form-control select2">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <button type="submit" name="product_add_form_submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<?php include '../footer.php'; ?>
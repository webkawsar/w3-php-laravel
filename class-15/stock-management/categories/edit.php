<?php include '../header.php'; ?>
<?php include '../top.php'; ?>

<?php

    try {
        
        $id = $_GET['id'];
        if(!isset($id)) {
            $_SESSION['error'] = "Invalid request";
            header("Location: " . BASE_URL . "/categories/index.php");
            exit();
        }

        // fetch category data
        $sql = "SELECT * FROM categories WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$category) {
            throw new Exception("Category not found");
        }

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: " . BASE_URL . "/categories/index.php");
        exit();
    }

    // edit form submission
    if(isset($_POST['category_edit_form_submit'])) {
        try {
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $status = $_POST['status'];
            
            if(empty($name)) {
                throw new Exception("Name is required");
            }

            // check if category name already exists
            $sql = "SELECT * FROM categories WHERE name = ? AND id != ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $id]);
            if($stmt->rowCount() > 0) {
                throw new Exception("Category name already exists");
            }

            // update category
            $sql = "UPDATE categories SET name = ?, description = ?, status = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $description, $status, $id]);

            $_SESSION['success'] = "Category edited successfully!";
            header("Location: " . BASE_URL . "/categories/index.php");
            exit();

        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header("Location: " . BASE_URL . "/categories/edit.php?id=" . $id);
            exit();
        }
    }

?>

<div class="right-part container-fluid">
    <div class="row">
        <?php include '../sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4 pb-3">

            <h1 class="page-heading">
                Edit Category
                <a href="<?php echo BASE_URL ?>/categories/index.php" class="btn btn-primary btn-sm right"><i class="fas fa-eye"></i> Show All</a>
            </h1>

            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="<?php echo $category['name'] ?>">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Description</label>
                        <textarea name="description" class="form-control" cols="30" rows="10"><?php echo $category['description'] ?></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Status</label>
                        <select name="status" class="form-control select2">
                            <option value="Active" <?php echo $category['status'] === 'Active' ? 'selected' : '' ?>>Active</option>
                            <option value="Inactive" <?php echo $category['status'] === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <button type="submit" name="category_edit_form_submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<?php include '../footer.php'; ?>
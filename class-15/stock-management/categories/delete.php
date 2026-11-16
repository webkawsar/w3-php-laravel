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

        // check if category exists
        $sql = "SELECT * FROM categories WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$category) {
            throw new Exception("Category not found");
        }

        // delete category
        $sql = "DELETE FROM categories WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $_SESSION['success'] = "Category deleted successfully!";
        header("Location: " . BASE_URL . "/categories/index.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: " . BASE_URL . "/categories/index.php");
        exit();
    }

?>

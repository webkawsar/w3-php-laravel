<?php include '../header.php'; ?>
<?php include '../top.php'; ?>

<?php

    try {

        $id = $_GET['id'];
        if(!isset($id)) {
            $_SESSION['error'] = "Invalid request";
            header("Location: " . BASE_URL . "/brands/index.php");
            exit();
        }

        $sql = "SELECT * FROM brands WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $brand = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$brand) {
            throw new Exception("Brand not found");
        }

        // if this brand is used in any product, we cannot delete it
        $sql = "SELECT * FROM products WHERE brand_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($products)) {
            throw new Exception("Cannot delete brand. It is associated with existing products.");
        }

        // delete brand
        $sql = "DELETE FROM brands WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $_SESSION['success'] = "Brand deleted successfully!";
        header("Location: " . BASE_URL . "/brands/index.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: " . BASE_URL . "/brands/index.php");
        exit();
    }

?>


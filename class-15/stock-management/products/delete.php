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


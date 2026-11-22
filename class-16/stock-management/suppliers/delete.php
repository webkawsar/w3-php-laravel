<?php include '../header.php'; ?>
<?php include '../top.php'; ?>

<?php

    try {

        $id = $_GET['id'];
        if(!isset($id)) {
            $_SESSION['error'] = "Invalid request";
            header("Location: " . BASE_URL . "/suppliers/index.php");
            exit();
        }

        $sql = "SELECT * FROM suppliers WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $supplier = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$supplier) {
            throw new Exception("Supplier not found");
        }

        // delete supplier
        $sql = "DELETE FROM suppliers WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $_SESSION['success'] = "Supplier deleted successfully!";
        header("Location: " . BASE_URL . "/suppliers/index.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: " . BASE_URL . "/suppliers/index.php");
        exit();
    }

?>


<?php include '../header.php'; ?>
<?php include '../top.php'; ?>

<?php

    try {

        $id = $_GET['id'];
        if(!isset($id)) {
            $_SESSION['error'] = "Invalid request";
            header("Location: " . BASE_URL . "/customers/index.php");
            exit();
        }

        $sql = "SELECT * FROM customers WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$customer) {
            throw new Exception("Customer not found");
        }

        // delete customer
        $sql = "DELETE FROM customers WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $_SESSION['success'] = "Customer deleted successfully!";
        header("Location: " . BASE_URL . "/customers/index.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: " . BASE_URL . "/customers/index.php");
        exit();
    }

?>


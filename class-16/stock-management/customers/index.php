<?php include '../header.php'; ?>
<?php include '../top.php'; ?>

<?php

    try {
        $sql = "SELECT * FROM customers";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

?>

<div class="right-part container-fluid">
    <div class="row">
        <?php include '../sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4 pb-3">

            <h1 class="page-heading">
                All Customers
                <a href="<?php echo BASE_URL ?>/customers/add.php" class="btn btn-primary btn-sm right"><i class="fas fa-plus"></i> Add New</a>
            </h1>

            <div class="table-responsive">
                <table id="datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Address</th>
                            <th scope="col">Due Balance</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($customers as $key => $customer): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $customer['name']; ?></td>
                                <td><?php echo $customer['phone']; ?></td>
                                <td><?php echo $customer['address']; ?></td>
                                <td><?php echo $customer['due_balance']; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $customer['status'] == 'Active' ? 'success' : 'danger'; ?>">
                                        <?php echo $customer['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL ?>/customers/edit.php?id=<?php echo $supplier['id']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                    
                                    <a href="<?php echo BASE_URL ?>/customers/delete.php?id=<?php echo $supplier['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>

<?php include '../footer.php'; ?>
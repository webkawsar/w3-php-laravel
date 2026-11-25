<?php include '../header.php'; ?>
<?php include '../top.php'; ?>

<?php

    try {
        $sql = "SELECT 
        p.*,
        b.name as brand_name,
        c.name as category_name
        FROM products as p
        JOIN brands as b 
        ON p.brand_id = b.id
        JOIN categories as c 
        ON p.category_id = c.id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

?>

<div class="right-part container-fluid">
    <div class="row">
        <?php include '../sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4 pb-3">

            <h1 class="page-heading">
                All Purchases
                <a href="<?php echo BASE_URL ?>/products/add.php" class="btn btn-primary btn-sm right"><i class="fas fa-plus"></i> Add New Product</a>
            </h1>

            <div class="table-responsive">
                <table id="datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Category</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Buying Price</th>
                            <th scope="col">Selling Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $key => $product): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $product['sku']; ?></td>
                                <td><?php echo $product['brand_name']; ?></td>
                                <td><?php echo $product['category_name']; ?></td>
                                <td><?php echo $product['name']; ?></td>
                                <td><?php echo $product['description']; ?></td>
                                <td><?php echo $product['buying_price']; ?></td>
                                <td><?php echo $product['selling_price']; ?></td>
                                <td><?php echo $product['qty']; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $product['status'] == 'Active' ? 'success' : 'danger'; ?>">
                                        <?php echo $product['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL ?>/products/edit.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                    
                                    <a href="<?php echo BASE_URL ?>/products/delete.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');"><i class="fas fa-trash"></i> Delete</a>
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
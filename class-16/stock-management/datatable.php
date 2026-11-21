<?php include 'header.php'; ?>

<?php include 'top.php'; ?>

<div class="right-part container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4 pb-3">

            <h1 class="page-heading">
                Datatable
                <a href="form.php" class="btn btn-primary btn-sm right"><i class="fas fa-plus"></i> Add New</a>
            </h1>

            <div class="table-responsive">
                <table id="datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Property Name</th>
                            <th scope="col">Property Price</th>
                            <th scope="col">Location</th>
                            <th scope="col">Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>207 AB Villa</td>
                            <td>$10,000</td>
                            <td>NewYork</td>
                            <td>Villa</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>207 AB Villa</td>
                            <td>$10,000</td>
                            <td>NewYork</td>
                            <td>Villa</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>207 AB Villa</td>
                            <td>$10,000</td>
                            <td>NewYork</td>
                            <td>Villa</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>207 AB Villa</td>
                            <td>$10,000</td>
                            <td>NewYork</td>
                            <td>Villa</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>

<?php include 'footer.php'; ?>
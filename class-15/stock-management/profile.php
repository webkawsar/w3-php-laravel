<?php include 'header.php'; ?>

<?php include 'top.php'; ?>

<div class="right-part container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4 pb-3">

            <h1 class="page-heading">Edit Profile</h1>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <img src="images/admin.jpg" class="img-thumbnail mb_10" alt="">
                        <input type="file" name="photo" class="form-control">
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">First Name</label>
                                <input type="text" class="form-control" name="firstname" value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="lastname" value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Phone</label>
                                <input type="text" class="form-control" name="phone" value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Retype Password</label>
                                <input type="password" class="form-control" name="retype_password">
                            </div>
                            <div class="col-md-12 mb-3">
                                <input type="submit" value="Update" name="form1" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </main>
    </div>
</div>

<?php include 'footer.php'; ?>
<?php include 'header.php'; ?>

<?php include 'top.php'; ?>

<div class="right-part container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4 pb-3">

            <h1 class="page-heading">Form with Tab</h1>

            <div class="row form-tab">
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5">
                    <div class="nav nav-pills flex-column me-3" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">

                        <button class="nav-link active" id="v-pills-1-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-1" type="button" role="tab" aria-controls="v-pills-1"
                            aria-selected="true">
                            Banner Section
                        </button>

                        <button class="nav-link" id="v-pills-2-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-2" type="button" role="tab" aria-controls="v-pills-2"
                            aria-selected="false">
                            Testimonial Section
                        </button>

                        <button class="nav-link" id="v-pills-3-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-3" type="button" role="tab" aria-controls="v-pills-3"
                            aria-selected="false">
                            Blog Section
                        </button>

                        <button class="nav-link" id="v-pills-4-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-4" type="button" role="tab" aria-controls="v-pills-4"
                            aria-selected="false">
                            Counter Section
                        </button>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 col-md-8 col-sm-7">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel"
                            aria-labelledby="v-pills-1-tab" tabindex="0">
                            <!-- Banner Content -->
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Heading</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Title</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Active?</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" checked>
                                </div>
                            </div>
                            <!-- // Banner Content -->
                        </div>

                        <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-2-tab"
                            tabindex="0">
                            <!-- Testimonial Content -->
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Heading</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Title</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Active?</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" checked>
                                </div>
                            </div>
                            <!-- // Testimonial Content -->
                        </div>

                        <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-3-tab"
                            tabindex="0">
                            <!-- Blog Content -->
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Heading</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Title</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Active?</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" checked>
                                </div>
                            </div>
                            <!-- // Blog Content -->
                        </div>

                        <div class="tab-pane fade" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-4-tab"
                            tabindex="0">
                            <!-- Counter Content -->
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Heading</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Title</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Active?</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" checked>
                                </div>
                            </div>
                            <!-- // Counter Content -->
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>

            </div>

        </main>
    </div>
</div>

<?php include 'footer.php'; ?>
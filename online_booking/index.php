<?php
include 'init.php';
$pageTitle = "Club House Booking| Dashboard";
include('inc/header.php');
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page or any other desired page
    header('Location: login.php');
    exit();
}


include('inc/nav.php');

?>


<!-- DAtatable -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">


<div class="container px-3 pt-4 mb-5 pb-5">
    <h1>Dashboard</h1>
    <hr>
    <?php if ($_SESSION['user_type'] == 'user'): ?>
        <!-- <section class="mb-3">
        <h3 class="lead fw-600 text-bold">Reserved Room</h3>
        <div class="card py-3 p-2" id="bg-card">
            <div class="card-title">You have no booking yet</div>
        </div>
    </section> -->

        <!-- available rooms and menu -->

        <div class="row row-cols-1 row-cols-md-3 g-4 mb-3 pb-3">
            <div class="col-md-4 col-sm-12">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title" style="font-size:58px;">
                                    <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                </h5>
                            </div>
                            <div class="col">
                                <p class="card-text display-5 ">
                                    <?php
                                    $totalRequestsCount = $request->countAllRequestsByRequesterId($requesterId);

                                    ?>

                                    <?= $totalRequestsCount; ?>
                                </p>
                                <span>Total Request</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title" style="font-size:58px;">
                                    <i class="fa fa-tasks" aria-hidden="true"></i>
                                </h5>
                            </div>
                            <div class="col">
                                <p class="card-text display-5">
                                    <?php

                                    $pendingRequestsCount = $request->countPendingRequestsByRequesterId($requesterId);

                                    ?>
                                    <?= $pendingRequestsCount; ?>
                                </p>
                                <span>Pending Request</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title" style="font-size:58px;">
                                    <i class="fa fa-recycle" aria-hidden="true"></i>
                                </h5>
                            </div>
                            <div class="col">
                                <p class="card-text display-5">
                                    <?php
                                    $rejectedRequestsCount = $request->countRejectedRequestsByRequesterId($requesterId);

                                    ?>

                                    <?= $rejectedRequestsCount; ?>
                                </p>
                                <span>Rejected Request</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ===============================Menu=================================================== -->
        <div class="col  mb-2 pb-2 bg-light">
            <section class="pt-1 mt-1 pb-2 mb-2">
                <div class="menus-titles pt-2 mt-2 text-center pb-5">
                    <h3 class="lead fw-600 text-bold" id="menu-title">Our Menu</h3>
                    <p class="lead">Have a View from Our Menu</p>
                </div>


                <div class="menus container">
                    <div class="menu-column">
                        <h4>Breakfast</h4>

                        <?php
                        $breakfasts = $menu->generateBreakfastMenuOptions();
                        if ($breakfasts) {
                            foreach ($breakfasts as $breakfast) {
                                ?>
                                <div class="single-menu card p-4 bg-dark text-white">
                                    <img src="<?= $breakfast['image'] ?>" alt="">
                                    <div class="menu-content">
                                        <h5 style="font-size:15px">
                                            <?= $breakfast['name']; ?><span>GH₵
                                                <?= $breakfast['price']; ?>
                                            </span>
                                        </h5>
                                        <p>
                                            <?= $breakfast['description']; ?>
                                        </p>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            // Handle the case when no breakfast menu options are available
                        }
                        ?>
                    </div>


                    <div class="menu-column">
                        <h4>Lunch</h4>
                        <?php
                        $lunches = $menu->fetchLunchOptions();
                        if ($lunches) {
                            foreach ($lunches as $lunch) {
                                ?>
                                <div class="single-menu card p-4 bg-dark text-white">
                                    <img src="<?= $lunch['image'] ?>" alt="">
                                    <div class="menu-content">
                                        <h5 style="font-size: 15px;">
                                            <?= $lunch['name']; ?><span>GH₵
                                                <?= $lunch['price']; ?>
                                            </span>
                                        </h5>
                                        <p>
                                            <?= $lunch['description']; ?>
                                        </p>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            // Handle the case when no lunch menu options are available
                        }
                        ?>
                    </div>

                    <div class="menu-column">
                        <h4>Dinner</h4>
                        <?php
                        $dinners = $menu->fetchDinnerOptions();
                        if ($dinners) {
                            foreach ($dinners as $dinner) {
                                ?>
                                <div class="single-menu card p-4 bg-dark text-white">
                                    <img src="<?= $dinner['image'] ?>" alt="">
                                    <div class="menu-content">
                                        <h5 style="font-size: 15px;">
                                            <?= $dinner['name']; ?><span> GH₵
                                                <?= $dinner['price']; ?>
                                            </span>
                                        </h5>
                                        <p>
                                            <?= $dinner['description']; ?>
                                        </p>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            // Handle the case when no dinner menu options are available
                        }
                        ?>
                    </div>

            </section>
        <?php else: ?>
            <section class="admin">
                <?php include('admin_page.php') ?>
            </section>
        <?php endif; ?>



    </div>






</div>
</div>


<!-- datatable -->
<script defer src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script defer src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script defer src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script defer src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

<?php include('inc/footer.php'); ?>
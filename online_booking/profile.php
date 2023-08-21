<?php
include 'init.php';
$pageTitle ="User |Profile";
include('inc/header.php');

include('inc/nav.php');
?>


<div class="container px-3 pt-4">
    <h1>Profile Settings</h1>
    <hr>

    <section class="h-100 gradient-custom-2">
        <div class="container py-3 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7">
                    <div class="card">
                        <div class="rounded-top text-white d-flex flex-row"
                            style="background-color: #000; height:200px;">
                            <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                                <img src="<?php echo $_SESSION['user_details']['profile_image']; ?>"
                                    alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2"
                                    style="width: 150px; z-index: 1">
                                    <a href="edit_profile.php" class=" btn btn-outline-dark text-decoration-none"  style="z-index: 1;">Edit profile</a>
                                    
                            </div>
                            <div class="ms-3" style="margin-top: 130px;">
                                <h5>
                                    <?php echo $_SESSION['user_details']['name']; ?>
                                </h5>

                            </div>
                        </div>
                        <div class="p-4 text-black" style="background-color: #f8f9fa;">
                            <div class="d-flex justify-content-end text-center py-1">
                                <div class="mx-3">
                                    <p class="mb-1 h5">3</p>
                                    <p class="small text-muted mb-0">Request</p>
                                </div>
                                <div class="mx-3">
                                    <p class="mb-1 h5 ">Type</p>
                                    <p class="small text-muted mb-0">
                                        <?php echo $_SESSION['user_details']['user_type']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4 text-black">
                            <div class="mb-5">
                                <p class="lead fw-normal mb-1">About</p>
                                <div class="p-4" style="background-color: #f8f9fa;">
                                    <p class="font-italic mb-1"><i class="fa fa-envelope" aria-hidden="true"></i> Email:
                                        <span>
                                            <?php echo $_SESSION['user_details']['email']; ?>
                                        </span>
                                    </p>
                                    
                                        <p class="font-italic mb-1"><i class="fa fa-phone-square" aria-hidden="true"></i>
                                            Tel:
                                            <?php if (isset($_SESSION['user_details']['tel'])): ?>
                                            <?php echo $_SESSION['user_details']['tel']; ?>
                                            <?php endif; ?>
                                        </p>
                                    
                                    <!-- get user by department code  -->
                                    <?php
                                    $user = new User($database);
                                    $department = $user->getDepartmentById($_SESSION['user_details']['department_id']);
                                    ?>
                                    <p class="font-italic mb-0"><i class="fa fa-users" aria-hidden="true"></i>
                                        Department:
                                        <?php echo $department['name']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



</div>


</div>

<?php include('inc/footer.php'); ?>
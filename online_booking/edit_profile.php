<?php
include 'init.php';
$pageTitle ="Update| Profile";
include('inc/header.php');

include('inc/nav.php');
?>



<div class="container px-3 pt-1">
                <h1>Edit Profile </h1>
                <hr>


                <div class="container rounded bg-white mt-5 mb-5">
                    <div class="row">
                        <div class="col-md-3 border-right">
                            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img
                                    class="rounded mt-5" width="150px"
                                    src="<?php echo $_SESSION['user_details']['profile_image']; ?>"><span
                                    class="font-weight-bold text-capitalize"> <?php echo $_SESSION['user_details']['name']; ?></span><span
                                    class="text-black-50"> <?php echo $_SESSION['user_details']['email']; ?>
                                </span><span> </span></div>
                        </div>
                        <div class="col-md-5 border-right">
                            <div class="p-3 py-1">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="text-right">Profile Settings</h4>
                                                                                </div>
                                      <form method="post" action="user_action.php" enctype="multipart/form-data">
                                      <input type="hidden" name="id" value="<?php echo $_SESSION['user_details']['id']; ?>" />
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="labels">Name</label>
                                            <input type="text" class="form-control" value="<?php echo $_SESSION['user_details']['name']; ?>" name="username" >
                                        </div>
                                        <div class="col-md-6">
                                            <label class="labels">Email</label>
                                            <input type="email" class="form-control" value="<?php echo $_SESSION['user_details']['email']; ?>" name="email">
                                        </div>
                                    </div>
                        
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <label class="labels">Mobile Number</label>
                                            <input type="phone" class="form-control" name="tel"
                                            value="<?php echo $_SESSION['user_details']['tel']; ?>" ></div>
                                        <div class="col-md-12">
                                            <label class="labels">Section/Department</label>
                                            <input type="text"class="form-control" name="enter"  value="<?php echo $_SESSION['user_details']['department_name']; ?>" disabled>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="labels">Photo</label>
                                            <input type="file" class="form-control" name="picture" value="<?php echo $_SESSION['user_details']['profile_image']; ?>">
                                        </div>
                                       
                                    </div>
                                    <div class="mt-5 text-center d-grid gap-2">
                                        <button type="submit" class="btn btn-primary"  name="update_profile">Submit</button>
                                      </div>
                                 </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

<?php include('inc/footer.php'); ?>





              
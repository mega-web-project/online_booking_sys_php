<?php
include 'init.php';
$pageTitle = "User |Request";
include('inc/header.php');

include('inc/nav.php');



// Call the method to generate breakfast menu options and store them in the session variable
$request->fetchLunchOptions();
$request->fetchDinnerOptions();

$requestId = isset($_GET['id']) ? intval($_GET['id']) : null;

$request->getRequestById($requestId);

?>
<!-- Multi selection -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">



<div class="container px-3 pt-4">
    <h1 class="request-title text-bold text-capitalize">Make An Order</h1>
    <hr>

    <div class="request-form card p-4 mx-auto shadow-1">
        <form action="edit.request.php" method="POST">

        <input type="hidden" name="id" value="<?=$_SESSION['request_id']?>">
            <div class="row mb-4">

                <div class="col">
                    <div class="form-outline ">
                        <label class="form-label text-capitalize" for="form6Example2">

                        </label>
                        <input type="text" id="form6Example2" class="form-control shadow-none" placeholder="Fullname"
                            name="guest_name" value="<?= $_SESSION['guest_name'] ?>" />

                    </div>
                </div>
            </div>

            <!-- Text input -->
            <div class="form-outline mb-4">
                <label class="form-label text-capitalize" for="form6Example3">Address of the guest</label>
                <input type="text" id="form6Example3" class="form-control shadow-none" placeholder="Guest Address.."
                    name="guest_address" value="<?= $_SESSION['guest_address'] ?>" />

            </div>

            <!-- Text input -->
            <div class="row mb-4">
                <div class="col mb-1">
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1" text-capitalize>Expected Date And Time of
                            Arrival</label>

                        <input type="datetime-local" id="form6Example2" class="form-control shadow-none" placeholder=""
                            name="check_in_date" value="<?= $_SESSION['check_in_date'] ?>" required />

                    </div>
                </div>
                <div class="col">
                    <div class="form-outline ">
                        <label class="form-label text-capitalize" for="form6Example2 ">Expected Date And Time of
                            Departure</label>
                        <input type="datetime-local" id="form6Example2" class="form-control shadow-none" placeholder=""
                            name="check_out_date" value="<?= $_SESSION['check_out_date'] ?>" required />

                    </div>
                </div>
            </div>

            <!-- Message input -->
            <div class="form-outline mb-4">
                <label class="form-label text-capitalize" for="form6Example7">Purpose of Visit <span class="text-danger">*</span></label>
                <textarea class="form-control shadow-none" name="purpose_of_visit" id="form6Example7" rows="4"
                    required><?php echo isset($_SESSION['purpose_of_visit']) ? $_SESSION['purpose_of_visit'] : ''; ?></textarea>
            </div>




            <!-- Text input -->
            <h4 class="text-capitalize">Meals/Accommodation</h4>
            <div class="row mb-4">
                <!-- BREAK FAST -->
                <div class="col">
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">Breakfast <span class="text-danger">*</span></label>
                        
                        <select class="form-select shadow-none" aria-label="multiple select example" name="breakfast" required>
                        <option value="">Select from Break fast</option>
                            <?php
                            // Fetch the breakfast menu options from the generateBreakfastMenuOptions method
                            $breakfasts = $request->generateBreakfastMenuOptions();

                            foreach ($breakfasts as $menuName) {
                                if ($menuName === "Select from Breakfast") {
                                    continue; // Skip the "Select from Breakfast" option
                                }

                                // Check if the current menu option matches the selected option
                                $selectedAttribute = ($menuName === $selectedBreakfast) ? 'selected' : '';

                                echo '<option value="' . $menuName . '" ' . $selectedAttribute . '>' . $menuName . '</option>';
                            }
                            ?>
                        </select>



                    </div>
                </div>
                <div class="col">
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">Dinner <span class="text-danger">*</span></label>

                        <select class="form-select shadow-none" aria-label="multiple select example" name="dinner" required>
                            <option value="">Select from dinner</option>
                            <?php
                            // Fetch the breakfast menu options from the generateBreakfastMenuOptions method
                            $breakfasts = $request->fetchDinnerOptions();

                            foreach ($breakfasts as $menuName) {
                                if ($menuName === "Select from Breakfast") {
                                    continue; // Skip the "Select from Breakfast" option
                                }
                                echo '<option value="' . $menuName . '">' . $menuName . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>

            </div>

            <div class="row mb-4">
                <!-- LAUNCH -->
                <div class="col">
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">Lunch <span class="text-danger">*</span></label>

                        <select class="form-select shadow-none" aria-label="multiple select example" name="lunch">
                            <option value="">Select from lunch</option>
                            <?php
                            // Fetch the breakfast menu options from the generateBreakfastMenuOptions method
                            $breakfasts = $request->fetchLunchOptions();

                            foreach ($breakfasts as $menuName) {
                                if ($menuName === "Select from Breakfast") {
                                    continue; // Skip the "Select from Breakfast" option
                                }
                                echo '<option value="' . $menuName . '">' . $menuName . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-outline ">
                        <label class="form-label" for="form6Example2">Person(s)</label>
                        <input type="number" id="form6Example2" class="form-control shadow-none"
                            placeholder="number of person" name="num_of_people_for_menu"
                            value="<?= $_SESSION['num_of_people_for_menu'] ?>" required />

                    </div>
                </div>

            </div>

            <div class="row mb-4">
                <!-- Dinner -->
                <div class="col">
                    <div class="form-outline ">
                        <label class="form-label" for="form6Example2">Accomodation (number)</label>
                        <input type="number" id="form6Example2" class="form-control shadow-none"
                            placeholder="number of person" name="num_of_people_for_acco"
                            value="<?php echo $_SESSION['num_of_people_for_acco']; ?>" required />

                    </div>
                </div>


            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="form6Example3">Select Employees Name (if employee)</label>
                <select name="employeeNames[]"  id="people" class="form-select" multiple>
                    <?php
                    // Fetch the list of employees from the database
                    $employees = $request->getEmployees();

                    // Generate the option elements
                    foreach ($employees as $employee) {
                        echo '<option value="' . $employee['emp_name'] . '">' . $employee['emp_name'] . '</option>';
                    }
                    ?>
                </select>
            </div>


            <div class="form-outline mb-4">
                <label class="form-label" for="form6Example7">Enter Visitors (peoples) Names</label>
                <textarea class="form-control shadow-none text-capitalize" name="visitors_names" id="form6Example7" rows="4"
                   ><?php echo isset($_SESSION['visitors_names']) ? $_SESSION['visitors_names'] : ''; ?></textarea>
            </div>



            <!-- Submit button -->

            <input type="submit" value="Update Request" class="btn btn-info block-button mb-4 btn-lg text-white"
                name="save">


        </form>
    </div>

</div>
</div>




<!-- Multi selecton -->
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
<script>
    new MultiSelectTag('people')  // id
</script>
<?php include('inc/footer.php'); ?>
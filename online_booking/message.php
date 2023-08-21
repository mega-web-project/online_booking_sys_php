<?php
include 'init.php';
$pageTitle = "Message |Page";
include('inc/header.php');

include('inc/nav.php');

$requesterId = $_SESSION['user_id'];
$numRejectedRequests = $request->countRejectedRequests($requesterId);
?>

<div class="container px-3 pt-4">
  <h1 class="msg-title">Messages</h1>
  <hr>

  <section style="background-color: #f7f6f6;">
    <div class="container my-3 py-2 text-dark">
      <div class="row d-flex justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <?php if ($_SESSION['user_type'] == 'user'): ?>

              You have (
              <?= $numRejectedRequests ?>) rejected request(s)

            <?php else: ?>

              <?php
              $numPendingRequests = $request->countAllPendingRequests();
              ?>
              You have (
              <?= $numPendingRequests ?>) Pending Request to approve
            <?php endif; ?>

            <div class="card">
              <div class="card-body p-2 d-flex align-items-center">
                <h6 class="text-primary fw-bold small mb-0 me-1">Request Control </h6>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked />
                  <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                </div>
              </div>
            </div>
          </div>
          <div id="myPost">
            <?php
            $rejects = $request->getRejectedRequest($requesterId);
            if ($rejects) {

              foreach ($rejects as $reject) {
                ?>
                <div class="card mb-3">
                  <div class="card-body">
                    <div class="d-flex flex-start">
                      <img src="<?= $reject['requester_image'] ?>" alt="avatar" width="40" height="40"
                        class="rounded-circle shadow-1-strong me-3" />
                      <div class="w-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                          <h6 class="text-primary fw-bold mb-0">
                            <?= $reject['requester_name'] ?>
                            <span class="text-dark ms-2">
                              <?= $reject['requester_department'] ?>
                            </span>
                          </h6>
                          <div class="text-msg">
                          </div>
                          <p class="mb-0">
                          <?= $reject['elapsed_time'];?><br>
                            Request ID:
                            <?= $reject['uniqid'] ?>
                          </p>
                        </div>
                        <div class="msg-body">
                          <span>
                            <?= $reject['rejection_message'] ?>
                          </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                          <p class="small mb-0" style="color: #aaa;">
                            <a href="#!" class="link-grey text-danger" style="text-decoration:none">Remove</a> •
                            <a href="post.php?id=<?= $reject['id'] ?>" class="link-grey"
                                style="text-decoration:none">View</a> •
                              <a class="text-dark badge bg-warning text-decoration-none">
                                <?= $reject['status'] ?>
                              </a>
                          </p>
                          <div class="d-flex flex-row">
                            <!-- <i class="far fa-check-circle" style="color: #aaa;"></i> -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
              }
            } else {
              // // Handle case when no rejected requests found
              // echo "No rejected requests found.";
            }
            ?>
            <!-- ==================== -->
            <?php
            $pendings = $request->getPendingRequests();
            if ($pendings) {

              foreach ($pendings as $pending) {
                ?>
                <?php if ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'approver'): ?>
                  <div class="card mb-3" data-item-id="1">
                    <div class="card-body">
                      <div class="d-flex flex-start">
                        <img src="<?= $pending['requester_image'] ?>" alt="avatar" width="40" height="40"
                          class="rounded-circle shadow-1-strong me-3" />
                        <div class="w-100">
                          <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-primary fw-bold mb-0">
                              <?= $pending['requester_name'] ?>
                              <span class="text-dark ms-2">
                                <?= $pending['requester_department'] ?>
                              </span>
                            </h6>
                            <div class="text-msg">
                            </div>
                            <p class="mb-0">
                            <?= $pending['elapsed_time'];?><br>
                              Request ID:
                              <?= $pending['uniqid'] ?>
                            </p>
                          </div>
                          <div class="msg-body">
                            <span>
                              <?= $pending['purpose_of_visit'] ?>
                            </span>
                          </div>
                          <div class="d-flex justify-content-between align-items-center">
                            <p class="small mb-0" style="color: #aaa;">
                              <a href="#!" class="link-grey text-danger" style="text-decoration:none"
                                onclick="softDelete(event)">Hide</a> •
                              <a href="post.php?id=<?= $pending['id'] ?>" class="link-grey"
                                style="text-decoration:none">View</a> •
                              <a class="text-dark badge bg-warning text-decoration-none">
                                <?= $pending['status'] ?>
                              </a>
                            </p>
                            <div class="d-flex flex-row">
                              <!-- <i class="far fa-check-circle" style="color: #aaa;"></i> -->
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
                <?php
              }
            } else {
              // Handle case when no rejected requests found
              // echo "No pending requests found.";
            }
            ?>
            <!-- =============== -->
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>

  function softDelete(event) {
    // Find the card element (parent of the clicked button)
    const card = event.target.closest('.card');

    // Get the item ID from the card's data attribute
    const itemId = card.dataset.itemId;

    // Check if the item has already been deleted
    if (localStorage.getItem(`deletedItem_${itemId}`)) {
      // If already deleted, hide the card from the user interface
      card.style.display = 'none';
    } else {
      // If not deleted, set the flag in local storage and then hide the card
      localStorage.setItem(`deletedItem_${itemId}`, true);
      card.style.display = 'none';
    }
  }


</script>

<?php include('inc/footer.php'); ?>
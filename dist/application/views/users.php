<?php
include 'header.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: dashboard.php');
    exit;
}
?>
<?php include 'sidebar.php'; ?>

<style>
  #show {
    width: 150px;
    height: 150px;
    border: solid 1px #744547;
    border-radius: 50%;
    object-fit: cover;
    margin: auto;
    display: block;
  }
</style>

<!-- [ Main Content ] start -->
<div class="pc-container">
  <div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <div class="page-header-title">
              <h5 class="mb-0">Home</h5>
            </div>
          </div>
          <div class="col-md-12">
            <ul class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
              <li class="breadcrumb-item"><a href="javascript: void(0)">Dashboard</a></li>

            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">
            <h5>Users table</h5>

            <button id="addNewBtn" class="btn btn-primary btn-shadow float-end">Add New User</button>
          </div>

          <div class="card-block table-border-style">
            <div class="table-responsive">
              <table class="table" id="userTable">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>                
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>

                <tbody>

                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal" tabindex="-1" role="dialog" id="userModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add New User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="userForm" enctype="multipart/form-data">

              <input type="hidden" name="update_id" id="update_id">

              <div class="row">
                <div class="col-sm-12">
                  <div class="alert alert-success d-none" role="alert">
                    Registered Successfully
                  </div>
                  <div class="alert alert-danger d-none" role="alert">
                    A simple danger alert—check it out!
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required minlength="3"
                      maxlength="50" pattern="[A-Za-z0-9._]+"
                      title="Only letters, numbers, dots (.) and underscores (_)">
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group mt-2">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required minlength="4"
                      maxlength="10" title="Between 4 and 10 characters">
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group mt-2">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                  </div>
                </div>
  

              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>

    <!-- [ Main Content ] end -->
  </div>
</div>
<!-- [ Main Content ] end -->
<?php include 'footer.php'; ?>
//
<script src="../js/users.js"></script>
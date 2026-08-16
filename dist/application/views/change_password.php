<?php
include 'header.php';
?>
<?php include 'sidebar.php'; ?>

<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="mb-0">Change Password</h5>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <ul class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0)">Change Password</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-xl-6 col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5>Update Your Password</h5>
                    </div>

                    <div class="card-body">
                        <form id="changePasswordForm">
                            <div class="alert alert-danger d-none" id="errorAlert" role="alert"></div>
                            <div class="alert alert-success d-none" id="successAlert" role="alert"></div>

                            <div class="form-group mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter your current password">
                            </div>

                            <div class="form-group mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter new password">
                            </div>

                            <div class="form-group mb-4">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm your new password">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-shadow" id="submitBtn">Change Password</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/change_password.js"></script>

<?php
include 'header.php';
include 'sidebar.php';
?>

<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="mb-0">Sensor Data Report</h5>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <ul class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Sensor Data Report</li>
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
                        <h5 class="mb-0">Filter Options</h5>
                    </div>

                    <div class="card-block table-border-style">

                        <div class="alert alert-success d-none" role="alert"></div>
                        <div class="alert alert-danger d-none" role="alert"></div>

                        <form id="statementForm">
                            <div class="row">

                                <div class="col-sm-4 mb-2">
                                    <select name="type" id="type" class="form-control">
                                        <option value="0">All</option>
                                        <option value="custom">Custom Date</option>
                                    </select>
                                </div>

                                <div class="col-sm-4 mb-2 d-none" id="dateFromWrapper">
                                    <input type="date" id="from" name="from" class="form-control">
                                </div>

                                <div class="col-sm-4 d-none " id="dateToWrapper">
                                    <input type="date" id="to" name="to" class="form-control">
                                </div>

                                <div class="d-flex justify-content-center m-2">
                                    <button id="addNewBtn" type="submit" class="btn btn-primary ">Show Result</button>
                                </div>
                            </div>
                        </form>



                        <div class="table-responsive" id="printArea" style="max-height:520px; overflow-y:auto;">
                            <table class="table" id="statementTable">
                                <thead></thead>
                                <tbody>
                                    <tr><td colspan="6" class="text-center text-muted py-4"><i class="ph ph-info text-primary me-1"></i>Select a filter and click Show Result to load data.</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-2">
                            <small id="reportInfo" class="text-muted"></small>
                        </div>

                        <button class="btn btn-info m-2" id="infoBtn"><i class="ph ph-file"></i> Export</button>
                    </div>
                </div>
            </div>
        </div>




        <!-- [ Main Content ] end -->
    </div>
</div>


<?php include "footer.php" ?>

<!-- User Statement JS -->
<script src="../js/sensor_report.js"></script>

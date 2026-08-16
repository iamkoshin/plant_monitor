<?php
include 'header.php';
include 'sidebar.php';
?>



<link rel="stylesheet" href="../css/dashboard.css" />

<body>

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

      <div id="alert-bar" class="alert alert-warning d-none d-flex align-items-center gap-2 mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span><strong>Warning:</strong> Soil moisture critically low! Auto-irrigation activated.</span>
      </div>

      <div class="ms-auto d-flex align-items-center gap-3">
        <span class="live-badge"><span class="live-dot"></span> LIVE</span>
        <span id="ts-text">Connecting...</span>
      </div>

      <!-- Sensor Cards -->
      <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
          <div class="sensor-card card-temp h-100">
            <div class="accent-bar"></div>
            <div class="icon-wrap"><i class="bi bi-thermometer-half"></i></div>
            <div class="card-label">Temperature</div>
            <div class="card-value" id="v-temp">--</div>
            <div class="card-unit">°C</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="sensor-card card-hum h-100">
            <div class="accent-bar"></div>
            <div class="icon-wrap"><i class="bi bi-droplet-half"></i></div>
            <div class="card-label">Humidity</div>
            <div class="card-value" id="v-hum">--</div>
            <div class="card-unit">%</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="sensor-card card-soil h-100">
            <div class="accent-bar"></div>
            <div class="icon-wrap"><i class="bi bi-flower1"></i></div>
            <div class="card-label">Soil Moisture</div>
            <div class="card-value" id="v-soil">--</div>
            <div class="card-unit">%</div>
            <div class="moisture-bar">
              <div class="moisture-fill" id="soil-bar" style="width:0%"></div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="sensor-card card-pump h-100">
            <div class="accent-bar"></div>
            <div class="icon-wrap"><i class="bi bi-gear-fill"></i></div>
            <div class="card-label">Water Pump</div>
            <div class="mt-2">
              <span id="pump-badge" class="badge rounded-pill pump-off fs-6 px-3 py-2">
                <i class="bi bi-power me-1"></i> OFF
              </span>
            </div>
            <div class="card-unit mt-2" id="pump-mode-lbl">Mode: Auto</div>
          </div>
        </div>
      </div>

      <!-- Pump Control -->
      <div class="data-card mb-4">
        <div class="section-title"><i class="bi bi-sliders me-1"></i> Pump Control</div>
        <div class="d-flex flex-wrap gap-2">
          <button class="btn btn-success px-4" onclick="setPump('on')">
            <i class="bi bi-play-fill me-1"></i> Turn ON
          </button>
          <button class="btn btn-danger px-4" onclick="setPump('off')">
            <i class="bi bi-stop-fill me-1"></i> Turn OFF
          </button>
          <button class="btn btn-primary px-4" id="btn-auto" onclick="setPump('auto')">
            <i class="bi bi-arrow-repeat me-1"></i> Auto Mode
          </button>
        </div>
        <div id="cmsg" class="mt-2 small text-success fw-semibold" style="min-height:18px"></div>
      </div>

      <!-- Chart + Table -->
      <div class="row g-3 mb-4">
        <div class="col-12 col-lg-7">
          <div class="data-card h-100">
            <div class="section-title"><i class="bi bi-graph-up me-1"></i> Sensor History – Last 20 Readings</div>
            <canvas id="chart" style="max-height:280px"></canvas>
          </div>
        </div>
        <div class="col-12 col-lg-5">
          <div class="data-card h-100">
            <div class="section-title"><i class="bi bi-table me-1"></i> Recent Readings</div>
            <div class="table-responsive scrollable-table">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>Time</th>
                    <th>°C</th>
                    <th>Hum%</th>
                    <th>Soil%</th>
                    <th>Pump</th>
                  </tr>
                </thead>
                <tbody id="tbody">
                  <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                      <div class="spinner-border spinner-border-sm text-success me-2" role="status"></div>
                      Loading data...
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- [ Main Content ] end -->
    </div>
  </div>




</body>

<script src="../js/dashboard.js"></script>

<?php include 'footer.php'; ?>
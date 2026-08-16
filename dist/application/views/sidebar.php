 <!-- [ Sidebar Menu ] start -->
 <nav class="pc-sidebar">
   <div class="navbar-wrapper">
     <div class="m-header">
       <a href="dashboard.php" class="b-brand text-primary">
         <!-- ========   Change your logo from here   ============ -->
         <img src="../../assets/images/GreenLife-hor.png" class="img-fluid" alt="logo" />
       </a>
     </div>
     <div class="navbar-content">
       <ul class="pc-navbar">
         <li class="pc-item pc-caption">
           <label data-i18n="Navigation">Navigation</label>
         </li>
         <li class="pc-item">
           <a href="dashboard.php" class="pc-link">
             <span class="pc-micon">
               <i class="ph ph-house-line"></i>
             </span>
             <span class="pc-mtext" data-i18n="Dashboard">Dashboard</span>
           </a>
         </li>

          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <li class="pc-item pc-caption">
            <label data-i18n="UI Components">Admin</label>
            <i class="ph ph-lock-key"></i>
          </li>
          <li class="pc-item">
            <a href="users.php" class="pc-link">
              <span class="pc-micon"><i class="ph ph-users"></i></span>
              <span class="pc-mtext">User Management</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="admin.php" class="pc-link">
              <span class="pc-micon"><i class="ph ph-user-gear"></i></span>
              <span class="pc-mtext">Admin Management</span>
            </a>
          </li>
          <?php endif; ?>


          <li class="pc-item pc-caption">
            <label data-i18n="pages">Reports</label>
            <i class="ph ph-chart-pie"></i>
          </li>
         <li class="pc-item">
           <a href="sensor_report.php" class="pc-link" >
             <span class="pc-micon"> <i class="ph ph-chart-bar"></i></span>
             <span class="pc-mtext">Sensor Reports</span>
           </a>
         </li>


          <li class="pc-item pc-caption">
            <label data-i18n="Other">Log Out</label>
            <i class="ph ph-power"></i>
          </li>

          <li class="pc-item">
            <a href="/plant_monitor/logout.php" class="pc-link">
              <span class="pc-micon"> <i class="ph ph-sign-out"></i></span>
              <span class="pc-mtext">Log Out</span>
            </a>
          </li>


       </ul>

     </div>
   </div>
 </nav>
 <!-- [ Sidebar Menu ] end -->
 <!-- [ Header Topbar ] start -->
 <header class="pc-header">
   <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
     <div class="me-auto pc-mob-drp">
       <ul class="list-unstyled">
         <li class="pc-h-item pc-sidebar-collapse">
           <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
             <i class="ph ph-list"></i>
           </a>
         </li>
         <li class="pc-h-item pc-sidebar-popup">
           <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
             <i class="ph ph-list"></i>
           </a>
         </li>
         <li class="dropdown pc-h-item">
           <a
             class="pc-head-link dropdown-toggle arrow-none m-0 trig-drp-search"
             data-bs-toggle="dropdown"
             href="#"
             role="button"
             aria-haspopup="false"
             aria-expanded="false">
             
           </a>
           <div class="dropdown-menu pc-h-dropdown drp-search">
             
           </div>
         </li>
       </ul>
     </div>
     <!-- [Mobile Media Block end] -->
     <div class="ms-auto">
       <ul class="list-unstyled">
         <li class="dropdown pc-h-item">
           
           <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
             
             
           </div>
         </li>
         <li class="dropdown pc-h-item header-user-profile">
           <a
             class="pc-head-link dropdown-toggle arrow-none me-0"
             data-bs-toggle="dropdown"
             href="#"
             role="button"
             aria-haspopup="false"
             data-bs-auto-close="outside"
             aria-expanded="false">
             <i class="ph ph-user-circle"></i>
           </a>
           <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown p-0 overflow-hidden">
             <div class="dropdown-header d-flex align-items-center justify-content-between bg-primary">
               <div class="d-flex my-2">
                 <div class="flex-shrink-0">
                   <img src="../../assets/images/user/avatar-2.png" alt="user-image" class="user-avatar wid-35" />
                 </div>
                 <div class="flex-grow-1 ms-3">
                    <h6 class="text-white mb-1"><?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?> 🖖</h6>
                    <span class="text-white text-opacity-75"><?php echo htmlspecialchars($_SESSION['email'] ?? 'user@company.io'); ?></span>
                 </div>
               </div>
             </div>
             <div class="dropdown-body">
               <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
                 
                 
                 <a href="change_password.php" class="dropdown-item">
                   <span>
                     <i class="ph ph-lock-key align-middle me-2"></i>
                     <span>Change Password</span>
                   </span>
                 </a>
                 <div class="d-grid my-2">
                   <a href="/plant_monitor/logout.php" class="btn btn-primary"> <i class="ph ph-sign-out align-middle me-2"></i>Logout </a>
                 </div>
               </div>
             </div>
           </div>
         </li>
       </ul>
     </div>
   </div>
 </header>
 <!-- [ Header ] end -->
<?php include 'dist/application/config/conn.php';
session_start();
if (!empty($_SESSION['username'])) {
  header('Location: dist/application/views/dashboard.php');
  exit;
}


?>
<!doctype html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>Login | Datta able Dashboard Template</title>
  <!-- [Meta] -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta
    name="description"
    content="Datta able is trending dashboard template made using Bootstrap 5 design framework. Datta able is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies." />
  <meta
    name="keywords"
    content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard" />
  <meta name="author" content="Codedthemes" />

  <!-- [Favicon] icon -->
  <link rel="icon" href="dist/assets/images/favicon.svg" type="image/x-icon" />
  <!-- [Font] Family -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <!-- [phosphor Icons] https://phosphoricons.com/ -->
  <link rel="stylesheet" href="dist/assets/fonts/phosphor/regular/style.css" />
  <!-- [Tabler Icons] https://tablericons.com -->
  <link rel="stylesheet" href="dist/assets/fonts/tabler-icons.min.css" />
  <!-- [Template CSS Files] -->
  <link rel="stylesheet" href="dist/assets/css/style.css" id="main-style-link" />
  <link rel="stylesheet" href="dist/assets/css/style-preset.css" />
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-14K1GBX9FG"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-14K1GBX9FG');
  </script>
  <!-- WiserNotify -->
  <script>
    !(function() {
      if (window.t4hto4) console.log('WiserNotify pixel installed multiple time in this page');
      else {
        window.t4hto4 = !0;
        var t = document,
          e = window,
          n = function() {
            var e = t.createElement('script');
            (e.type = 'text/javascript'),
            (e.async = !0),
            (e.src = 'https://pt.wisernotify.com/pixel.js?ti=1jclj6jkfc4hhry'),
            document.body.appendChild(e);
          };
        'complete' === t.readyState ? n() : window.attachEvent ? e.attachEvent('onload', n) : e.addEventListener('load', n, !1);
      }
    })();
  </script>
  <!-- Microsoft clarity -->
  <script type="text/javascript">
    (function(c, l, a, r, i, t, y) {
      c[a] =
        c[a] ||
        function() {
          (c[a].q = c[a].q || []).push(arguments);
        };
      t = l.createElement(r);
      t.async = 1;
      t.src = 'https://www.clarity.ms/tag/' + i;
      y = l.getElementsByTagName(r)[0];
      y.parentNode.insertBefore(t, y);
    })(window, document, 'clarity', 'script', 'gkn6wuhrtb');
  </script>

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] End -->

  <div class="auth-main">
    <div class="auth-wrapper v1">
      <div class="auth-form">
        <div class="position-relative">
          <div class="auth-bg">
            <span class="r"></span>
            <span class="r s"></span>
            <span class="r s"></span>
            <span class="r"></span>
          </div>
          <div class="card mb-0">
            <div class="card-body">
              <div class="text-center">
                <a href="#"><img src="dist/assets/images/GreenLifeLogo.png" alt="GreenLife logo" style="max-width:150px;height:auto;" /></a>
              </div>
              <h4 class="text-center f-w-500 mt-4 mb-3">Login</h4>
              <div id="loginError" class="alert alert-danger d-none" role="alert"></div>
              <div class="mb-3">
                <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Enter Username" />
              </div>
              <div class="mb-3">
                <input type="password" name="password" class="form-control" id="floatingInput1" placeholder="Password" />
              </div>
              <div class="d-flex mt-1 justify-content-between align-items-center">
                <div class="form-check">
                  <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" checked="" />
                  <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
                </div>
                
              </div>
              <div class="text-center mt-4">
                <button type="button" id="loginButton" class="btn btn-primary shadow px-sm-4">Login</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    const loginButton = document.getElementById('loginButton');
    const loginError = document.getElementById('loginError');

    loginButton.addEventListener('click', async () => {
      loginError.classList.add('d-none');
      loginError.textContent = '';

      const username = document.getElementById('floatingInput').value.trim();
      const password = document.getElementById('floatingInput1').value;

      if (!username || !password) {
        loginError.textContent = 'Please enter both username and password.';
        loginError.classList.remove('d-none');
        return;
      }

      loginButton.disabled = true;
      loginButton.textContent = 'Logging in...';

      try {
        const response = await fetch('dist/application/api/login.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams({
            username,
            password
          })
        });

        const result = await response.json();

        if (result.status === 'success') {
          Swal.fire({
            title: "Success!",
            text: "Logged in successfully.",
            icon: "success",
            timer: 1500,
            showConfirmButton: false
          }).then(() => {
            window.location.href = 'dist/application/views/dashboard.php';
          });
          return;
        }

        loginError.textContent = result.msg || 'Login failed. Please try again.';
        loginError.classList.remove('d-none');
      } catch (error) {
        loginError.textContent = 'Unable to connect to the login service.';
        loginError.classList.remove('d-none');
      } finally {
        loginButton.disabled = false;
        loginButton.textContent = 'Login';
      }
    });
  </script>
</body>
<!-- [Body] end -->

</html>
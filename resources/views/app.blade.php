<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>MyApps</title>
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <script type="text/javascript">
   window.laravel = {"csrfToken":"{{ csrf_token() }}"};
 </script>
 <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="hold-transition layout-top-nav">
  
  <div id="app">
    <div class="wrapper">
      <nav class="main-header navbar navbar-expand navbar-dark navbar-cyan">
        <div class="container">
          <a href="index3.html" class="navbar-brand">
            <span class="brand-text font-weight-light">MyApps</span>
          </a>

          <ul class="navbar-nav">
            <li class="nav-item">
            </li>
            <li class="nav-item d-none d-sm-inline-block">
              <router-link class="nav-link" :to="{ name: 'home' }">Dashboard</router-link>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
              <router-link class="nav-link" :to="{ name: 'poll' }">Poll</router-link>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
              <router-link class="nav-link" :to="{ name: 'service' }">Service</router-link>
            </li>

          </ul>

          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
              <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Hai, {{ session('username') }}</a>
              <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                <li><a href="{{ url('logout') }}" class="dropdown-item">Logout </a></li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>

      <div class="content-wrapper" style="padding-bottom: 10px;height: 100%">
        <transition>
          <router-view></router-view>
        </transition>
      </div>




      <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
          <strong>Copyright &copy; 2019 <a href="https://haritsyp.github.io">haritsyp.github.io</a></strong> All rights reserved.
        </div>

      </footer>
    </div>
  </div>

  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>

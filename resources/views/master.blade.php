<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
   Survey Offers
  </title>
  <!-- Favicon -->
  <link href="/img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />

  <style>
    [v-cloak] {display: none}
  </style>

</head>

<body class="">
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <a class="navbar-brand" href="/offers" style="margin-right: auto;margin-left: auto;margin-bottom: -16px">
        Survey Offers
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        @include("include.user")
      </ul>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="/offers">
                
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item">
          <a id="offers" class="nav-link" href="/offers"> <i class="ni ni-favourite-28 text-primary"></i> Offers
            </a>
          </li>
         @can("index",App\User::class) <li class="nav-item">
            <a id="users" class="nav-link " href="/users">
              <i class="ni ni-circle-08 text-blue"></i> Users 
            </a>
             <a id="groups" class="nav-link " href="/groups">
              <i class="ni ni-single-02 text-blue"></i> Groups 
            </a>
          </li> @endcan
        
        </ul>
        
      </div>
    </div>
  </nav>
  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="/">Dashboard</a>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          @include("include.user")
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          @yield('content')
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
     
    
      <!-- Footer -->
      <footer class="footer">
       
      </footer>
    </div>
  </div>

  <!--   Core   -->
  <script src="/js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Optional JS   -->
  <script src="/js/plugins/chart.js/dist/Chart.min.js"></script>
  <script src="/js/plugins/chart.js/dist/Chart.extension.js"></script>
  <!--   Argon JS   -->
  <script src="/js/argon-dashboard.min.js?v=1.1.0"></script>
  <script src="/js/axios.min.js"></script>
   <script src="/js/vue.js"></script>
  <script src="/js/url.js"></script>
  @yield('js')
</body>

</html>
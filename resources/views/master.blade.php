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
  <link rel="stylesheet" type="text/css" href="/css/select2.min.css">
  <link rel="stylesheet" type="text/css" href="/css/style.css">

  <style>
    [v-cloak] {display: none}
  </style>

   @yield("css")

  <script>
    function toggleFunction(id)
    {
      $(id).toggle();
    }
  </script>

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

          <li class="nav-item" style="margin-left: 16px;">
            <a class="nav-link" href="javascript:void(0)" onclick="toggleFunction('.offersItems')" style="font-size: 1rem;color: black">
                <i id="offersIcon" class="ni ni-bold-right text-primary"></i> Offers
            </a>
          </li>

                         <li class="nav-item offersItems" style="display: none;margin-left: 8px">
                          <a id="offers" class="nav-link" href="/offers">
                            <i class="ni ni-favourite-28 text-primary"></i> Offers
                            </a>
                          </li>

                          <li class="nav-item offersItems" style="display: none;margin-left:8px">
                          <a id="templates" class="nav-link " href="/templates">
                              <i class="ni ni-palette text-blue"></i> Templates
                            </a>
                          </li>


                           @can("index",App\User::class) 
                          <li class="nav-item offersItems" style="display: none;margin-left:8px">
                            <a id="categories" class="nav-link " href="/categories">
                              <i class="ni ni-books text-blue"></i> Categories 
                            </a>
                          </li>
                          @endcan

                           @can("index",App\User::class) 
                          <div class="dropdown-divider"></div>
                          @endcan

           @can("index",App\User::class) 
           <li class="nav-item" style="margin-left: 16px;">
            <a class="nav-link" href="javascript:void(0)" onclick="toggleFunction('.permissionItems')" style="font-size: 1rem;color: black">
                <i id="permissionIcon" class="ni ni-bold-right text-primary"></i> Permissions
            </a>
          </li>
          @endcan

                             @can("index",App\User::class) 
                            <li class="nav-item permissionItems" style="display: none;margin-left:8px">
                              <a id="users" class="nav-link " href="/users">
                                <i class="ni ni-circle-08 text-blue"></i> Users 
                              </a>
                            </li>
                            @endcan

                             @can("index",App\User::class) 
                            <li class="nav-item permissionItems" style="display: none;margin-left:8px">
                               <a id="groups" class="nav-link " href="/groups">
                                <i class="ni ni-single-02 text-blue"></i> Groups 
                              </a>
                            </li>
                            @endcan



                            <div class="dropdown-divider"></div>

          
           <li class="nav-item" style="margin-left: 16px;">
            <a class="nav-link" href="javascript:void(0)" onclick="toggleFunction('.configurationItems')" style="font-size: 1rem;color: black">
                <i id="configurationIcon" class="ni ni-bold-right text-primary"></i> Configuration
            </a>
          </li>
         

                             @can("index",App\User::class) 
                            <li class="nav-item configurationItems" style="display: none;margin-left:8px">
                               <a id="domains" class="nav-link " href="/domains">
                                <i class="ni ni-world-2 text-blue"></i> Domains 
                              </a>
                            </li>
                            @endcan

                           
                            <li class="nav-item configurationItems" style="display: none;margin-left:8px">
                               <a id="themes" class="nav-link " href="/themes">
                                <i class="ni ni-diamond text-blue"></i> Themes 
                              </a>
                            </li>
         

         
        
        </ul>
        
      </div>
    </div>
  </nav>
  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="javascript:void(0)" onclick="toggleNavBar()"><i style="color: white !important;font-size: 2rem;" class="ni ni-align-left-2 text-blue"></i></a>
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

  <script>
    var toggle = true;
    var element = document.getElementsByClassName("navbar")[0];
    function toggleNavBar(){
      if(toggle)
      {
        element.classList.remove("fixed-left");
        toggle=false;
      }
      else
      {
        element.classList.add("fixed-left");
        toggle=true;
      }
    }
  </script>

  <!--   Core   -->
  <script src="/js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Argon JS   -->
  <script src="/js/argon-dashboard.min.js?v=1.1.0"></script>
  <!-- js files -->
  <script src="/js/axios.min.js"></script>
  <script src="/js/vue.js"></script>
  <script src="/js/url.js"></script>

  @yield('js')
</body>

</html>
<?php
$id = $_SESSION['user'];
$db = $_SESSION['db'];
$user = DB::table($db.'.teacher')->where($db.'.teacher.id',$id)->first();
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{config('app.name')}} - @yield('title')</title>

        {{-- css file include  --}}
    <link rel="stylesheet" href="{{ asset('BackendAssets/css/bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('BackendAssets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('BackendAssets/css/datatables.min.css')}}">

   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
   
   
    {{-- include favicon  --}}
    <link rel="icon" href="{{ asset('/uploads/logo/favicon.png')}}" sizes="16x16" type="image/png">
    </head>
<body>
    <div class="page-wrapper chiller-theme toggled">
        <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
          <i class="fa fa-bars"></i>
        </a>
        <nav id="sidebar" class="sidebar-wrapper">
          <div class="sidebar-content">
            <div class="sidebar-brand">
              <a href="#">Eduate</a>
              <div id="close-sidebar">
                <i class="fa fa-times"></i>
              </div>
            </div>
            <div class="sidebar-header">
              <div class="user-pic">
                <img class="img-responsive img-rounded" src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg"
                  alt="User picture">
              </div>
              <div class="user-info">
                <span class="user-name">{{$user->teacher_name}}
                </span>
                <span class="user-role text-uppercase">Teacher</span>
                <span class="user-status">
                  <i class="fa fa-circle"></i>
                  <span>Online</span>
                </span>
              </div>
            </div>
           
            <!-- sidebar-header  -->
            <div class="sidebar-search">
              <div>
                <div class="input-group">
                  <input type="text" class="form-control search-menu" placeholder="Search...">
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="fa fa-search" aria-hidden="true"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <!-- sidebar-search  -->
            <div class="sidebar-menu">
              <ul>
                <li class="header-menu">
                  <span>General</span>
                </li>
                <li>
                <a href="{{ url('stuff/dashboard')}}">
                        <i class="fa fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('stuff/profile')}}">
                        <i class="fa fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('stuff/homeTask')}}">
                    <i class="fas fa-users"></i>
                        <span>Home Task</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('stuff/myClasses')}}">
                    <i class="fab fa-cuttlefish"></i>
                        <span>My Classes</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('stuff/notice')}}">
                        <i class="fa fa-book"></i>
                        <span>Notice</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('stuff/attendence')}}">
                        <i class="fa fa-users"></i>
                        <span>Attendence</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('stuff/attendenceHistory')}}">
                        <i class="fa fa-book"></i>
                        <span>Attendence History</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('stuff/publishResult')}}">
                        <i class="fa fa-users"></i>
                        <span>Publish result</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('stuff/viewResult')}}">
                        <i class="fa fa-users"></i>
                        <span>View result</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('stuff/routine')}}">
                        <i class="fa fa-users"></i>
                        <span>Routine</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('stuff/contact')}}">
                        <i class="fa fa-users"></i>
                        <span>Contact</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('stuff/transaction')}}">
                        <i class="fa fa-users"></i>
                        <span>Transaction</span>
                    </a>
                </li>

                </li>
              </ul>
            </div>
            <!-- sidebar-menu  -->
          </div>
          
          <!-- sidebar-content  -->
          <div class="sidebar-footer">
            <a href="#">
              <i class="fa fa-bell"></i>
              <span class="badge badge-pill badge-warning notification">3</span>
            </a>
            <a href="#">
              <i class="fa fa-envelope"></i>
              <span class="badge badge-pill badge-success notification">7</span>
            </a>
            <a href="{{url('changePassword')}}">
              <i class="fa fa-cog"></i>
              <span class="badge-sonar"></span>
            </a>
          <a class="" href="{{ url('/user/logout')}}">
                <i class="fa fa-power-off"></i>
            </a>
            
          </div>
        </nav>
        <!-- sidebar-wrapper  -->
         {{-- ################# main content Start  ################################ --}}
         <div class="container_fluid kk_d_navbar">
            <ul class="nav float-right">
                <li class="nav-item">
                  <a class="kk-nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                  <a class="kk-nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                  <a class="kk-nav-link" href="#">Chat</a>
                </li>
                <li class="nav-item">
                  <a class="kk-nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item">
                  <a class="kk-nav-link" href="#">Help!</a>
                </li>
              </ul>
         </div>
        <main class="page-content">
            @yield('content')
        </main>
         {{-- ################# main content End  ################################ --}}
      </div>
      <!-- page-wrapper -->
       {{-- include js file  --}}
    {{-- X-CSRF-TOKEN for all ajax post requests --}}
    <script>
      $(document).ready(function(){
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
      });
  </script>
        @yield('js') {{--add custom js --}}
        
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
       <script src="{{ asset('backendAssets/js/custom.js')}}"></script>
       <script src="{{ asset('backendAssets/js/bootstrap.min.js')}}"></script>
       <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>

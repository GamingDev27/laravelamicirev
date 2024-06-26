<!DOCTYPE html>
<html lang="en">
   <head>
		<meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="Bryan Victoria" />
        
		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        
		<script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
        
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
		<link href="{{ asset('css/jquery.fileupload.css') }}" rel="stylesheet">
		<link href="{{ asset('css/jquery.fileupload-ui.css') }}" rel="stylesheet">
		
		<script src="{{ asset('js/vendor/jquery.min.js') }}" ></script>
		<script src="{{ asset('js/vendor/ckeditor5-build-classic/ckeditor.js') }}" ></script>
		<script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}" ></script>
		<script src="{{ asset('js/admin.js') }}" ></script>
        <script src="{{ asset('js/vendor/jquery.min.js') }}" ></script>
        <script src="{{ asset('js/vendor/jquery.blockUI.js') }}" ></script>
        <script src="{{ asset('js/common.js') }}" ></script>
        <script src="{{ asset('js/vendor/Chart.min.js') }}" ></script>
        
        
        
    
    </head>
    <body class="sb-nav-fixed">
		<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand js-scroll-trigger" href="/"><img src="/assets/img/logo.png" style="width: 150px;height: 40px;" alt="ARC Logo" /></a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            </div>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="{{ route('admin_dashboard')}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                DASHBOARD
                            </a>
                            <div class="sb-sidenav-menu-heading py-0">STUDENTS</div>
                            <a class="nav-link" href="{{ route('admin_student_search')}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-search"></i></div>
                                SEARCH
                            </a>
                            <div class="sb-sidenav-menu-heading py-0">
                                SEASONS
                                <a class="btn btn-dark m-0 p-0 px-1 float-right" href="{{ route('admin_season_add') }}">
                                    <i class="fa fa-plus-square  m-0 p-0" ></i>
                                </a>
                                <a class="btn btn-dark m-0 p-0 px-1 float-right" href="{{ route('admin_season_index') }}">
                                    <i class="fa fa-list  m-0 p-0" ></i>
                                </a>
                            </div>
                            @if(isset($admin_seasons))
                                @foreach($admin_seasons as $season)
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts{{$season->id}}" aria-expanded="false" aria-controls="collapseLayouts{{$season->id}}">
                                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                        {{ $season->name }}
                                    </a>
                                    <div class="collapse" id="collapseLayouts{{$season->id}}" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            @foreach($season->batches as $batch)
                                                <a class="nav-link" href="{{ route('admin_batch_view',$batch->id) }}"> {{ $batch->name }} </a>
                                            @endforeach
                                            @if($season->enabled)
                                                <a class="nav-link" href="{{ route('admin_batch_add',$season->id) }}">ADD BATCH     
                                                <i class="fa fa-plus-square  m-0 p-0" ></i> </a>
                                            @endif
                                        </nav>
                                    </div>
                                @endforeach
                            @endif
                            
                            
                            <div class="sb-sidenav-menu-heading py-0">WEBSITE</div>
                            <a class="nav-link" href="{{ route('admin_messages') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-envelope-open-text"></i></div>
                                MESSAGES
                            </a>
                            <a class="nav-link" href="{{ route('admin_team') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div>
                                TEAM
                            </a>
                            <a class="nav-link" href="{{ route('admin_about') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                ABOUT US
                            </a>
                            <a class="nav-link" href="{{ route('admin_contact') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                CONTACT US
                            </a>
                            <a class="nav-link" href="{{ route('admin_courses') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                COURSES
                            </a>
                            <a class="nav-link" href="{{ route('admin_coaches') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                COACHES
                            </a>
                            <a class="nav-link" href="{{ route('admin_users') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                ADMINISTRATORS
                            </a>
							<a class="nav-link" href="{{ route('admin_gdrive_videos') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-envelope-open-text"></i></div>
                                IMPORT GDRIVE VIDEOS
                            </a>
                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        @if(Auth::user()->student)
                            {{ Auth::user()->student->last_name }}, {{ Auth::user()->student->first_name }}
                        @else
                            {{ Auth::user()->name }}
                        @endif
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        @include('flash-message')
                        @yield('content')
                    </div>
                </main>

                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
                @stack('scripts')
            </div>
        </div>
        
    </body>
</html>

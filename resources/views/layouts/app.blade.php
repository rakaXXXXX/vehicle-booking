<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Vehicle Booking System') - Nikel Mining Co.</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --sidebar-width: 250px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }
        
        .wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }
        
        #sidebar {
            width: var(--sidebar-width);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 999;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: #fff;
            transition: all 0.3s;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        #sidebar.active {
            margin-left: -250px;
        }
        
        #sidebar .sidebar-header {
            padding: 20px;
            background: rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        #sidebar .sidebar-header h3 {
            margin: 10px 0 0;
            font-size: 1.5rem;
        }
        
        #sidebar .sidebar-header p {
            margin: 5px 0 0;
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        #sidebar ul.components {
            padding: 20px 0;
        }
        
        #sidebar ul li a {
            padding: 12px 20px;
            font-size: 1rem;
            display: block;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        #sidebar ul li a:hover {
            color: #fff;
            background: rgba(255,255,255,0.1);
            padding-left: 30px;
        }
        
        #sidebar ul li.active > a {
            color: #fff;
            background: rgba(255,255,255,0.2);
        }
        
        #sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
        }
        
        #content {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
            min-height: 100vh;
        }
        
        #content.active {
            width: 100%;
            margin-left: 0;
        }
        
        #content .navbar {
            padding: 15px 30px;
            background: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.02);
            transition: all 0.3s;
        }
        
        .card:hover {
            box-shadow: 0 5px 30px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card .stat-icon {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 3rem;
            opacity: 0.2;
        }
        
        .stat-card h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: 600;
        }
        
        .stat-card p {
            margin: 5px 0 0;
            color: #6c757d;
        }
        
        .badge-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .toast-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 1050;
        }
        
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                width: 100%;
                margin-left: 0;
            }
            #content.active {
                margin-left: 250px;
            }
        }
        
        .page-header {
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px);
        }
        
        .table thead th {
            border-top: none;
            background: #f8f9fa;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
            border: none;
            color: white !important;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-truck fa-3x mb-3"></i>
                <h3>Nikel Mining Co.</h3>
                <p>{{ auth()->user()->full_name ?? 'User' }}</p>
                <small class="badge bg-light text-dark mt-2">
                    {{ auth()->user() ? str_replace('_', ' ', ucfirst(auth()->user()->role)) : 'Guest' }}
                </small>
            </div>

            <ul class="components">
                <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                
                @auth
                    @if(auth()->user()->isAdmin())
                        <li>
                            <a href="{{ route('bookings.index') }}">
                                <i class="fas fa-calendar-alt"></i> Bookings
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('vehicles.index') }}">
                                <i class="fas fa-truck"></i> Vehicles
                            </a>
                        </li>
                    @endif

@if(auth()->user()->isApprover())
                        <li>
                            <a href="{{ route('approvals.index') }}">
                                <i class="fas fa-check-circle"></i> Approvals
                            </a>
                        </li>
                    @endif

                    <li>
                        <a href="{{ route('reports.index') }}">
                            <i class="fas fa-chart-bar"></i> Reports
                        </a>
                    </li>

                    <li class="mt-4">
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-sign-out-alt text-danger"></i> Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</li>
                @endauth
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-outline-primary">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="ms-auto d-flex align-items-center">
                        @auth
                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-2"></i>
                                    {{ auth()->user()->full_name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endauth
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Toggle Sidebar
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar, #content').toggleClass('active');
        });

        // Global AJAX Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Toast Notification
        function showToast(message, type = 'success') {
            const toast = `
                <div class="toast align-items-center text-white bg-${type} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;
            
            $('#toastContainer').append(toast);
            const toastElement = new bootstrap.Toast($('#toastContainer .toast').last()[0]);
            toastElement.show();
            
            setTimeout(() => {
                $('#toastContainer .toast').first().remove();
            }, 5000);
        }

        // Initialize DataTables
        $(document).ready(function() {
            $('.datatable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
                },
                pageLength: 10,
                responsive: true
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
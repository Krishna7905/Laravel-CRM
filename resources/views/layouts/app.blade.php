<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'CRM')</title>

    <link rel="icon" href="{{ asset('Laravel.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('Laravel.png') }}" type="image/png">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
            transition: all 0.3s ease;
        }

        body.dark-mode {
            background: #0f172a;
            color: #e2e8f0;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            background: #1e293b;
            color: #fff;
            transition: 0.3s;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            margin: 5px;
            border-radius: 8px;
            color: #cbd5e1;
            text-decoration: none;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: rgba(13, 110, 253, 0.2);
            color: #fff;
        }

        .sidebar a.active {
            background: #0d6efd;
            color: #fff;
        }

        .sidebar i {
            width: 20px;
        }

        .sidebar.collapsed span {
            display: none;
        }

        .main-content {
            margin-left: 240px;
            padding: 20px;
            transition: 0.3s;
        }

        .main-content.full {
            margin-left: 70px;
        }

        .topbar {
            background: #fff;
            padding: 12px 20px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        body.dark-mode .topbar {
            background: #1e293b;
        }


        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }


        .action-group {
            display: flex;
            justify-content: flex-end;
            gap: 6px;
        }

        .action-btn {
            font-size: 13px;
            padding: 5px 12px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            background: #fff;
        }

        .action-btn.primary {
            color: #0d6efd;
            border-color: #0d6efd;
        }

        .action-btn.primary:hover {
            background: #0d6efd;
            color: #fff;
        }

        .action-btn.danger {
            color: #dc3545;
            border-color: #dc3545;
        }

        .action-btn.danger:hover {
            background: #dc3545;
            color: #fff;
        }


        .badge {
            border-radius: 20px;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
    </style>

    @yield('styles')
</head>

<body>

    <div class="sidebar" id="sidebar">

        <h5 class="text-center py-3 border-bottom">
            <i class="fa fa-layer-group"></i> <span>CRM</span>
        </h5>

        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa fa-home"></i> <span> Dashboard</span>
        </a>

        <a href="{{ route('leads.index') }}" class="{{ request()->routeIs('leads.*') ? 'active' : '' }}">
            <i class="fa fa-user-plus"></i> <span> Leads</span>
        </a>

        <a href="{{ route('contacts.index') }}" class="{{ request()->routeIs('contacts.*') ? 'active' : '' }}">
            <i class="fa fa-address-book"></i> <span> Team Allocation</span>
        </a>

        <a href="{{ route('employees.index') }}" class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">
            <i class="fa fa-users"></i> <span> Employees</span>
        </a>
        <a href="{{ route('pipeline.index') }}" class="{{ request()->routeIs('pipeline.*') ? 'active' : '' }}">
            <i class="fa fa-chart-line"></i> <span> Pipeline</span>
        </a>

        <a href="{{ route('deals.index') }}" class="{{ request()->routeIs('deals.*') ? 'active' : '' }}">
            <i class="fa fa-handshake"></i> <span> Deals</span>
        </a>

        <a href="{{ route('tasks.index') }}" class="{{ request()->routeIs('tasks.*') ? 'active' : '' }}">
            <i class="fa fa-tasks"></i> <span> Tasks</span>
        </a>


        <a href="{{ route('activities.index') }}" class="{{ request()->routeIs('activities.*') ? 'active' : '' }}">
            <i class="fa fa-history"></i> <span> Activity</span>
        </a>

    </div>

    <div class="main-content" id="main">

        <div class="topbar mb-3">

            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-outline-dark" id="toggleSidebar">
                    <i class="fa fa-bars"></i>
                </button>

                <h5 class="mb-0">@yield('title','Dashboard')</h5>
            </div>

            <div class="d-flex align-items-center gap-3">

                <!-- DARK MODE -->
                <button class="btn btn-sm btn-outline-secondary" id="darkModeToggle">
                    Mode
                </button>


                @auth
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                        {{ auth()->user()->name }}
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endauth

            </div>

        </div>

        @yield('content')

    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $('#toggleSidebar').click(function() {
            $('#sidebar').toggleClass('collapsed');
            $('#main').toggleClass('full');
        });

        // DARK MODE
        $('#darkModeToggle').click(function() {
            $('body').toggleClass('dark-mode');
        });
    </script>

    @yield('scripts')

</body>

</html>
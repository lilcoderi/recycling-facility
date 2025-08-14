<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel App') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            width: 250px;
            background-color: #212529;
            color: #ffffff;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            z-index: 1030;
            transition: width 0.3s ease;
        }

        .sidebar.collapsed {
            width: 60px;
        }

        .sidebar .navbar-brand {
            font-weight: bold;
            font-size: 1.3rem;
            color: #ffffff;
            margin-bottom: 20px;
            text-decoration: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar.collapsed .navbar-brand .nav-text {
            display: none;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
            padding: 10px 15px;
            margin-bottom: 5px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
            display: flex;
            align-items: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        .sidebar .nav-link.active {
            font-weight: bold;
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .sidebar .nav-link .bi {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .content-wrapper {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            transition: margin-left 0.3s ease;
            margin-left: 0;
        }

        .sidebar-toggle-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .sidebar-toggle-button {
            background: none;
            border: none;
            color: #ffffff;
            font-size: 1.5rem;
            cursor: pointer;
            outline: none;
            transition: transform 0.3s ease;
        }

        .sidebar-toggle-button:focus {
            outline: none;
            box-shadow: none;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
                box-shadow: none;
                padding-bottom: 0;
                transition: none;
            }
            .sidebar .navbar-collapse {
                display: none !important;
            }
            .sidebar .navbar-toggler {
                display: block;
                margin-left: auto;
                color: #ffffff;
                border-color: rgba(255,255,255,.1);
            }
            .sidebar .navbar-toggler-icon {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            }
            .sidebar.show .navbar-collapse {
                display: block !important;
            }
            .sidebar-toggle-button {
                display: none !important;
            }
            .content-wrapper {
                margin-left: 0;
            }
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar.collapsed #sidebarContent {
            height: 0;
            opacity: 0;
            padding-top: 0;
            padding-bottom: 0;
            overflow: hidden;
            visibility: hidden;
            transition: height 0.3s ease, opacity 0.3s ease, padding 0.3s ease, visibility 0s 0.3s;
        }

        .sidebar #sidebarContent {
            height: auto;
            opacity: 1;
            padding-top: 0;
            padding-bottom: 0;
            overflow: visible;
            visibility: visible;
            transition: height 0.3s ease, opacity 0.3s ease, padding 0.3s ease, visibility 0s;
        }

        .sidebar.collapsed .navbar-brand i.bi {
            margin-right: 0;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="sidebar" id="sidebarNav">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-box-seam"></i> <span class="nav-text">{{ config('app.name', 'Laravel App') }}</span>
            </a>
            <button id="sidebarToggle" class="sidebar-toggle-button d-none d-md-block" title="Toggle Sidebar">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#sidebarContent" aria-controls="sidebarContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-md-block" id="sidebarContent">
            <ul class="navbar-nav flex-column">
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('facilities.*') ? 'active' : '' }}"
                           href="{{ route('facilities.index') }}">
                           <i class="bi bi-building"></i> <span class="nav-text">Facilities</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('materials.*') ? 'active' : '' }}"
                           href="{{ route('materials.index') }}">
                           <i class="bi bi-tools"></i> <span class="nav-text">Materials</span>
                        </a>
                    </li>
                @endauth
            </ul>

            <ul class="navbar-nav flex-column sidebar-bottom">
                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> <span class="nav-text">Login</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">
                            <i class="bi bi-person-plus"></i> <span class="nav-text">Register</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="#"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> <span class="nav-text">Logout ({{ Auth::user()->name }})</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>

    <div class="content-wrapper">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebarNav');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const navTexts = document.querySelectorAll('.nav-text');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');

                    const icon = sidebarToggle.querySelector('i');
                    if (sidebar.classList.contains('collapsed')) {
                        icon.classList.remove('bi-list');
                        icon.classList.add('bi-arrow-right-square');
                    } else {
                        icon.classList.remove('bi-arrow-right-square');
                        icon.classList.add('bi-list');
                    }
                });
            }

            function checkScreenWidth() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('collapsed');
                    if (sidebarToggle) {
                        sidebarToggle.style.display = 'none';
                    }
                } else {
                    if (sidebarToggle) {
                        sidebarToggle.style.display = 'block';
                    }
                }
            }

            checkScreenWidth();
            window.addEventListener('resize', checkScreenWidth);
        });
    </script>

    @stack('scripts')
</body>
</html>

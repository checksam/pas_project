<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Manajemen Bank</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: radial-gradient(circle at top left, rgba(52, 152, 219, 0.18), transparent 35%),
                        radial-gradient(circle at bottom right, rgba(46, 204, 113, 0.16), transparent 30%),
                        #f4f7fb;
            color: #2c3e50;
            min-height: 100vh;
        }
        .navbar {
            background-color: #1a344b !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        .sidebar {
            background: linear-gradient(180deg, #273947 0%, #1f2f3d 100%);
            min-height: calc(100vh - 56px);
            color: #e3ebf2;
            position: sticky;
            top: 0;
            padding-top: 1.5rem;
            max-height: calc(100vh - 56px);
            overflow-y: auto;
        }
        .sidebar h5 {
            letter-spacing: 0.02em;
        }
        .sidebar a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            display: block;
            padding: 12px 16px;
            border-radius: 8px;
            margin: 6px 0;
            transition: all 0.25s ease;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.08);
            color: #ffffff;
        }
        .sidebar .nav-link {
            font-weight: 500;
        }
        .content {
            padding: 24px 0;
        }
        .main-content {
            background-color: #ffffff;
            border-radius: 18px;
            padding: 28px;
            box-shadow: 0 20px 50px rgba(44, 62, 80, 0.08);
            border: 1px solid rgba(100, 116, 139, 0.12);
        }
        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(39, 60, 84, 0.06);
        }
        .card-header {
            border-radius: 14px 14px 0 0;
        }
        .btn-primary {
            background-color: #2d8cff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #1e6fe8;
        }
        .table {
            background-color: #ffffff;
        }
        .table-responsive {
            overflow-x: auto;
        }
        @media (max-width: 991.98px) {
            .sidebar {
                position: relative;
                top: auto;
                min-height: auto;
                max-height: none;
                overflow: visible;
                padding-top: 1rem;
            }
            .content {
                padding-top: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-light btn-sm d-lg-none me-3" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle Menu Utama">
                    ☰
                </button>
                <a class="navbar-brand" href="/">🏦 Manajemen Bank</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <span class="nav-link">{{ auth()->user()->name }}</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <div class="container-fluid pt-0 pb-4">
        <div class="row gx-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="collapse d-lg-block sidebar p-4" id="sidebarMenu">
                    <h5 class="mb-4 text-white">Menu Utama</h5>
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">📊 Dashboard</a>
                    <a class="nav-link {{ request()->is('pegawai*') ? 'active' : '' }}" href="/pegawai">👥 Pegawai</a>
                    <a class="nav-link {{ request()->is('rekening*') ? 'active' : '' }}" href="/rekening">💰 Rekening</a>
                    <a class="nav-link {{ request()->is('transaksi*') ? 'active' : '' }}" href="/transaksi">📝 Transaksi</a>
                    <a class="nav-link {{ request()->is('transfer*') ? 'active' : '' }}" href="/transfer">🔄 Transfer</a>
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-9 content">
                <div class="main-content">
                    <!-- Alert Messages -->
                    @if($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Validation Errors -->
                    @if($errors->any())
                        <div class="alert alert-warning alert-dismissible fade show rounded-3" role="alert">
                            <strong>Error validasi:</strong>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

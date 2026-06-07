<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Manajemen Bank</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Dark theme overrides */
        :root{
            --bg-900: #071023;
            --bg-800: #0b1624;
            --panel: #0f1724;
            --muted: #9fb3c8;
            --text: #e6eef8;
            --accent: #2563eb; /* blue accent */
            --accent-2: #10b981; /* green accent */
        }

        html,body {
            height: 100%;
        }

        body {
            background: radial-gradient(circle at 10% 10%, rgba(37,99,235,0.06), transparent 10%),
                        radial-gradient(circle at 90% 90%, rgba(16,185,129,0.04), transparent 8%),
                        var(--bg-900);
            color: var(--text);
            min-height: 100vh;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        .navbar {
            background-color: transparent !important;
            border-bottom: 1px solid rgba(255,255,255,0.04);
        }

        .navbar .navbar-brand { color: var(--text); }

        .sidebar {
            background: linear-gradient(180deg, #071428 0%, #081622 100%);
            min-height: calc(100vh - 56px);
            color: var(--muted);
            position: sticky;
            top: 0;
            padding-top: 1.5rem;
            max-height: calc(100vh - 56px);
            overflow-y: auto;
            border-right: 1px solid rgba(255,255,255,0.03);
        }

        .sidebar h5 { color: var(--text); letter-spacing: 0.02em; }

        .sidebar a { color: var(--muted); display:block; padding: 12px 16px; border-radius:8px; margin:6px 0; text-decoration:none }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.02); color: var(--text); }

        .content { padding: 24px 0; }

        .main-content {
            background-color: var(--panel);
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 8px 40px rgba(2,6,23,0.6);
            border: 1px solid rgba(255,255,255,0.03);
        }

        .card { background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)); border: 1px solid rgba(255,255,255,0.03); color: var(--text); }
        .card-header { border-radius: 12px 12px 0 0; background: transparent; border-bottom: 1px solid rgba(255,255,255,0.02); }

        /* Form controls dark */
        .form-control, .form-select, textarea.form-control {
            background-color: rgba(255,255,255,0.03);
            color: var(--text);
            border: 1px solid rgba(255,255,255,0.06);
            box-shadow: none;
        }
        .form-control::placeholder { color: rgba(230,238,248,0.5); }
        .form-control:focus, .form-select:focus { border-color: rgba(37,99,235,0.6); box-shadow: 0 0 0 0.15rem rgba(37,99,235,0.08); }

        .btn-primary { background-color: var(--accent); border: none; }
        .btn-primary:hover { background-color: #1e40af; }

        .btn-secondary { background-color: rgba(255,255,255,0.06); color: var(--text); border: 1px solid rgba(255,255,255,0.04); }

        .alert { background-color: rgba(255,255,255,0.02); color: var(--text); border: 1px solid rgba(255,255,255,0.03); }
        .alert-success { background-color: rgba(16,185,129,0.08); color: #d7fbe8; border-color: rgba(16,185,129,0.12); }
        .alert-danger { background-color: rgba(239,68,68,0.06); color: #ffdede; border-color: rgba(239,68,68,0.12); }

        .table { color: var(--text); }
        .table thead th { color: var(--muted); border-bottom: 1px solid rgba(255,255,255,0.03); }
        .table tbody tr { border-bottom: 1px solid rgba(255,255,255,0.02); }

        @media (max-width: 991.98px) {
            .sidebar { position: relative; top: auto; min-height: auto; max-height: none; overflow: visible; padding-top:1rem }
            .content { padding-top: 1rem; }
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

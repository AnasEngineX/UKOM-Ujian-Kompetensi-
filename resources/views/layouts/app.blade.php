<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Pendaftaran Beasiswa Kampus">
    <title>@yield('title', 'Beasiswa Kampus') | Pendaftaran Beasiswa</title>

    {{-- Bootstrap 5.3 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Google Fonts: Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* =============================================
           CSS GLOBAL & DESIGN SYSTEM
        ============================================= */
        :root {
            --primary:       #4f46e5;
            --primary-dark:  #3730a3;
            --primary-light: #818cf8;
            --secondary:     #0ea5e9;
            --success:       #10b981;
            --warning:       #f59e0b;
            --danger:        #ef4444;
            --dark:          #0f172a;
            --card-bg:       #1e293b;
            --muted:         #94a3b8;
            --border:        rgba(255,255,255,0.08);
            --shadow:        0 20px 60px rgba(0,0,0,0.4);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
            min-height: 100vh;
            color: #e2e8f0;
        }

        /* ---- Navbar ---- */
        .navbar-brand-text {
            font-weight: 800;
            font-size: 1.3rem;
            background: linear-gradient(90deg, #818cf8, #38bdf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidenav {
            background: linear-gradient(180deg, #1e1b4b 0%, #0f172a 100%);
            border-right: 1px solid var(--border);
            min-height: 100vh;
            width: 240px;
            position: fixed;
            top: 0; left: 0;
            padding: 2rem 1rem;
            z-index: 100;
        }

        .sidenav .brand {
            font-size: 1.2rem;
            font-weight: 800;
            background: linear-gradient(90deg, #818cf8, #38bdf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 2.5rem;
            display: block;
            text-align: center;
        }

        .sidenav .nav-link {
            color: #94a3b8;
            padding: .65rem 1rem;
            border-radius: 10px;
            margin-bottom: .3rem;
            font-size: .9rem;
            font-weight: 500;
            transition: all .25s ease;
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .sidenav .nav-link:hover,
        .sidenav .nav-link.active {
            color: #fff;
            background: linear-gradient(90deg, rgba(79,70,229,.35), rgba(14,165,233,.15));
            border-left: 3px solid var(--primary-light);
        }

        /* ---- Main content wrapper ---- */
        .main-content {
            margin-left: 240px;
            padding: 2rem;
        }

        /* ---- Page header ---- */
        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #f1f5f9;
        }

        .page-header p {
            color: var(--muted);
            font-size: .9rem;
        }

        /* ---- Cards ---- */
        .card-glass {
            background: rgba(30,41,59,.7);
            border: 1px solid var(--border);
            border-radius: 16px;
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 32px rgba(0,0,0,.3);
        }

        .card-stat {
            background: rgba(30,41,59,.7);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .card-stat:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,0,.4);
        }

        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #f1f5f9;
            line-height: 1;
        }

        .stat-label {
            font-size: .8rem;
            color: var(--muted);
            font-weight: 500;
        }

        /* ---- Buttons ---- */
        .btn-primary-gradient {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: .55rem 1.4rem;
            font-weight: 600;
            font-size: .875rem;
            transition: all .25s ease;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            text-decoration: none;
        }

        .btn-primary-gradient:hover {
            background: linear-gradient(135deg, #4338ca, #6d28d9);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(79,70,229,.4);
        }

        .btn-secondary-outline {
            background: transparent;
            color: #94a3b8;
            border: 1px solid rgba(255,255,255,.15);
            border-radius: 10px;
            padding: .55rem 1.4rem;
            font-weight: 600;
            font-size: .875rem;
            transition: all .25s ease;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            text-decoration: none;
        }

        .btn-secondary-outline:hover {
            background: rgba(255,255,255,.07);
            color: #e2e8f0;
            border-color: rgba(255,255,255,.25);
        }

        .btn-danger-sm {
            background: rgba(239,68,68,.15);
            color: #f87171;
            border: 1px solid rgba(239,68,68,.3);
            border-radius: 8px;
            padding: .35rem .8rem;
            font-size: .8rem;
            font-weight: 600;
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            text-decoration: none;
        }

        .btn-danger-sm:hover {
            background: rgba(239,68,68,.3);
            color: #fca5a5;
        }

        .btn-edit-sm {
            background: rgba(79,70,229,.15);
            color: #a5b4fc;
            border: 1px solid rgba(79,70,229,.3);
            border-radius: 8px;
            padding: .35rem .8rem;
            font-size: .8rem;
            font-weight: 600;
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            text-decoration: none;
        }

        .btn-edit-sm:hover {
            background: rgba(79,70,229,.3);
            color: #c7d2fe;
        }

        /* ---- Forms ---- */
        .form-glass {
            background: rgba(30,41,59,.8);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2.5rem;
            backdrop-filter: blur(12px);
        }

        .form-label {
            color: #cbd5e1;
            font-size: .875rem;
            font-weight: 600;
            margin-bottom: .4rem;
        }

        .form-control, .form-select {
            background: rgba(15,23,42,.6) !important;
            border: 1px solid rgba(255,255,255,.12) !important;
            color: #e2e8f0 !important;
            border-radius: 10px !important;
            padding: .65rem 1rem !important;
            font-size: .9rem;
            font-family: 'Poppins', sans-serif;
            transition: border-color .25s, box-shadow .25s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-light) !important;
            box-shadow: 0 0 0 3px rgba(129,140,248,.2) !important;
            background: rgba(15,23,42,.8) !important;
            outline: none;
        }

        .form-control::placeholder { color: #475569; }

        .form-control[readonly] {
            background: rgba(15,23,42,.4) !important;
            color: #64748b !important;
            cursor: not-allowed;
        }

        .form-select option {
            background: #1e293b;
            color: #e2e8f0;
        }

        /* ---- Table ---- */
        .table-glass {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-glass thead th {
            background: rgba(79,70,229,.2);
            color: #a5b4fc;
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            padding: 1rem 1.2rem;
            border: none;
            border-bottom: 1px solid rgba(79,70,229,.3);
        }

        .table-glass tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .2s;
        }

        .table-glass tbody tr:hover {
            background: rgba(255,255,255,.04);
        }

        .table-glass tbody td {
            padding: .9rem 1.2rem;
            font-size: .875rem;
            color: #cbd5e1;
            vertical-align: middle;
            border: none;
        }

        /* ---- Badge ---- */
        .badge-status {
            display: inline-block;
            padding: .3rem .75rem;
            border-radius: 999px;
            font-size: .73rem;
            font-weight: 600;
        }

        .badge-pending {
            background: rgba(245,158,11,.15);
            color: #fcd34d;
            border: 1px solid rgba(245,158,11,.3);
        }

        .badge-approved {
            background: rgba(16,185,129,.15);
            color: #6ee7b7;
            border: 1px solid rgba(16,185,129,.3);
        }

        .badge-rejected {
            background: rgba(239,68,68,.15);
            color: #fca5a5;
            border: 1px solid rgba(239,68,68,.3);
        }

        /* ---- Alert ---- */
        .alert-glass-success {
            background: rgba(16,185,129,.12);
            border: 1px solid rgba(16,185,129,.35);
            color: #6ee7b7;
            border-radius: 12px;
            padding: .85rem 1.2rem;
            display: flex;
            align-items: center;
            gap: .6rem;
            font-size: .875rem;
            font-weight: 500;
        }

        .alert-glass-danger {
            background: rgba(239,68,68,.12);
            border: 1px solid rgba(239,68,68,.35);
            color: #fca5a5;
            border-radius: 12px;
            padding: .85rem 1.2rem;
            display: flex;
            align-items: center;
            gap: .6rem;
            font-size: .875rem;
            font-weight: 500;
        }

        /* ---- Validation errors ---- */
        .text-danger-sm {
            color: #f87171;
            font-size: .78rem;
            margin-top: .25rem;
            display: block;
        }

        .is-invalid-custom {
            border-color: rgba(239,68,68,.5) !important;
        }

        /* ---- Divider ---- */
        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 1.5rem 0;
        }

        /* ---- Section title ---- */
        .section-title {
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin: 1.2rem 0 .6rem 1rem;
        }

        /* ---- Responsive ---- */
        @media (max-width: 768px) {
            .sidenav { display: none; }
            .main-content { margin-left: 0; padding: 1rem; }
        }

        /* ---- Animations ---- */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .fade-in-up {
            animation: fadeInUp .4s ease forwards;
        }

        .fade-in-up-delay-1 { animation-delay: .1s; opacity: 0; }
        .fade-in-up-delay-2 { animation-delay: .2s; opacity: 0; }
        .fade-in-up-delay-3 { animation-delay: .3s; opacity: 0; }
    </style>

    @stack('styles')
</head>
<body>

{{-- ============ SIDEBAR ============ --}}
<nav class="sidenav" id="sidenav">
    <a class="brand" href="{{ route('dashboard') }}">
        <i class="fa-solid fa-graduation-cap me-1"></i> Pendaftaran Beasiswa
    </a>

    <div class="section-title">Menu Utama</div>

    <a href="{{ route('dashboard') }}"
       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
       id="nav-dashboard">
        <i class="fa-solid fa-house-chimney fa-fw"></i> Dashboard
    </a>

    <a href="{{ route('dashboard.daftar') }}"
       class="nav-link {{ request()->routeIs('dashboard.daftar') ? 'active' : '' }}"
       id="nav-daftar">
        <i class="fa-solid fa-file-pen fa-fw"></i> Daftar Beasiswa
    </a>

    <a href="{{ route('dashboard.hasil') }}"
       class="nav-link {{ request()->routeIs('dashboard.hasil') ? 'active' : '' }}"
       id="nav-hasil">
        <i class="fa-solid fa-table-list fa-fw"></i> Data Pendaftar
    </a>
</nav>

{{-- ============ MAIN CONTENT ============ --}}
<main class="main-content" id="main-content">
    @yield('content')
</main>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Angkringan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --gradient-calm: linear-gradient(135deg, #a280c4 0%, #f0d97f 60%, #fcfcfc 100%);
            --bg-light: #f4f6f9;
            --text-dark: #333;
        }
        body { font-family: 'Poppins', sans-serif; margin: 0; background-color: var(--bg-light); color: var(--text-dark); display: flex; flex-direction: column; min-height: 100vh; }
        .header { background: var(--gradient-calm); padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; height: 60px; }
        .nav-links { display: flex; gap: 10px; }
        .btn-nav { color: #5a3b75; text-decoration: none; font-weight: 600; background: rgba(255,255,255,0.4); padding: 8px 15px; border-radius: 20px; transition: 0.3s; display: inline-flex; align-items: center; gap: 5px; }
        .btn-nav:hover { background: rgba(255,255,255,0.7); }
        .main-content { flex: 1; padding: 30px; max-width: 1200px; margin: 0 auto; width: 100%; box-sizing: border-box; }
        .footer { background: var(--gradient-calm); padding: 20px; text-align: center; color: #5a3b75; font-weight: 500; margin-top: auto; }
        /* Style untuk container form agar seragam */
        .card { background: #fff; padding: 30px; border-radius: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    </style>
    @stack('styles')
</head>
<body>
    <header class="header">
        <div class="nav-links">
            <a href="{{ route('dashboard') }}" class="btn-nav">🏠 Dashboard</a>
            <a href="{{ route('stok.index') }}" class="btn-nav">📝 Input Stok</a>
            <a href="{{ route('manajemen.menu') }}" class="btn-nav">⚙️ Kelola Menu</a>
        </div>
        <div style="font-size: 24px;">👤</div>
    </header>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="footer">
        © {{ date('Y') }} Dashboard Angkringan - Manajemen Stok Digital
    </footer>

    @stack('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Bandara Raya Jaya - Airport Management System">
    <title><?= esc($title ?? 'Dashboard') ?> - Bandara Raya Jaya</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #f1f5f9;
            --bg-secondary: #ffffff;
            --bg-card: #ffffff;
            --bg-card-hover: #f8fafc;
            --border-color: #e2e8f0;
            --border-glow: #cbd5e1;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --accent-primary: #2563eb;
            --accent-secondary: #1d4ed8;
            --accent-gradient: linear-gradient(135deg, #1e293b, #334155, #475569);
            --success: #059669;
            --success-bg: #ecfdf5;
            --danger: #dc2626;
            --danger-bg: #fef2f2;
            --warning: #d97706;
            --warning-bg: #fffbeb;
            --info: #0284c7;
            --info-bg: #f0f9ff;
            --sidebar-width: 280px;
            --header-height: 70px;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: var(--bg-secondary);
            border-right: 1px solid var(--border-color);
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .sidebar-brand {
            padding: 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .sidebar-brand .brand-icon {
            width: 44px;
            height: 44px;
            background: var(--accent-gradient);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
        }

        .sidebar-brand .brand-text h1 {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1.2;
            letter-spacing: -0.5px;
        }

        .sidebar-brand .brand-text span {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 20px 16px;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-nav::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }

        .nav-section {
            margin-bottom: 28px;
        }

        .nav-section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            padding: 0 12px;
            margin-bottom: 12px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 12px;
            text-decoration: none;
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 600;
            transition: var(--transition);
            margin-bottom: 4px;
            position: relative;
        }

        .nav-item:hover {
            background: #f8fafc;
            color: var(--accent-primary);
        }

        .nav-item.active {
            background: #eff6ff;
            color: var(--accent-primary);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: -16px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: var(--accent-primary);
            border-radius: 0 4px 4px 0;
        }

        .nav-item i {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .header {
            height: var(--header-height);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: var(--shadow-sm);
        }

        .header-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.5px;
        }

        .header-time {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f1f5f9;
            padding: 8px 16px;
            border-radius: 100px;
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 600;
            border: 1px solid var(--border-color);
        }

        .content-wrapper {
            padding: 28px 32px;
        }

        /* ===== ALERT MESSAGES ===== */
        .alert {
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background: var(--success-bg);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: var(--success);
        }

        .alert-danger {
            background: var(--danger-bg);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }

        /* ===== STAT CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 28px;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--accent-primary);
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .stat-card .stat-value {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .stat-card .stat-label {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* ===== DATA TABLE ===== */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .card-header h2 {
            font-size: 16px;
            font-weight: 700;
        }

        .card-body {
            padding: 24px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead th {
            background: #f8fafc;
            padding: 14px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        table tbody td {
            padding: 14px 16px;
            font-size: 13.5px;
            border-bottom: 1px solid rgba(99, 102, 241, 0.06);
            color: var(--text-secondary);
        }

        table tbody tr {
            transition: var(--transition);
        }

        table tbody tr:hover {
            background: rgba(99, 102, 241, 0.04);
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--accent-gradient);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.4);
        }

        .btn-success {
            background: var(--success-bg);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: var(--success);
        }
        .btn-success:hover {
            background: rgba(16, 185, 129, 0.15);
        }

        .btn-warning {
            background: var(--warning-bg);
            border: 1px solid rgba(245, 158, 11, 0.2);
            color: var(--warning);
        }
        .btn-warning:hover {
            background: rgba(245, 158, 11, 0.15);
        }

        .btn-danger {
            background: var(--danger-bg);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }
        .btn-danger:hover {
            background: rgba(239, 68, 68, 0.15);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 8px;
        }

        .btn-back {
            background: rgba(100, 116, 139, 0.1);
            border: 1px solid rgba(100, 116, 139, 0.2);
            color: var(--text-secondary);
        }
        .btn-back:hover {
            background: rgba(100, 116, 139, 0.15);
        }

        .action-btns {
            display: flex;
            gap: 6px;
        }

        /* ===== FORMS ===== */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-primary);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 8.825L.175 3 1.23 1.943 6 6.713l4.77-4.77L11.825 3z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 40px;
        }

        select.form-control option {
            background: var(--bg-secondary);
            color: var(--text-primary);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* ===== BADGE ===== */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-success {
            background: var(--success-bg);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .badge-warning {
            background: var(--warning-bg);
            color: var(--warning);
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .badge-info {
            background: var(--info-bg);
            color: var(--info);
            border: 1px solid rgba(6, 182, 212, 0.2);
        }

        .badge-danger {
            background: var(--danger-bg);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.3;
        }

        .empty-state p {
            font-size: 14px;
        }

        /* ===== MOBILE TOGGLE ===== */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 20px;
            cursor: pointer;
            padding: 8px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .mobile-toggle {
                display: block;
            }
            .content-wrapper {
                padding: 20px 16px;
            }
            .form-row {
                grid-template-columns: 1fr;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card, .stat-card {
            animation: fadeIn 0.5s ease forwards;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="fas fa-plane"></i>
        </div>
        <div class="brand-text">
            <h1>Bandara Raya</h1>
            <span>Airport Management</span>
        </div>
    </div>

    <nav class="sidebar-nav">

        <div class="nav-section">
            <div class="nav-section-title">Master Data</div>
            <a href="<?= base_url('/maskapai') ?>" class="nav-item <?= (str_starts_with(uri_string(), 'maskapai')) ? 'active' : '' ?>">
                <i class="fas fa-building"></i> Maskapai
            </a>
            <a href="<?= base_url('/pesawat') ?>" class="nav-item <?= (str_starts_with(uri_string(), 'pesawat')) ? 'active' : '' ?>">
                <i class="fas fa-plane-departure"></i> Pesawat
            </a>
            <a href="<?= base_url('/gate') ?>" class="nav-item <?= (str_starts_with(uri_string(), 'gate')) ? 'active' : '' ?>">
                <i class="fas fa-door-open"></i> Gate
            </a>
            <a href="<?= base_url('/penumpang') ?>" class="nav-item <?= (str_starts_with(uri_string(), 'penumpang')) ? 'active' : '' ?>">
                <i class="fas fa-users"></i> Penumpang
            </a>
            <a href="<?= base_url('/kursi') ?>" class="nav-item <?= (str_starts_with(uri_string(), 'kursi')) ? 'active' : '' ?>">
                <i class="fas fa-chair"></i> Kursi
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Operasional</div>
            <a href="<?= base_url('/penerbangan') ?>" class="nav-item <?= (str_starts_with(uri_string(), 'penerbangan')) ? 'active' : '' ?>">
                <i class="fas fa-route"></i> Penerbangan
            </a>
            <a href="<?= base_url('/tiket') ?>" class="nav-item <?= (str_starts_with(uri_string(), 'tiket')) ? 'active' : '' ?>">
                <i class="fas fa-ticket-alt"></i> Tiket
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Keberangkatan</div>
            <a href="<?= base_url('/checkin') ?>" class="nav-item <?= (str_starts_with(uri_string(), 'checkin')) ? 'active' : '' ?>">
                <i class="fas fa-clipboard-check"></i> Check-in
            </a>
            <a href="<?= base_url('/bagasi') ?>" class="nav-item <?= (str_starts_with(uri_string(), 'bagasi')) ? 'active' : '' ?>">
                <i class="fas fa-suitcase-rolling"></i> Bagasi
            </a>
            <a href="<?= base_url('/boardingpass') ?>" class="nav-item <?= (str_starts_with(uri_string(), 'boardingpass')) ? 'active' : '' ?>">
                <i class="fas fa-id-card"></i> Boarding Pass
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Keuangan</div>
            <a href="<?= base_url('/pembayaran') ?>" class="nav-item <?= (str_starts_with(uri_string(), 'pembayaran') || str_starts_with(uri_string(), 'detail-pembayaran')) ? 'active' : '' ?>">
                <i class="fas fa-credit-card"></i> Pembayaran
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Laporan</div>
            <a href="<?= base_url('/laporan/penjualan') ?>" class="nav-item <?= (uri_string() == 'laporan/penjualan') ? 'active' : '' ?>">
                <i class="fas fa-file-invoice-dollar"></i> Laporan Penjualan
            </a>
            <a href="<?= base_url('/laporan/manifest') ?>" class="nav-item <?= (uri_string() == 'laporan/manifest') ? 'active' : '' ?>">
                <i class="fas fa-users-cog"></i> Laporan Manifest
            </a>
        </div>
    </nav>
</aside>

<!-- Main Content -->
<div class="main-content">
    <header class="header">
        <div style="display:flex;align-items:center;gap:12px;">
            <button class="mobile-toggle" onclick="document.getElementById('sidebar').classList.toggle('active')">
                <i class="fas fa-bars"></i>
            </button>
            <span class="header-title"><?= esc($title ?? 'Dashboard') ?></span>
        </div>
        <div class="header-time">
            <i class="fas fa-clock"></i>
            <span id="liveTime"></span>
        </div>
    </header>

    <div class="content-wrapper">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>
</div>

<script>
    // Live clock
     function updateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        document.getElementById('liveTime').textContent = now.toLocaleDateString('id-ID', options);
     }
     updateTime();
     setInterval(updateTime, 1000);

     // Auto-dismiss alerts
     setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        });
     }, 4000);

     // Persist Sidebar Scroll Position
     const sidebarNav = document.querySelector('.sidebar-nav');
     if (sidebarNav) {
         // Restore scroll position
         const savedScrollTop = localStorage.getItem('sidebarScrollTop');
         if (savedScrollTop !== null) {
             sidebarNav.scrollTop = parseInt(savedScrollTop, 10);
         }

         // Scroll active link into view if needed
         const activeLink = sidebarNav.querySelector('.nav-item.active');
         if (activeLink) {
             // Only auto-scroll if there was no manually saved position
             if (savedScrollTop === null) {
                 activeLink.scrollIntoView({ block: 'nearest' });
             }
         }

         // Listen to scroll events and save position
         sidebarNav.addEventListener('scroll', () => {
             localStorage.setItem('sidebarScrollTop', sidebarNav.scrollTop);
         });
     }
</script>

</body>
</html>

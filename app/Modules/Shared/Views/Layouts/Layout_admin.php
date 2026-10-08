<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard Admin' ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* ===== Variabel Tema ===== */
        :root {
            --navy: #013D58;
            --navy-light: #00537B;
            --navy-dark: #012f46;
            --gold: #F7C741;
            --soft-gray: #F5F5F5;
            --accent: #7EBCDA;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', Tahoma, sans-serif;
        }

        body {
            background: #f3f4f6;
            min-height: 100vh;
            display: flex;
        }

        /* ===== Layout: sidebar + content ===== */
        .layout {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            width: 260px;
            background: var(--navy);
            color: #fff;
            padding: 20px 0;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;

            /* ↓ Sidebar tidak ikut scroll */
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;

            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar .brand {
            padding: 0 20px 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .sidebar .brand img {
            width: 35px;
            height: 40px;
        }

        .sidebar .brand strong {
            color: var(--gold);
            font-size: 14px;
            display: block;
        }

        .sidebar .brand span {
            color: #fff;
            font-size: 12px;
        }

        .sidebar .section-title {
            color: var(--gold);
            font-size: 12px;
            font-weight: 700;
            padding: 12px 20px 6px;
            text-transform: uppercase;
        }

        .sidebar a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 14px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.1);
            border-left: 3px solid var(--gold);
        }

        .sidebar .logout {
            margin: auto 20px 20px 20px;
            padding: 10px 20px;
            border: 1px solid #fff;
            border-radius: 8px;
            text-align: center;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
        }

        .sidebar .logout:hover {
            background: #fff;
            color: var(--navy);
        }

        /* ===== Content ===== */
        .content {
            flex: 1;
            padding: 24px 32px;
            min-width: 0;
        }

        .content h1 {
            color: var(--navy);
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* ===== Stat Cards ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border-left: 6px solid var(--navy);
        }

        .stat-card:nth-child(2) {
            border-left-color: #60a5fa;
        }

        .stat-card:nth-child(3) {
            border-left-color: #f59e0b;
        }

        .stat-card:nth-child(4) {
            border-left-color: #16a34a;
        }

        .stat-card .label {
            color: var(--navy);
            font-size: 14px;
            margin-bottom: 8px;
        }

        .stat-card .value {
            color: var(--navy);
            font-size: 32px;
            font-weight: 700;
        }

        /* ===== Card ===== */
        .card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            max-width: 700px;
            width: 100%;
            margin: 0 auto;
        }

        .card-wide {
            max-width: 100%;
            margin: 0;
            width: 100%;
        }

        .card h2 {
            color: var(--navy);
            font-size: 18px;
            margin-bottom: 16px;
        }

        /* ===== Form ===== */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: var(--navy);
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            font-family: inherit;
            background: #fff;
        }

        .form-control:focus {
            border-color: var(--navy);
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon .form-control {
            padding-right: 50px;
        }

        .input-with-icon .icon-btn {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--navy);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 6px 10px;
            cursor: pointer;
            font-size: 16px;
        }

        .input-with-icon .icon-btn:hover {
            background: var(--navy-light);
        }

        /* ===== Button ===== */
        .btn {
            display: inline-block;
            padding: 8px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: var(--navy);
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn:hover {
            background: var(--navy-light);
            color: #fff;
        }

        .btn-primary {
            background: var(--navy);
        }

        .btn-primary:hover {
            background: var(--navy-light);
        }

        .btn-secondary {
            background: #6b7280;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .btn-danger {
            background: #dc2626;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn-group {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 24px;
        }

        /* ===== Table ===== */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th {
            color: var(--navy);
            text-align: left;
            padding: 14px 12px;
            border-bottom: 2px solid #e5e7eb;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }

        td {
            padding: 14px 12px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #374151;
            vertical-align: middle;
        }

        td.col-nama {
            min-width: 280px;
            max-width: 380px;
        }

        td.col-aksi {
            white-space: nowrap;
            text-align: center;
            min-width: 180px;
        }

        .aksi-group {
            display: inline-flex;
            gap: 8px;
            align-items: center;
            justify-content: center;
        }

        .aksi-group .btn {
            padding: 6px 14px;
            font-size: 12px;
            white-space: nowrap;
        }

        /* ===== Badge ===== */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-draft {
            background: #e5e7eb;
            color: #374151;
        }

        .badge-submitted {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-perlu-revisi {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-terverifikasi {
            background: #dcfce7;
            color: #166534;
        }

        .badge-verif-ulang {
            background: #fde68a;
            color: #78350f;
        }

        /* ===== Alert ===== */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .alert-info {
            background: #dbeafe;
            color: #1e40af;
        }

        /* ===== Info Box ===== */
        .info-box {
            background: #f0f9ff;
            border-left: 4px solid var(--navy);
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 13px;
            color: #1e40af;
            margin-top: 20px;
        }

        /* ===== Page Header ===== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-header h1 {
            margin: 0;
        }

        /* ===== Override <code> ===== */
        code {
            color: #111 !important;
            background: transparent !important;
            padding: 0 !important;
            font-size: inherit;
            font-family: 'Poppins', 'Segoe UI', Tahoma, sans-serif;
        }

        .empty-row {
            text-align: center;
            color: #9ca3af;
            padding: 20px;
        }

        /* ===== Responsive ===== */
        @media (max-width: 992px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                position: static;
                width: 100%;
                height: auto;
                overflow-y: visible;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .content {
                padding: 20px 16px;
            }
        }

        /* ===== Verifikasi / Detail ===== */
        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 16px;
        }

        .info-item label {
            color: #6b7280;
            font-size: 12px;
            display: block;
            margin-bottom: 4px;
        }

        .info-item span {
            color: var(--navy);
            font-size: 15px;
            font-weight: 600;
        }

        .section-title {
            color: var(--navy);
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .variabel-item {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
        }

        .variabel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .variabel-name {
            color: var(--navy);
            font-weight: 700;
            font-size: 15px;
        }

        .variabel-tingkat {
            background: #dcfce7;
            color: #166534;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .variabel-skor {
            color: #16a34a;
            font-weight: 700;
            font-size: 15px;
        }

        .variabel-indikator {
            color: #374151;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .variabel-bukti {
            background: #f0f9ff;
            padding: 10px;
            border-radius: 6px;
            font-size: 13px;
            border-left: 3px solid var(--navy);
        }

        .variabel-bukti a {
            color: var(--navy);
            text-decoration: none;
            word-break: break-all;
        }

        .catatan-lama {
            background: #fef3c7;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            color: #92400e;
            margin-top: 8px;
            border-left: 3px solid #f59e0b;
        }

        textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 13px;
            font-family: inherit;
            outline: none;
            resize: vertical;
            min-height: 60px;
        }

        textarea:focus {
            border-color: var(--navy);
        }

        .btn-success {
            background: #16a34a;
        }

        .btn-success:hover {
            background: #15803d;
        }

        .btn-warning {
            background: #f59e0b;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .action-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-top: 16px;
        }

        /* ===== Filter Card ===== */
        .filter-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .filter-row {
            display: flex;
            gap: 16px;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .filter-group label {
            color: var(--navy);
            font-size: 13px;
            font-weight: 600;
        }

        .filter-group select {
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            min-width: 180px;
            background: #fff;
            font-family: inherit;
        }

        .filter-group select:focus {
            border-color: var(--navy);
        }

        .btn-filter {
            background: var(--navy);
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
        }

        .btn-filter:hover {
            background: var(--navy-light);
        }

        .btn-reset {
            background: #fff;
            color: var(--navy);
            border: 1px solid var(--navy);
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-reset:hover {
            background: #f0f4f8;
        }

        /* ===== Form ===== */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: var(--navy);
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            font-family: inherit;
            background: #fff;
        }

        .form-control:focus {
            border-color: var(--navy);
        }

        /* ===== Info Box ===== */
        .info-box {
            background: #f0f9ff;
            border-left: 4px solid var(--navy);
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 13px;
            color: #1e40af;
            margin-top: 20px;
        }

        /* ===== Alert ===== */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .alert-info {
            background: #dbeafe;
            color: #1e40af;
        }

        /* ===== Input with icon (toggle password) ===== */
        .input-with-icon {
            position: relative;
        }

        .input-with-icon .form-control {
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.6;
        }

        .toggle-password:hover {
            opacity: 1;
        }

        .toggle-password.aktif svg {
            stroke: #dc2626;
        }

        /* ===== Radio Group ===== */
        .radio-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 8px;
        }

        .radio-option {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 18px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            background: #fff;
        }

        .radio-option:hover {
            border-color: #93c5fd;
            background: #f9fafb;
        }

        .radio-option input[type="radio"] {
            margin-top: 2px;
            width: 18px;
            height: 18px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .radio-option:has(input[type="radio"]:checked) {
            border-color: var(--navy);
            background: #f0f7ff;
        }

        .radio-option:has(input[type="radio"]:checked) .radio-label strong {
            color: var(--navy);
        }

        .radio-label {
            flex: 1;
        }

        .radio-label strong {
            color: #374151;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.5;
        }
    </style>
</head>

<body>

    <div class="layout">
        <?= $this->include('App\Modules\Shared\Views\Components\sidebar_admin') ?>

        <main class="content">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/js/bootstrap.bundle.min.js"></script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>
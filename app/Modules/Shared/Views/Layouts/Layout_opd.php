<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard OPD' ?></title>

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

        .subtitle {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 24px;
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
            margin: 0 auto 20px auto;
        }

        .card-wide {
            max-width: 100%;
            margin: 0 0 20px 0;
        }

        .card h2 {
            color: var(--navy);
            font-size: 18px;
            margin-bottom: 16px;
        }

        /* ===== Progress Steps ===== */
        .steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-top: 20px;
        }

        .steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 12%;
            right: 12%;
            height: 2px;
            background: #e5e7eb;
            z-index: 0;
        }

        .step {
            position: relative;
            z-index: 1;
            text-align: center;
            flex: 1;
        }

        .step .circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e5e7eb;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            font-weight: 700;
            font-size: 16px;
        }

        .step.aktif .circle {
            background: var(--navy);
            color: #fff;
        }

        .step.selesai .circle {
            background: #16a34a;
            color: #fff;
        }

        .step .title {
            font-size: 14px;
            font-weight: 700;
            color: #6b7280;
        }

        .step.aktif .title {
            color: var(--navy);
        }

        .step.selesai .title {
            color: #16a34a;
        }

        .step .desc {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 4px;
        }

        /* ===== Button ===== */
        .btn {
            display: inline-block;
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
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

        .btn-warning {
            background: #f59e0b;
        }

        .btn-warning:hover {
            background: #d97706;
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

        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 20px;
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
            background: #fef3c7;
            color: #92400e;
            border-left: 4px solid var(--gold);
        }

        .alert-warning {
            background: #fef3c7;
            color: #92400e;
            border-left: 4px solid #f59e0b;
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

        /* ===== Filter (opsional) ===== */
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

        /* ===== Empty row ===== */
        .empty-row {
            text-align: center;
            color: #9ca3af;
            padding: 30px;
            font-size: 0.9rem;
        }

        /* ===== Override <code> ===== */
        code {
            color: #111 !important;
            background: transparent !important;
            padding: 0 !important;
            font-size: inherit;
            font-family: 'Poppins', 'Segoe UI', Tahoma, sans-serif;
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

        /* ===== Card OPD Header ===== */
        .opd-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .opd-name {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .opd-icon {
            width: 60px;
            height: 60px;
            background: #dbeafe;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .opd-name-text {
            color: var(--navy);
            font-size: 20px;
            font-weight: 700;
        }

        .badge-aktif {
            background: var(--navy);
            color: #fff;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        /* ===== Progress Bar ===== */
        .progress-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .progress-row strong {
            color: var(--navy);
            font-size: 20px;
        }

        .progress-row span {
            color: var(--navy);
            font-weight: 700;
            font-size: 18px;
        }

        .progress-bar {
            background: #e5e7eb;
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .progress-bar .fill {
            background: var(--navy);
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s;
        }

        /* ===== Tabs ===== */
        .tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 16px;
        }

        .tab-btn {
            padding: 8px 20px;
            border: 1px solid #d1d5db;
            border-radius: 24px;
            background: #fff;
            color: #374151;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: inherit;
        }

        .tab-btn:hover {
            border-color: var(--navy);
        }

        .tab-btn.active {
            background: var(--navy);
            color: #fff;
            border-color: var(--navy);
        }

        .tab-btn .dot {
            width: 14px;
            height: 14px;
            border: 2px solid #d1d5db;
            border-radius: 50%;
            display: inline-block;
            background: #fff;
        }

        .tab-btn.active .dot {
            border-color: var(--gold);
        }

        .tab-btn.terisi .dot {
            background: #16a34a;
            border-color: #16a34a;
        }

        /* ===== Action Row ===== */
        .action-row {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-bottom: 24px;
        }

        /* ===== Button Outline ===== */
        .btn-outline {
            background: #fff;
            color: var(--navy);
            border: 1px solid var(--navy);
        }

        .btn-outline:hover {
            background: #f0f4f8;
            color: var(--navy);
        }

        /* ===== Tingkat Card ===== */
        .tingkat-card {
            background: #fff;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .tingkat-card:hover {
            border-color: #93c5fd;
        }

        .tingkat-card.selected {
            border-color: var(--navy);
            background: #f0f7ff;
        }

        .tingkat-header {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .tingkat-header input[type="radio"] {
            margin-top: 4px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .tingkat-body {
            flex: 1;
        }

        .tingkat-title {
            color: var(--navy);
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 6px;
        }

        .tingkat-indikator {
            color: #374151;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .tingkat-verifikasi {
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
            font-size: 13px;
            color: #6b7280;
            font-style: italic;
        }

        .tingkat-verifikasi strong {
            color: #9ca3af;
            font-weight: 600;
            display: block;
            margin-bottom: 4px;
            font-style: normal;
        }

        /* ===== Bukti Field ===== */
        .bukti-field {
            margin-top: 12px;
            padding: 12px;
            border: 1px dashed #93c5fd;
            border-radius: 8px;
            background: #f9fafb;
        }

        .bukti-field label {
            display: block;
            font-size: 13px;
            color: var(--navy);
            font-weight: 600;
            margin-bottom: 6px;
        }

        .bukti-field input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            font-family: inherit;
        }

        .bukti-field input:focus {
            border-color: var(--navy);
        }

        /* ===== Variabel Panel ===== */
        .variabel-panel {
            display: none;
        }

        .variabel-panel.active {
            display: block;
        }

        .variabel-title {
            color: var(--navy);
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .simpan-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        /* ===== Catatan Revisi Box ===== */
        .catatan-revisi-box {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .catatan-revisi-box strong {
            color: #92400e;
            display: block;
            margin-bottom: 4px;
        }

        .catatan-revisi-box span {
            color: #78350f;
            font-size: 14px;
        }

        /* ===== Status Badge ===== */
        .status-badge {
            background: #fef3c7;
            color: #92400e;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        .status-badge.draft {
            background: #e5e7eb;
            color: #374151;
        }

        .status-badge.dikirim {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-badge.terverifikasi {
            background: #dcfce7;
            color: #166534;
        }

        .status-badge.perlurevisi {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-badge.perluverifikasiulang {
            background: #fef3c7;
            color: #92400e;
        }

        /* ===== Nilai Akhir ===== */
        .nilai-akhir {
            text-align: center;
            padding: 32px 0;
        }

        .nilai-akhir .label {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 8px;
        }

        .nilai-akhir .value {
            color: var(--navy);
            font-size: 72px;
            font-weight: 700;
            line-height: 1;
        }

        .nilai-akhir .kesimpulan {
            display: inline-block;
            padding: 8px 24px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: 700;
            margin-top: 16px;
        }

        /* ===== Kesimpulan Warna ===== */
        .kesimpulan-sangat-rendah {
            background: #fee2e2;
            color: #991b1b;
        }

        .kesimpulan-rendah {
            background: #fed7aa;
            color: #9a3412;
        }

        .kesimpulan-sedang {
            background: #fef3c7;
            color: #92400e;
        }

        .kesimpulan-tinggi {
            background: #dbeafe;
            color: #1e40af;
        }

        .kesimpulan-sangat-tinggi {
            background: #dcfce7;
            color: #166534;
        }

        /* ===== Table Title ===== */
        .table-title {
            color: var(--navy);
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        /* ===== Skor Cell ===== */
        td.skor {
            text-align: right;
            font-weight: 600;
            color: var(--navy);
            width: 80px;
        }

        /* ===== Button Success ===== */
        .btn-success {
            background: #16a34a;
        }

        .btn-success:hover {
            background: #15803d;
        }

        /* ===== Button Outline ===== */
        .btn-outline {
            background: #fff;
            color: var(--navy);
            border: 1px solid var(--navy);
        }

        .btn-outline:hover {
            background: #f0f4f8;
            color: var(--navy);
        }

        /* ===== Button Disabled ===== */
        .btn:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            color: #fff;
        }

        /* Sidebar — menu disabled */
        .sidebar a.disabled {
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
        }

        .sidebar a.disabled:hover {
            background: transparent;
            border-left: 3px solid transparent;
        }

        /* ===== Radio Group (Ekspor Laporan) ===== */
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
        <?= $this->include('App\Modules\Shared\Views\Components\sidebar_opd') ?>

        <main class="content">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>
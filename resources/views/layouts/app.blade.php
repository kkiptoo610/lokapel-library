<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Lokapel School Library</title>


    <!-- Bootstrap CSS -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Bootstrap Icons -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    >


    <style>

        /* ========================================================= */
        /* ROOT COLOURS */
        /* ========================================================= */

        :root {

            --sidebar-dark: #0B1F3A;

            --sidebar-light: #123B6D;

            --sidebar-hover: rgba(255, 255, 255, 0.08);

            --sidebar-active: #2563EB;

            --primary: #2563EB;

            --primary-dark: #1D4ED8;

            --primary-light: #EFF6FF;

            --success: #10B981;

            --success-light: #ECFDF5;

            --warning: #F59E0B;

            --warning-light: #FFFBEB;

            --danger: #EF4444;

            --danger-light: #FEF2F2;

            --purple: #7C3AED;

            --purple-light: #F5F3FF;

            --page-bg: #F4F7FB;

            --card-bg: #FFFFFF;

            --text-dark: #1E293B;

            --text-muted: #64748B;

            --border: #E2E8F0;

        }


        /* ========================================================= */
        /* BODY */
        /* ========================================================= */

        body {

            margin: 0;

            background:
                linear-gradient(
                    180deg,
                    #F8FAFC 0%,
                    #F4F7FB 100%
                );

            color: var(--text-dark);

            font-family:
                Inter,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

        }


        /* ========================================================= */
        /* MOBILE MENU BUTTON */
        /* ========================================================= */

        .mobile-menu-button {

            display: none;

        }


        /* ========================================================= */
        /* MOBILE OVERLAY */
        /* ========================================================= */

        .sidebar-overlay {

            display: none;

        }


        /* ========================================================= */
        /* SIDEBAR */
        /* ========================================================= */

        .sidebar {

            width: 260px;

            height: 100vh;

            position: fixed;

            top: 0;

            left: 0;

            display: flex;

            flex-direction: column;

            overflow-y: auto;

            z-index: 1200;

            background:
                linear-gradient(
                    180deg,
                    var(--sidebar-dark),
                    var(--sidebar-light)
                );

            box-shadow:
                8px 0 30px
                rgba(
                    15,
                    23,
                    42,
                    0.12
                );

        }


        /* ========================================================= */
        /* BRAND */
        /* ========================================================= */

        .sidebar .brand {

            padding: 24px 22px;

            color: white;

            font-size: 19px;

            font-weight: 700;

            display: flex;

            align-items: center;

            gap: 12px;

            border-bottom:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    0.08
                );

        }


        .sidebar .brand-icon {

            width: 42px;

            height: 42px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 12px;

            font-size: 21px;

            background:
                linear-gradient(
                    135deg,
                    #3B82F6,
                    #60A5FA
                );

            box-shadow:
                0 8px 20px
                rgba(
                    59,
                    130,
                    246,
                    0.35
                );

        }


        .brand-text {

            display: flex;

            flex-direction: column;

        }


        .brand-text small {

            font-size: 11px;

            opacity: 0.65;

            font-weight: 400;

        }


        /* ========================================================= */
        /* SIDEBAR NAVIGATION */
        /* ========================================================= */

        .sidebar-navigation {

            flex: 1;

            padding-bottom: 20px;

        }


        /* ========================================================= */
        /* NAVIGATION LINKS */
        /* ========================================================= */

        .sidebar a {

            color:
                rgba(
                    255,
                    255,
                    255,
                    0.68
                );

            text-decoration: none;

            display: flex;

            align-items: center;

            gap: 13px;

            padding:
                12px 18px;

            margin:
                4px 12px;

            border-radius: 10px;

            font-size: 14px;

            font-weight: 500;

            transition:
                all
                0.25s
                ease;

        }


        .sidebar a i {

            font-size: 18px;

            width: 22px;

            text-align: center;

        }


        .sidebar a:hover {

            background:
                var(--sidebar-hover);

            color: white;

            transform:
                translateX(3px);

        }


        /* ========================================================= */
        /* ACTIVE MENU */
        /* ========================================================= */

        .sidebar a.active {

            background:
                linear-gradient(
                    135deg,
                    #2563EB,
                    #3B82F6
                );

            color: white;

            box-shadow:
                0 8px 20px
                rgba(
                    37,
                    99,
                    235,
                    0.28
                );

        }


        /* ========================================================= */
        /* NAVIGATION HEADINGS */
        /* ========================================================= */

        .nav-section {

            font-size: 10px;

            font-weight: 700;

            letter-spacing: 1px;

            text-transform: uppercase;

            color:
                rgba(
                    255,
                    255,
                    255,
                    0.35
                );

            padding:
                24px 22px
                8px;

        }


        /* ========================================================= */
        /* USER ACCOUNT */
        /* ========================================================= */

        .user-account-section {

            padding:
                15px 12px;

            border-top:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    0.08
                );

        }


        .user-account {

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 12px;

            border-radius: 12px;

            background:
                rgba(
                    255,
                    255,
                    255,
                    0.06
                );

        }


        .user-avatar {

            width: 42px;

            height: 42px;

            min-width: 42px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            color: white;

            font-size: 19px;

            background:
                linear-gradient(
                    135deg,
                    #2563EB,
                    #60A5FA
                );

        }


        .user-details {

            min-width: 0;

            display: flex;

            flex-direction: column;

        }


        .user-name {

            color: white;

            font-size: 14px;

            font-weight: 600;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;

        }


        .user-role {

            margin-top: 2px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    0.55
                );

            font-size: 11px;

        }


        /* ========================================================= */
        /* LOGOUT */
        /* ========================================================= */

        .logout-section {

            padding:
                0 12px
                20px;

        }


        .logout-form {

            margin: 0;

        }


        .logout-button {

            width: calc(100% - 24px);

            margin: 0 12px;

            border: none;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 10px;

            padding:
                12px 18px;

            border-radius: 10px;

            font-size: 14px;

            font-weight: 600;

            color: #FCA5A5;

            background:
                rgba(
                    239,
                    68,
                    68,
                    0.10
                );

            cursor: pointer;

            transition:
                all
                0.25s
                ease;

        }


        .logout-button i {

            font-size: 18px;

        }


        .logout-button:hover {

            color: white;

            background:
                linear-gradient(
                    135deg,
                    #DC2626,
                    #EF4444
                );

            transform:
                translateY(-2px);

            box-shadow:
                0 8px 20px
                rgba(
                    239,
                    68,
                    68,
                    0.25
                );

        }


        /* ========================================================= */
        /* MAIN CONTENT */
        /* ========================================================= */

        .content {

            margin-left: 260px;

            min-height: 100vh;

            padding: 35px;

        }


        /* ========================================================= */
        /* PAGE HEADER */
        /* ========================================================= */

        .page-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 28px;

        }


        .page-title {

            display: flex;

            align-items: center;

            gap: 14px;

        }


        .page-title-icon {

            width: 52px;

            height: 52px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 15px;

            font-size: 23px;

            color: var(--primary);

            background:
                var(--primary-light);

        }


        .page-title h1 {

            margin: 0;

            font-size: 27px;

            font-weight: 700;

            color: var(--text-dark);

        }


        .page-title p {

            margin:
                4px 0 0;

            color:
                var(--text-muted);

        }


        /* ========================================================= */
        /* CARDS */
        /* ========================================================= */

        .modern-page-card {

            background: white;

            border:
                1px solid
                rgba(
                    226,
                    232,
                    240,
                    0.8
                );

            border-radius: 18px;

            box-shadow:
                0 10px 30px
                rgba(
                    15,
                    23,
                    42,
                    0.04
                );

            overflow: hidden;

        }


        .modern-page-card .card-body {

            padding: 25px;

        }


        /* ========================================================= */
        /* SEARCH CARD */
        /* ========================================================= */

        .search-card {

            background:
                linear-gradient(
                    135deg,
                    #FFFFFF,
                    #F8FBFF
                );

        }


        /* ========================================================= */
        /* FORM CONTROLS */
        /* ========================================================= */

        .form-control,
        .form-select {

            border-radius: 10px;

            border:
                1px solid
                var(--border);

            min-height: 46px;

            box-shadow: none;

        }


        .form-control:focus,
        .form-select:focus {

            border-color:
                var(--primary);

            box-shadow:
                0 0 0 4px
                rgba(
                    37,
                    99,
                    235,
                    0.10
                );

        }


        /* ========================================================= */
        /* BUTTONS */
        /* ========================================================= */

        .btn {

            border-radius: 10px;

            font-weight: 600;

            padding:
                9px 16px;

            transition:
                all
                0.2s
                ease;

        }


        .btn-primary {

            border: none;

            background:
                linear-gradient(
                    135deg,
                    #2563EB,
                    #3B82F6
                );

        }


        .btn-primary:hover {

            transform:
                translateY(-2px);

        }


        .btn-success {

            background:
                linear-gradient(
                    135deg,
                    #059669,
                    #10B981
                );

            border: none;

        }


        .btn-warning {

            background: #F59E0B;

            border: none;

            color: white;

        }


        .btn-danger {

            background:
                linear-gradient(
                    135deg,
                    #DC2626,
                    #EF4444
                );

            border: none;

        }


        /* ========================================================= */
        /* TABLE */
        /* ========================================================= */

        .modern-table {

            margin-bottom: 0;

        }


        .modern-table thead {

            background: #F8FAFC;

        }


        .modern-table th {

            color: var(--text-muted);

            font-size: 12px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: 0.4px;

            border: none;

            padding: 16px;

        }


        .modern-table td {

            padding: 16px;

            border-color: #F1F5F9;

            color: #334155;

        }


        .modern-table tbody tr:hover {

            background: #F8FBFF;

        }


        /* ========================================================= */
        /* BADGES */
        /* ========================================================= */

        .badge-soft-primary {

            background: #EFF6FF;

            color: #2563EB;

            padding: 7px 11px;

            border-radius: 20px;

        }


        .badge-soft-success {

            background: #ECFDF5;

            color: #059669;

            padding: 7px 11px;

            border-radius: 20px;

        }


        .badge-soft-warning {

            background: #FFFBEB;

            color: #D97706;

            padding: 7px 11px;

            border-radius: 20px;

        }


        .badge-soft-danger {

            background: #FEF2F2;

            color: #DC2626;

            padding: 7px 11px;

            border-radius: 20px;

        }


        .badge-soft-purple {

            background: #F5F3FF;

            color: #7C3AED;

            padding: 7px 11px;

            border-radius: 20px;

        }


        /* ========================================================= */
        /* ACTION BUTTONS */
        /* ========================================================= */

        .action-btn {

            width: 34px;

            height: 34px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            border-radius: 9px;

            border: none;

            margin-left: 3px;

        }


        .action-view {

            background: #EFF6FF;

            color: #2563EB;

        }


        .action-edit {

            background: #FFFBEB;

            color: #D97706;

        }


        .action-delete {

            background: #FEF2F2;

            color: #DC2626;

        }


        .action-view:hover {

            background: #2563EB;

            color: white;

        }


        .action-edit:hover {

            background: #F59E0B;

            color: white;

        }


        .action-delete:hover {

            background: #EF4444;

            color: white;

        }


        /* ========================================================= */
        /* ALERTS */
        /* ========================================================= */

        .alert {

            border: none;

            border-radius: 14px;

            padding: 16px 20px;

        }


        /* ========================================================= */
        /* TABLET */
        /* ========================================================= */

        @media (max-width: 992px) and (min-width: 769px) {

            .sidebar {

                width: 220px;

            }


            .content {

                margin-left: 220px;

                padding: 25px;

            }

        }


        /* ========================================================= */
        /* MOBILE */
        /* ========================================================= */

        @media (max-width: 768px) {

            .mobile-menu-button {

                display: flex;

                position: fixed;

                top: 15px;

                left: 15px;

                width: 48px;

                height: 48px;

                align-items: center;

                justify-content: center;

                border: none;

                border-radius: 12px;

                color: white;

                background:
                    var(--sidebar-dark);

                box-shadow:
                    0 8px 20px
                    rgba(
                        15,
                        23,
                        42,
                        0.25
                    );

                z-index: 1300;

                font-size: 25px;

                cursor: pointer;

            }


            .sidebar {

                position: fixed;

                top: 0;

                left: -280px;

                width: 260px;

                height: 100vh;

                min-height: 100vh;

                transition:
                    left
                    0.3s
                    ease;

            }


            .sidebar.mobile-open {

                left: 0;

            }


            .sidebar-overlay {

                position: fixed;

                top: 0;

                left: 0;

                width: 100%;

                height: 100%;

                background:
                    rgba(
                        15,
                        23,
                        42,
                        0.5
                    );

                z-index: 1150;

            }


            .sidebar-overlay.active {

                display: block;

            }


            .content {

                margin-left: 0;

                width: 100%;

                padding:
                    80px
                    15px
                    20px;

            }


            .page-header {

                flex-direction: column;

                align-items: flex-start;

                gap: 15px;

            }


            .page-title {

                padding-left: 48px;

            }


            .page-title h1 {

                font-size: 22px;

            }


            .page-title-icon {

                width: 45px;

                height: 45px;

                font-size: 20px;

            }


            .modern-page-card {

                border-radius: 14px;

            }


            .modern-page-card .card-body {

                padding: 15px;

            }


            .table-responsive {

                border-radius: 12px;

            }

        }

    </style>

</head>


<body>


<!-- ========================================================= -->
<!-- MOBILE MENU BUTTON -->
<!-- ========================================================= -->

<button
    type="button"
    class="mobile-menu-button"
    id="mobileMenuButton"
    aria-label="Open menu"
>

    <i class="bi bi-list"></i>

</button>


<!-- ========================================================= -->
<!-- MOBILE OVERLAY -->
<!-- ========================================================= -->

<div
    class="sidebar-overlay"
    id="sidebarOverlay"
></div>


<!-- ========================================================= -->
<!-- SIDEBAR -->
<!-- ========================================================= -->

<div
    class="sidebar"
    id="sidebar"
>


    <!-- BRAND -->

    <div class="brand">

        <div class="brand-icon">

            <i class="bi bi-book-half"></i>

        </div>


        <div class="brand-text">

            Lokapel Library

            <small>

                Library Management System

            </small>

        </div>

    </div>


    <!-- ========================================================= -->
    <!-- NAVIGATION -->
    <!-- ========================================================= -->

    <div class="sidebar-navigation">


        <a
            href="{{ route('dashboard') }}"
            class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
        >

            <i class="bi bi-grid-1x2-fill"></i>

            Dashboard

        </a>


        <div class="nav-section">

            Library Management

        </div>


        <a
            href="{{ route('categories.index') }}"
            class="{{ request()->routeIs('categories.*') ? 'active' : '' }}"
        >

            <i class="bi bi-tags"></i>

            Categories

        </a>


        <a
            href="{{ route('books.index') }}"
            class="{{ request()->routeIs('books.*') ? 'active' : '' }}"
        >

            <i class="bi bi-book-half"></i>

            Books

        </a>


        <div class="nav-section">

            Borrowers

        </div>


        <a
            href="{{ route('teachers.index') }}"
            class="{{ request()->routeIs('teachers.*') ? 'active' : '' }}"
        >

            <i class="bi bi-person-workspace"></i>

            Teachers

        </a>


        <a
            href="{{ route('staff.index') }}"
            class="{{ request()->routeIs('staff.*') ? 'active' : '' }}"
        >

            <i class="bi bi-person-badge"></i>

            Staff

        </a>


        <a
            href="{{ route('learners.index') }}"
            class="{{ request()->routeIs('learners.*') ? 'active' : '' }}"
        >

            <i class="bi bi-mortarboard"></i>

            Learners

        </a>


        <div class="nav-section">

            Transactions

        </div>


        <a
            href="{{ route('borrowings.index') }}"
            class="{{ request()->routeIs('borrowings.index') || request()->routeIs('borrowings.show') ? 'active' : '' }}"
        >

            <i class="bi bi-arrow-left-right"></i>

            Borrowings

        </a>


        <a
            href="{{ route('borrowings.create') }}"
            class="{{ request()->routeIs('borrowings.create') ? 'active' : '' }}"
        >

            <i class="bi bi-plus-circle"></i>

            Issue Book

        </a>


        <a
            href="{{ route('reports.index') }}"
            class="{{ request()->routeIs('reports.*') ? 'active' : '' }}"
        >

            <i class="bi bi-bar-chart-line"></i>

            Reports

        </a>


        <div class="nav-section">

            Account

        </div>


        <a
            href="{{ route('password.change') }}"
            class="{{ request()->routeIs('password.change') ? 'active' : '' }}"
        >

            <i class="bi bi-key-fill"></i>

            Change Password

        </a>


    </div>


    <!-- ========================================================= -->
    <!-- CURRENT USER -->
    <!-- ========================================================= -->

    @auth

        <div class="user-account-section">

            <div class="user-account">


                <div class="user-avatar">

                    <i class="bi bi-person-fill"></i>

                </div>


                <div class="user-details">

                    <div class="user-name">

                        {{ auth()->user()->name }}

                    </div>


                    <div class="user-role">

                        Librarian Account

                    </div>

                </div>


            </div>

        </div>


        <!-- LOGOUT -->

        <div class="logout-section">

            <form
                action="{{ route('logout') }}"
                method="POST"
                class="logout-form"
                onsubmit="return confirm('Are you sure you want to log out?');"
            >

                @csrf


                <button
                    type="submit"
                    class="logout-button"
                >

                    <i class="bi bi-box-arrow-right"></i>

                    Logout

                </button>


            </form>

        </div>

    @endauth


</div>


<!-- ========================================================= -->
<!-- MAIN CONTENT -->
<!-- ========================================================= -->

<div class="content">


    <!-- SUCCESS MESSAGE -->

    @if(session('success'))

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}


            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    <!-- ERROR MESSAGE -->

    @if(session('error'))

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >

            <i class="bi bi-exclamation-circle-fill me-2"></i>

            {{ session('error') }}


            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    <!-- PAGE CONTENT -->

    @yield('content')


</div>


<!-- ========================================================= -->
<!-- BOOTSTRAP JAVASCRIPT -->
<!-- ========================================================= -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


<!-- ========================================================= -->
<!-- MOBILE SIDEBAR JAVASCRIPT -->
<!-- ========================================================= -->

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const menuButton =
                document.getElementById(
                    'mobileMenuButton'
                );


            const sidebar =
                document.getElementById(
                    'sidebar'
                );


            const overlay =
                document.getElementById(
                    'sidebarOverlay'
                );


            function openSidebar() {

                sidebar.classList.add(
                    'mobile-open'
                );


                overlay.classList.add(
                    'active'
                );

            }


            function closeSidebar() {

                sidebar.classList.remove(
                    'mobile-open'
                );


                overlay.classList.remove(
                    'active'
                );

            }


            if (menuButton) {

                menuButton.addEventListener(
                    'click',
                    function () {

                        if (
                            sidebar.classList.contains(
                                'mobile-open'
                            )
                        ) {

                            closeSidebar();

                        } else {

                            openSidebar();

                        }

                    }
                );

            }


            if (overlay) {

                overlay.addEventListener(
                    'click',
                    closeSidebar
                );

            }


            if (sidebar) {

                sidebar
                    .querySelectorAll('a')
                    .forEach(
                        function (link) {

                            link.addEventListener(
                                'click',
                                function () {

                                    if (
                                        window.innerWidth <= 768
                                    ) {

                                        closeSidebar();

                                    }

                                }
                            );

                        }
                    );

            }

        }
    );

</script>


</body>

</html>
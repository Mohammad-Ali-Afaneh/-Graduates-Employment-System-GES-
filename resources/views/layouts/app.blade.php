<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Tajawal', sans-serif;
            color: #1e3a8a;
            background: linear-gradient(135deg, #1e3a8a 0%, #e5e7eb 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }
        .navbar {
            background: #1e3a8a;
            padding: 0.8rem 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .navbar-brand:hover {
            color: #facc15;
        }
        .nav-link {
            color: #fff;
            font-size: 0.95rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: background 0.3s ease, color 0.3s ease;
        }
        .nav-link:hover {
            background: #facc15;
            color: #1e3a8a;
        }
        .btn-logout {
            background: #facc15;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            color: #1e3a8a;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.3s ease;
        }
        .btn-logout:hover {
            background: #eab308;
            transform: translateY(-2px);
        }
        .main-container {
            padding: 2rem;
            min-height: calc(100vh - 60px);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        [data-aos] {
            opacity: 0;
            transition: all 0.6s ease;
        }
        [data-aos].aos-animate {
            opacity: 1;
        }
        .dropdown-menu {
            background: #1e3a8a;
            border: none;
            border-radius: 8px;
            padding: 0;
            min-width: 10rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .dropdown-item {
            color: #fff;
            padding: 0.5rem 1rem;
            font-size: 0.95rem;
            transition: background 0.3s ease;
        }
        .dropdown-item:hover {
            background: #facc15;
            color: #1e3a8a;
        }
        @media (max-width: 768px) {
            .navbar {
                padding: 0.5rem 1rem;
            }
            .navbar-brand {
                font-size: 1.3rem;
            }
            .nav-link {
                font-size: 0.85rem;
                padding: 0.4rem 0.8rem;
            }
            .main-container {
                padding: 1rem;
            }
            .dropdown-menu {
                min-width: 8rem;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar">
        @if (!in_array(request()->route()->getName(), ['company.login', 'student.login', 'company.register', 'student.register']))
            <a class="navbar-brand" href="{{ Auth::guard('company')->check() ? route('company.home') : (Auth::guard('student')->check() ? route('student.home') : route('home')) }}">
                <i class="bi bi-briefcase-fill me-2"></i> منصة التوظيف
            </a>
        @endif
        <div class="navbar-nav d-flex flex-row gap-3">
            @if (Auth::guard('company')->check())
              <a class="nav-link" href="{{ route('company.create-request') }}"><i class="bi bi-plus-circle me-1"></i> عرض وظيفة </a>
              <a class="nav-link" href="{{ route('company.receive-request') }}"> اعلانات الوظائف </a>
              <a class="nav-link" href="{{ route('company.employees') }}"><i class="bi bi-people-fill me-1"></i> ردود الطلاب </a>
                <form method="POST" action="{{ route('company.logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-right me-1"></i> خروج</button>
                </form>
            @elseif (Auth::guard('student')->check())
                <a class="nav-link" href="{{ route('student.approved-request') }}"><i class="bi bi-plus-circle me-1"></i> وظائف مطروحه </a>
                <a class="nav-link" href="{{ route('student.profile') }}"><i class="bi bi-person-fill me-1"></i> الملف</a>
                <form method="POST" action="{{ route('student.logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-right me-1"></i> خروج</button>
                </form>
            @elseif (Auth::check())
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-right me-1"></i> خروج</button>
                </form>
            @endif
        </div>
    </nav>
    <div class="main-container">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
        });
    </script>
    @yield('scripts')
</body>
</html>
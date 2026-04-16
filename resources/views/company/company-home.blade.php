@extends('layouts.app')

@section('title', 'الصفحة الرئيسية للشركات')

@section('styles')
    <style>
        .header-section {
            text-align: center;
            padding: 2rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .header-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e3a8a;
            position: relative;
            display: inline-block;
        }

        .header-section h1::after {
            content: '';
            width: 50%;
            height: 3px;
            background: #facc15;
            position: absolute;
            bottom: -5px;
            left: 25%;
        }

        .stats-grid {
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 1rem;
            margin: 2rem 0;
        }

        .stat-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 500px;
            width: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .stat-card h3 {
            font-size: 1.8rem;
            color: #1e3a8a;
            margin-bottom: 0.5rem;
        }

        .stat-card p {
            font-size: 0.95rem;
            color: #6b7280;
        }

        .filter-section {
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .filter-section select {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.5rem;
            padding-right: 2.5rem;
            transition: border-color 0.3s ease;
            direction: rtl;
            text-align: right;
            background-position: left 0.75rem center;
            background-size: 16px 12px;
        }

        .filter-section select:focus {
            border-color: #facc15;
            outline: none;
        }

        .filter-section select option {
            padding-right: 1rem;
        }

        .filter-section .btn {
            background: #facc15;
            color: #1e3a8a;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .filter-section .btn:hover {
            background: #eab308;
            transform: translateY(-2px);
        }

        .students-grid {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: center;
        }

        .student-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .student-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .student-card p {
            margin: 0.5rem 0;
            color: #6b7280;
            font-size: 0.95rem;
        }

        .student-card p strong {
            color: #1e3a8a;
            font-weight: 600;
        }

        .student-card .btn {
            background: #facc15;
            color: #1e3a8a;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .student-card .btn:hover {
            background: #eab308;
            transform: translateY(-2px);
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
            gap: 0.5rem;
        }

        .pagination .page-item {
            margin: 0 0.2rem;
        }

        .pagination .page-link {
            background-color: #fff;
            border: 1px solid #e5e7eb;
            color: #1e3a8a;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: background 0.3s ease, color 0.3s ease, transform 0.3s ease;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .pagination .page-link:hover {
            background-color: #facc15;
            color: #fff;
            transform: translateY(-2px);
        }

        .pagination .page-item.active .page-link {
            background-color: #facc15;
            border-color: #facc15;
            color: #1e3a8a;
        }

        .pagination .page-item.disabled .page-link {
            background-color: #e5e7eb;
            color: #6b7280;
            cursor: not-allowed;
        }

        .pagination .page-link i {
            font-size: 1.2rem;
        }

        .alert-danger {
            background: #fee2e2;
            color: #dc2626;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        @media (max-width: 768px) {
            .header-section h1 {
                font-size: 2rem;
            }
            .stats-grid {
                flex-direction: row;
                align-items: center;
            }
            .stat-card {
                max-width: 100%;
            }
            .students-grid {
                grid-template-columns: 1fr;
            }
            .filter-section {
                padding: 1rem;
            }
            .pagination .page-link {
                padding: 0.4rem 0.8rem;
                font-size: 0.9rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="header-section" data-aos="fade-up">
        <h1><i class="bi bi-briefcase-fill me-2"></i> منصة الشركات</h1>
    </div>

    <div class="stats-grid" data-aos="fade-up" data-aos-delay="100">
        @if (isset($students) && $students->isNotEmpty())
            <div class="stat-card">
                <h3>{{ $students->total() }}</h3>
                <p>عدد الطلاب</p>
            </div>
            <div class="stat-card">
                <h3>{{ $students->avg('score') ? number_format($students->avg('score'), 2) : 'غير متوفر' }}</h3>
                <p>متوسط المعدل</p>
            </div>
        @else
            <div class="stat-card">
                <h3>0</h3>
                <p>عدد الطلاب</p>
            </div>
            <div class="stat-card">
                <h3>غير متوفر</h3>
                <p>متوسط المعدل</p>
            </div>
        @endif
    </div>

    <div class="filter-section" data-aos="fade-right">
        <form id="filter-form" method="GET" action="{{ route('company.home') }}">
            <div class="row g-3">
                <div class="col-md-5">
                    <label for="specialization" class="form-label">التخصص</label>
                    <select name="specialization" id="specialization" class="form-select">
                        <option value="">اختر التخصص</option>
                        <option value="علوم الحاسوب" {{ request('specialization') == 'علوم الحاسوب' ? 'selected' : '' }}>علوم الحاسوب</option>
                        <option value="هندسة البرمجيات" {{ request('specialization') == 'هندسة البرمجيات' ? 'selected' : '' }}>هندسة البرمجيات</option>
                        <option value="نظم المعلومات" {{ request('specialization') == 'نظم المعلومات' ? 'selected' : '' }}>نظم المعلومات</option>
                        <option value="الأمن السيبراني" {{ request('specialization') == 'الأمن السيبراني' ? 'selected' : '' }}>الأمن السيبراني</option>
                        <option value="تحليل البيانات" {{ request('specialization') == 'تحليل البيانات' ? 'selected' : '' }}>تحليل البيانات</option>
                        <option value="تطوير الويب" {{ request('specialization') == 'تطوير الويب' ? 'selected' : '' }}>تطوير الويب</option>
                        <option value="الذكاء الاصطناعي" {{ request('specialization') == 'الذكاء الاصطناعي' ? 'selected' : '' }}>الذكاء الاصطناعي</option>
                        <option value="إدارة قواعد البيانات" {{ request('specialization') == 'إدارة قواعد البيانات' ? 'selected' : '' }}>إدارة قواعد البيانات</option>
                        <option value="هندسة الشبكات" {{ request('specialization') == 'هندسة الشبكات' ? 'selected' : '' }}>هندسة الشبكات</option>
                        <option value="تطوير تطبيقات الهواتف الذكية" {{ request('specialization') == 'تطوير تطبيقات الهواتف الذكية' ? 'selected' : '' }}>تطوير تطبيقات الهواتف الذكية</option>
                        <option value="علوم البيانات" {{ request('specialization') == 'علوم البيانات' ? 'selected' : '' }}>علوم البيانات</option>
                        <option value="الحوسبة السحابية" {{ request('specialization') == 'الحوسبة السحابية' ? 'selected' : '' }}>الحوسبة السحابية</option>
                        <option value="إنترنت الأشياء (IoT)" {{ request('specialization') == 'إنترنت الأشياء (IoT)' ? 'selected' : '' }}>إنترنت الأشياء (IoT)</option>
                        <option value="تطوير الألعاب" {{ request('specialization') == 'تطوير الألعاب' ? 'selected' : '' }}>تطوير الألعاب</option>
                        <option value="الرؤية الحاسوبية" {{ request('specialization') == 'الرؤية الحاسوبية' ? 'selected' : '' }}>الرؤية الحاسوبية</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="programming_language" class="form-label">لغة البرمجة</label>
                    <select name="programming_language" id="programming_language" class="form-select">
                        <option value="">اختر لغة البرمجة</option>
                        <option value="Python" {{ request('programming_language') == 'Python' ? 'selected' : '' }}>Python</option>
                        <option value="Java" {{ request('programming_language') == 'Java' ? 'selected' : '' }}>Java</option>
                        <option value="JavaScript" {{ request('programming_language') == 'JavaScript' ? 'selected' : '' }}>JavaScript</option>
                        <option value="C++" {{ request('programming_language') == 'C++' ? 'selected' : '' }}>C++</option>
                        <option value="C#" {{ request('programming_language') == 'C#' ? 'selected' : '' }}>C#</option>
                        <option value="PHP" {{ request('programming_language') == 'PHP' ? 'selected' : '' }}>PHP</option>
                        <option value="Ruby" {{ request('programming_language') == 'Ruby' ? 'selected' : '' }}>Ruby</option>
                        <option value="Go" {{ request('programming_language') == 'Go' ? 'selected' : '' }}>Go</option>
                        <option value="Swift" {{ request('programming_language') == 'Swift' ? 'selected' : '' }}>Swift</option>
                        <option value="Kotlin" {{ request('programming_language') == 'Kotlin' ? 'selected' : '' }}>Kotlin</option>
                        <option value="TypeScript" {{ request('programming_language') == 'TypeScript' ? 'selected' : '' }}>TypeScript</option>
                        <option value="R" {{ request('programming_language') == 'R' ? 'selected' : '' }}>R</option>
                        <option value="SQL" {{ request('programming_language') == 'SQL' ? 'selected' : '' }}>SQL</option>
                        <option value="Rust" {{ request('programming_language') == 'Rust' ? 'selected' : '' }}>Rust</option>
                        <option value="Scala" {{ request('programming_language') == 'Scala' ? 'selected' : '' }}>Scala</option>
                        <option value="Perl" {{ request('programming_language') == 'Perl' ? 'selected' : '' }}>Perl</option>
                        <option value="MATLAB" {{ request('programming_language') == 'MATLAB' ? 'selected' : '' }}>MATLAB</option>
                        <option value="Dart" {{ request('programming_language') == 'Dart' ? 'selected' : '' }}>Dart</option>
                        <option value="Lua" {{ request('programming_language') == 'Lua' ? 'selected' : '' }}>Lua</option>
                        <option value="Elixir" {{ request('programming_language') == 'Elixir' ? 'selected' : '' }}>Elixir</option>
                        <option value="C" {{ request('programming_language') == 'C' ? 'selected' : '' }}>C</option>
                        <option value="F#" {{ request('programming_language') == 'F#' ? 'selected' : '' }}>F#</option>
                        <option value="Julia" {{ request('programming_language') == 'Julia' ? 'selected' : '' }}>Julia</option>
                        <option value="Solidity" {{ request('programming_language') == 'Solidity' ? 'selected' : '' }}>Solidity</option>
                        <option value="Assembly" {{ request('programming_language') == 'Assembly' ? 'selected' : '' }}>Assembly</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn me-2"><i class="bi bi-filter me-1"></i> فلترة</button>
                </div>
                <a href="{{ route('company.home') }}" class="btn"><i class="bi bi-arrow-clockwise me-1"></i> إعادة تعيين</a>
                <a href="{{ route('clusters.run') }}" class="btn"><i class="bi bi-gear-fill me-1"></i> فلترة متقدمة</a>
            </div>
        </form>
    </div>

    <div class="students-grid" data-aos="fade-up" data-aos-delay="200">
        @if (!isset($students) || $students->isEmpty())
            <p class="text-center text-muted">لا يوجد طلاب مسجلون حاليًا.</p>
        @else
            @foreach ($students as $student)
                <div class="student-card">
                    <p><strong>الاسم:</strong> {{ $student->name }}</p>
                    <p><strong>التخصص:</strong> {{ $student->specialization }}</p>
                    <p><strong>المعدل:</strong> {{ $student->score }}</p>
                    <p><strong>الموقع:</strong> {{ $student->location }}</p>
                    <a href="{{ route('company.student-details', $student->id) }}" class="btn">تفاصيل</a>
                </div>
            @endforeach
        @endif
    </div>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (isset($students) && $students->hasPages())
        <div class="pagination mt-4" data-aos="fade-up">
            <div class="d-flex justify-content-center gap-2">
                @if ($students->onFirstPage())
                    <span class="page-link disabled"><i class="bi bi-chevron-right"></i></span>
                @else
                    <a class="page-link" href="{{ $students->previousPageUrl() }}"><i class="bi bi-chevron-right"></i></a>
                @endif

                @foreach ($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                    <a class="page-link {{ $students->currentPage() == $page ? 'active' : '' }}" href="{{ $url }}">{{ $page }}</a>
                @endforeach

                @if ($students->hasMorePages())
                    <a class="page-link" href="{{ $students->nextPageUrl() }}"><i class="bi bi-chevron-left"></i></a>
                @else
                    <span class="page-link disabled"><i class="bi bi-chevron-left"></i></span>
                @endif
            </div>
        </div>
    @endif
@endsection
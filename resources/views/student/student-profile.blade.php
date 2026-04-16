@extends('layouts.app')

@section('title', 'بروفايل الطالب')

@section('styles')
    <!-- إضافة Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- إضافة Choices.js -->
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet">
    <style>
        /* أنماط عامة للصفحة */
        body {
            background: #f5f5f5;
            font-family: 'Tajawal', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* أنماط المحتوى الرئيسي */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
            padding: 2rem;
            margin: 0;
            gap: 2rem;
        }

        /* أنماط قسم البروفايل */
        .profile-section {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .profile-section h2 {
            font-size: 1.8rem;
            color: #202124;
            margin: 0 0 1.5rem 0;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .profile-section h2 i {
            color: #1a73e8;
            font-size: 1.8rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            font-weight: 600;
            color: #1e3a8a;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        .form-control, .form-select {
            border-radius: 15px;
            border: 2px solid #e5e7eb;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 10px rgba(37, 99, 235, 0.3);
            background: #fff;
        }
        .input-group-text {
            border-radius: 15px 0 0 15px;
            background: #e5e7eb;
            border: 2px solid #e5e7eb;
            border-right: none;
            color: #4b5563;
            font-size: 1.2rem;
            padding: 10px 15px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            border: none;
            border-radius: 50px;
            padding: 14px 40px;
            font-size: 1.2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
            color: #fff;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.5);
            transform: translateY(-2px);
        }
        .alert {
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            font-size: 1rem;
        }
        .alert-success {
            background: #e7f4e4;
            color: #2e7d32;
        }
        .alert-danger {
            background: #ffebee;
            color: #d32f2f;
        }
        .alert-warning {
            background: #fef3c7;
            color: #92400e;
        }
        /* تحسين مظهر Choices.js */
        .choices {
            border-radius: 15px;
            border: 2px solid #e5e7eb;
            font-size: 1rem;
        }
        .choices__inner {
            border-radius: 15px;
            padding: 10px;
            background: #f9fafb;
            border: none;
        }
        .choices__list--multiple .choices__item {
            background: #2563eb;
            border: none;
            border-radius: 20px;
            color: #fff;
            padding: 5px 10px;
            margin: 2px;
            font-size: 0.9rem;
        }
        .choices__list--multiple .choices__item--selectable {
            padding-right: 25px;
        }
        .choices__list--dropdown {
            border-radius: 15px;
            border: 2px solid #e5e7eb;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .choices__list--dropdown .choices__item--selectable.is-highlighted {
            background: #e3f2fd;
        }
        /* تعديل مكان زر الحذف ليكون على اليسار مع فاصل رأسي بعده */
        .choices__list--multiple .choices__item--choice {
            display: flex;
            align-items: center;
            position: relative;
            padding-right: 10px; /* تقليل المساحة على اليمين */
            padding-left: 30px; /* إفساح مجال لزر الحذف على اليسار */
        }
        .choices__list--multiple .choices__item--choice .choices__button {
            order: -1; /* نقل زر الحذف إلى اليسار */
            margin-right: 0; /* إزالة أي هوامش إضافية على اليمين */
        }
        .choices__list--multiple .choices__item--choice .choices__button::after {
            content: "|";
            color: #fff;
            margin: 0 8px; /* زيادة المسافة بين الفاصل والنص */
            font-size: 0.9rem;
        }
        .current-cv {
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: #5f6368;
        }
        .current-cv a {
            color: #1a73e8;
            text-decoration: none;
        }
        .current-cv a:hover {
            text-decoration: underline;
        }

        /* أنماط متجاوبة */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
                gap: 1rem;
            }
            .profile-section {
                padding: 1rem;
            }
            .profile-section h2 {
                font-size: 1.5rem;
            }
            .form-label {
                font-size: 1rem;
            }
            .form-control, .form-select {
                padding: 10px;
                font-size: 0.9rem;
            }
            .btn-primary {
                padding: 12px 30px;
                font-size: 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <!-- المحتوى الرئيسي -->
    <div class="main-content">
        <!-- قسم البروفايل -->
        <div class="profile-section animate__animated animate__fadeIn">
            <h2><i class="fas fa-user-edit"></i> بروفايل الطالب</h2>

            <!-- Success, Warning, and Error Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- نموذج تحديث البروفايل -->
            <form action="{{ route('student.updateProfile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- CV Update -->
                <div class="form-group">
                    <label for="cv" class="form-label">تحديث السيرة الذاتية (PDF)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-file-earmark-pdf-fill"></i></span>
                        <input type="file" name="cv" id="cv" class="form-control" accept=".pdf">
                    </div>
                    @if (Auth::guard('student')->user()->cv_path)
                        <small class="current-cv d-block mt-2">
                            السيرة الذاتية الحالية: 
                            <a href="{{ asset('storage/' . Auth::guard('student')->user()->cv_path) }}" target="_blank">عرض</a>
                        </small>
                    @endif
                </div>

                <!-- Programming Languages with Choices.js -->
                <div class="form-group">
                    <label for="programming_languages" class="form-label">لغات البرمجة (اختر واحدة أو أكثر)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-code-slash"></i></span>
                        <select name="programming_languages[]" id="programming_languages" class="form-control choices-multiple" multiple>
                            <!-- التأكد من أن programming_languages هو مصفوفة -->
                            @php
                                $languages = Auth::guard('student')->user()->programming_languages;
                                // إذا كانت القيمة سلسلة نصية، نحاول فك تشفيرها
                                if (is_string($languages)) {
                                    $languages = json_decode($languages, true);
                                }
                                // التأكد من أن $languages هو مصفوفة، وإلا نعينها كمصفوفة فارغة
                                $languages = is_array($languages) ? $languages : [];
                            @endphp
                            <option value="Python" {{ in_array('Python', $languages) ? 'selected' : '' }}>Python</option>
                            <option value="Java" {{ in_array('Java', $languages) ? 'selected' : '' }}>Java</option>
                            <option value="JavaScript" {{ in_array('JavaScript', $languages) ? 'selected' : '' }}>JavaScript</option>
                            <option value="C++" {{ in_array('C++', $languages) ? 'selected' : '' }}>C++</option>
                            <option value="C#" {{ in_array('C#', $languages) ? 'selected' : '' }}>C#</option>
                            <option value="PHP" {{ in_array('PHP', $languages) ? 'selected' : '' }}>PHP</option>
                            <option value="Ruby" {{ in_array('Ruby', $languages) ? 'selected' : '' }}>Ruby</option>
                            <option value="Go" {{ in_array('Go', $languages) ? 'selected' : '' }}>Go</option>
                            <option value="Swift" {{ in_array('Swift', $languages) ? 'selected' : '' }}>Swift</option>
                            <option value="Kotlin" {{ in_array('Kotlin', $languages) ? 'selected' : '' }}>Kotlin</option>
                            <option value="TypeScript" {{ in_array('TypeScript', $languages) ? 'selected' : '' }}>TypeScript</option>
                            <option value="R" {{ in_array('R', $languages) ? 'selected' : '' }}>R</option>
                            <option value="SQL" {{ in_array('SQL', $languages) ? 'selected' : '' }}>SQL</option>
                            <option value="Rust" {{ in_array('Rust', $languages) ? 'selected' : '' }}>Rust</option>
                            <option value="Scala" {{ in_array('Scala', $languages) ? 'selected' : '' }}>Scala</option>
                            <option value="Perl" {{ in_array('Perl', $languages) ? 'selected' : '' }}>Perl</option>
                            <option value="MATLAB" {{ in_array('MATLAB', $languages) ? 'selected' : '' }}>MATLAB</option>
                            <option value="Dart" {{ in_array('Dart', $languages) ? 'selected' : '' }}>Dart</option>
                            <option value="Lua" {{ in_array('Lua', $languages) ? 'selected' : '' }}>Lua</option>
                            <option value="Elixir" {{ in_array('Elixir', $languages) ? 'selected' : '' }}>Elixir</option>
                            <option value="C" {{ in_array('C', $languages) ? 'selected' : '' }}>C</option>
                            <option value="F#" {{ in_array('F#', $languages) ? 'selected' : '' }}>F#</option>
                            <option value="Julia" {{ in_array('Julia', $languages) ? 'selected' : '' }}>Julia</option>
                            <option value="Solidity" {{ in_array('Solidity', $languages) ? 'selected' : '' }}>Solidity</option>
                            <option value="Assembly" {{ in_array('Assembly', $languages) ? 'selected' : '' }}>Assembly</option>
                            <option value="Groovy" {{ in_array('Groovy', $languages) ? 'selected' : '' }}>Groovy</option>
                            <option value="Haskell" {{ in_array('Haskell', $languages) ? 'selected' : '' }}>Haskell</option>
                            <option value="Erlang" {{ in_array('Erlang', $languages) ? 'selected' : '' }}>Erlang</option>
                            <option value="Clojure" {{ in_array('Clojure', $languages) ? 'selected' : '' }}>Clojure</option>
                            <option value="Scheme" {{ in_array('Scheme', $languages) ? 'selected' : '' }}>Scheme</option>
                            <option value="Fortran" {{ in_array('Fortran', $languages) ? 'selected' : '' }}>Fortran</option>
                            <option value="COBOL" {{ in_array('COBOL', $languages) ? 'selected' : '' }}>COBOL</option>
                            <option value="Ada" {{ in_array('Ada', $languages) ? 'selected' : '' }}>Ada</option>
                            <option value="Prolog" {{ in_array('Prolog', $languages) ? 'selected' : '' }}>Prolog</option>
                            <option value="Lisp" {{ in_array('Lisp', $languages) ? 'selected' : '' }}>Lisp</option>
                            <option value="Smalltalk" {{ in_array('Smalltalk', $languages) ? 'selected' : '' }}>Smalltalk</option>
                            <option value="OCaml" {{ in_array('OCaml', $languages) ? 'selected' : '' }}>OCaml</option>
                            <option value="D" {{ in_array('D', $languages) ? 'selected' : '' }}>D</option>
                            <option value="Crystal" {{ in_array('Crystal', $languages) ? 'selected' : '' }}>Crystal</option>
                            <option value="Nim" {{ in_array('Nim', $languages) ? 'selected' : '' }}>Nim</option>
                            <option value="Zig" {{ in_array('Zig', $languages) ? 'selected' : '' }}>Zig</option>
                            <option value="V" {{ in_array('V', $languages) ? 'selected' : '' }}>V</option>
                            <option value="Apex" {{ in_array('Apex', $languages) ? 'selected' : '' }}>Apex</option>
                            <option value="Bash" {{ in_array('Bash', $languages) ? 'selected' : '' }}>Bash</option>
                            <option value="PowerShell" {{ in_array('PowerShell', $languages) ? 'selected' : '' }}>PowerShell</option>
                            <option value="Objective-C" {{ in_array('Objective-C', $languages) ? 'selected' : '' }}>Objective-C</option>
                            <option value="Pascal" {{ in_array('Pascal', $languages) ? 'selected' : '' }}>Pascal</option>
                            <option value="Delphi" {{ in_array('Delphi', $languages) ? 'selected' : '' }}>Delphi</option>
                            <option value="VHDL" {{ in_array('VHDL', $languages) ? 'selected' : '' }}>VHDL</option>
                            <option value="Verilog" {{ in_array('Verilog', $languages) ? 'selected' : '' }}>Verilog</option>
                            <option value="T-SQL" {{ in_array('T-SQL', $languages) ? 'selected' : '' }}>T-SQL</option>
                            <option value="PL/SQL" {{ in_array('PL/SQL', $languages) ? 'selected' : '' }}>PL/SQL</option>
                            <option value="GraphQL" {{ in_array('GraphQL', $languages) ? 'selected' : '' }}>GraphQL</option>
                            <option value="Hack" {{ in_array('Hack', $languages) ? 'selected' : '' }}>Hack</option>
                            <option value="HCL" {{ in_array('HCL', $languages) ? 'selected' : '' }}>HCL</option>
                            <option value="Arduino" {{ in_array('Arduino', $languages) ? 'selected' : '' }}>Arduino</option>
                            <option value="Scratch" {{ in_array('Scratch', $languages) ? 'selected' : '' }}>Scratch</option>
                            <option value="Logo" {{ in_array('Logo', $languages) ? 'selected' : '' }}>Logo</option>
                            <option value="Malbolge" {{ in_array('Malbolge', $languages) ? 'selected' : '' }}>Malbolge</option>
                            <option value="Brainfuck" {{ in_array('Brainfuck', $languages) ? 'selected' : '' }}>Brainfuck</option>
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary animate__animated animate__pulse animate__infinite">
                        <i class="bi bi-save-fill me-2"></i>حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap Icons و Animate.css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // تهيئة Choices.js للقائمة المنسدلة المتعددة
            const element = document.querySelector('#programming_languages');
            const choices = new Choices(element, {
                removeItemButton: true,
                placeholderValue: 'اختر لغات البرمجة...',
                noChoicesText: 'لا توجد خيارات متاحة',
                itemSelectText: 'اضغط للاختيار',
                searchEnabled: true,
                searchPlaceholderValue: 'ابحث عن لغة برمجة...',
            });
        });
    </script>
@endsection
@extends('layouts.app')

@section('title', 'تسجيل طالب')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet">
    <style>
        .container-fluid {
            padding: 3rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        .card-header {
            background: #1e3a8a;
            padding: 1.5rem;
            text-align: center;
            border-radius: 12px 12px 0 0;
        }

        .card-header h3 {
            margin: 0;
            font-size: 1.7rem;
            color: #fff;
            font-family: 'Poppins', sans-serif;
        }

        .card-body {
            padding: 2rem;
        }

        .form-label {
            color: #1e3a8a;
            font-weight: 500;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px;
            font-size: 0.9rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #facc15;
            box-shadow: 0 0 5px rgba(250, 204, 21, 0.3);
        }

        .form-control.is-invalid {
            border-color: #dc2626;
        }

        .invalid-feedback {
            color: #dc2626;
            font-size: 0.8rem;
        }

        .input-group-text {
            background: #e5e7eb;
            border: 1px solid #e5e7eb;
            color: #1e3a8a;
            border-radius: 8px;
        }

        /* عكس اتجاه العناصر لخانتي التخصص والجنس */
        .reverse-direction {
            direction: rtl;
            display: flex;
        }

        .reverse-direction .input-group-text {
            border-radius: 0 8px 8px 0;
            border-left: none;
            border-right: 1px solid #e5e7eb;
        }

        .reverse-direction .form-select {
            border-radius: 8px 0 0 8px;
        }

        /* ضبط مظهر السهم ليكون على اليسار */
        .reverse-direction .form-select {
            background-position: left 0.75rem center;
            padding-left: 2.5rem;
            padding-right: 1rem;
        }

        .btn-primary {
            background: #facc15;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 0.95rem;
            font-weight: 600;
            color: #1e3a8a;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background: #eab308;
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-danger {
            background: #fee2e2;
            color: #dc2626;
        }

        .choices__inner {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 5px;
            background: #fff;
        }

        .choices__list--multiple .choices__item {
            background: #facc15;
            border: none;
            border-radius: 4px;
            color: #1e3a8a;
            padding: 3px 8px;
            margin: 2px;
            font-size: 0.8rem;
        }

        .choices__list--dropdown {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        .choices__list--dropdown .choices__item--selectable.is-highlighted {
            background: #e5e7eb;
        }

        #grade-display {
            padding: 10px;
            border-radius: 8px;
            background: #e5e7eb;
            color: #1e3a8a;
            font-weight: 500;
            font-size: 0.9rem;
            text-align: center;
        }

        #grade-display.excellent { background: #dcfce7; color: #166534; }
        #grade-display.very-good { background: #e5e7eb; color: #1e3a8a; }
        #grade-display.good { background: #fef9c3; color: #ca8a04; }
        #grade-display.pass { background: #fee2e2; color: #dc2626; }
        #grade-display.fail { background: #fee2e2; color: #dc2626; }

        .form-group {
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding: 1.5rem;
            }
            .card-header {
                padding: 1rem;
            }
            .card-body {
                padding: 1.5rem;
            }
            .card-header h3 {
                font-size: 1.5rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card" data-aos="fade-up">
            <div class="card-header">
                <h3 style="position: relative; text-align: center;">
                    <i class="bi bi-person-plus-fill me-2"></i>تسجيل طالب
                    <a href="{{ route('student.login') }}" style="color: #fff; text-decoration: none; position: absolute; left: 10px; top: 50%; transform: translateY(-50%);">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
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

                <form action="{{ route('student.register') }}" method="POST" enctype="multipart/form-data" id="registerForm">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">الاسم الكامل</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="أدخل الاسم الكامل" value="{{ old('name') }}" required>
                        </div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="example@example.com" value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">كلمة المرور</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••" required>
                        </div>
                        <div id="password-mismatch" class="invalid-feedback" style="display: none;">
                            كلمتا المرور غير متطابقتين
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">رقم الهاتف</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="+962*********" value="{{ old('phone') }}" required>
                        </div>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="location" class="form-label">الموقع</label>
                        <div class="input-group reverse-direction">
                            <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                            <select name="location" id="location" class="form-select @error('location') is-invalid @enderror" required>
                                <option value="" disabled selected>اختر الموقع</option>
                                <option value="عمان" {{ old('location') == 'عمان' ? 'selected' : '' }}>عمان</option>
                                <option value="إربد" {{ old('location') == 'إربد' ? 'selected' : '' }}>إربد</option>
                                <option value="الزرقاء" {{ old('location') == 'الزرقاء' ? 'selected' : '' }}>الزرقاء</option>
                                <option value="البلقاء" {{ old('location') == 'البلقاء' ? 'selected' : '' }}>البلقاء</option>
                                <option value="الكرك" {{ old('location') == 'الكرك' ? 'selected' : '' }}>الكرك</option>
                                <option value="معان" {{ old('location') == 'معان' ? 'selected' : '' }}>معان</option>
                                <option value="الطفيلة" {{ old('location') == 'الطفيلة' ? 'selected' : '' }}>الطفيلة</option>
                                <option value="العقبة" {{ old('location') == 'العقبة' ? 'selected' : '' }}>العقبة</option>
                                <option value="جرش" {{ old('location') == 'جرش' ? 'selected' : '' }}>جرش</option>
                                <option value="عجلون" {{ old('location') == 'عجلون' ? 'selected' : '' }}>عجلون</option>
                                <option value="مادبا" {{ old('location') == 'مادبا' ? 'selected' : '' }}>مادبا</option>
                                <option value="المفرق" {{ old('location') == 'المفرق' ? 'selected' : '' }}>المفرق</option>
                            </select>
                        </div>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="gender" class="form-label">الجنس</label>
                        <div class="input-group reverse-direction">
                            <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                            <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                <option value="" disabled selected>اختر الجنس</option>
                                <option value="ذكر">ذكر</option>
                                <option value="أنثى">أنثى</option>
                            </select>
                        </div>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="specialization" class="form-label">التخصص</label>
                        <div class="input-group reverse-direction">
                            <span class="input-group-text"><i class="bi bi-book-fill"></i></span>
                            <select name="specialization" id="specialization" class="form-select @error('specialization') is-invalid @enderror" required>
                                <option value="" disabled selected>اختر التخصص</option>
                                <option value="علوم الحاسوب">علوم الحاسوب</option>
                                <option value="هندسة البرمجيات">هندسة البرمجيات</option>
                                <option value="نظم المعلومات">نظم المعلومات</option>
                                <option value="الأمن السيبراني">الأمن السيبراني</option>
                                <option value="تحليل البيانات">تحليل البيانات</option>
                                <option value="تطوير الويب">تطوير الويب</option>
                                <option value="الذكاء الاصطناعي">الذكاء الاصطناعي</option>
                                <option value="إدارة قواعد البيانات">إدارة قواعد البيانات</option>
                                <option value="هندسة الشبكات">هندسة الشبكات</option>
                                <option value="تطوير تطبيقات الهواتف الذكية">تطوير تطبيقات الهواتف الذكية</option>
                                <option value="علوم البيانات">علوم البيانات</option>
                                <option value="الحوسبة السحابية">الحوسبة السحابية</option>
                                <option value="إنترنت الأشياء (IoT)">إنترنت الأشياء (IoT)</option>
                                <option value="تطوير الألعاب">تطوير الألعاب</option>
                                <option value="الرؤية الحاسوبية">الرؤية الحاسوبية</option>
                            </select>
                        </div>
                        @error('specialization')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="programming_languages" class="form-label">لغات البرمجة (اختر واحدة أو أكثر)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-code-slash"></i></span>
                            <select name="programming_languages[]" id="programming_languages" class="form-control choices-multiple @error('programming_languages') is-invalid @enderror" multiple required>
                                <option value="Python">Python</option>
                                <option value="Java">Java</option>
                                <option value="JavaScript">JavaScript</option>
                                <option value="C++">C++</option>
                                <option value="C#">C#</option>
                                <option value="PHP">PHP</option>
                                <option value="Ruby">Ruby</option>
                                <option value="Go">Go</option>
                                <option value="Swift">Swift</option>
                                <option value="Kotlin">Kotlin</option>
                                <option value="TypeScript">TypeScript</option>
                                <option value="R">R</option>
                                <option value="SQL">SQL</option>
                                <option value="Rust">Rust</option>
                                <option value="Scala">Scala</option>
                                <option value="Perl">Perl</option>
                                <option value="MATLAB">MATLAB</option>
                                <option value="Dart">Dart</option>
                                <option value="Lua">Lua</option>
                                <option value="Elixir">Elixir</option>
                                <option value="C">C</option>
                                <option value="F#">F#</option>
                                <option value="Julia">Julia</option>
                                <option value="Solidity">Solidity</option>
                                <option value="Assembly">Assembly</option>
                            </select>
                        </div>
                        @error('programming_languages')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="score" class="form-label">المعدل</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-award-fill"></i></span>
                            <input type="number" name="score" id="score" class="form-control @error('score') is-invalid @enderror" placeholder="المعدل: 0-100" value="{{ old('score') }}" min="0" max="100" required>
                        </div>
                        @error('score')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="grade-display" class="form-label">التقدير</label>
                        <div id="grade-display" class="grade-display">أدخل المعدل لتحديد التقدير</div>
                        <input type="hidden" name="grade" id="grade" value="">
                    </div>

                    <div class="form-group">
                        <label for="cv" class="form-label">السيرة الذاتية (PDF)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-file-earmark-pdf-fill"></i></span>
                            <input type="file" name="cv" id="cv" class="form-control @error('cv') is-invalid @enderror" accept=".pdf">
                        </div>
                        @error('cv')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            إرسال الطلب
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const element = document.querySelector('#programming_languages');
            const choices = new Choices(element, {
                removeItemButton: true,
                placeholderValue: 'اختر لغات البرمجة...',
                noChoicesText: 'لا توجد خيارات متاحة',
                itemSelectText: 'اضغط للاختيار',
                maxItemCount: 5,
                renderChoiceLimit: -1,
                searchEnabled: true,
                searchPlaceholderValue: 'ابحث عن لغة...',
            });

            const scoreInput = document.getElementById('score');
            const gradeDisplay = document.getElementById('grade-display');
            const gradeInput = document.getElementById('grade');

            function updateGrade() {
                const score = parseFloat(scoreInput.value);
                let gradeText = '';
                let gradeClass = '';

                if (isNaN(score) || score < 0 || score > 100) {
                    gradeText = 'أدخل معدل صحيح Houdini(0-100)';
                    gradeClass = '';
                    gradeInput.value = '';
                } else if (score >= 90) {
                    gradeText = 'ممتاز';
                    gradeClass = 'excellent';
                    gradeInput.value = 'ممتاز';
                } else if (score >= 80) {
                    gradeText = 'جيد جدًا';
                    gradeClass = 'very-good';
                    gradeInput.value = 'جيد جدًا';
                } else if (score >= 70) {
                    gradeText = 'جيد';
                    gradeClass = 'good';
                    gradeInput.value = 'جيد';
                } else if (score >= 60) {
                    gradeText = 'مقبول';
                    gradeClass = 'pass';
                    gradeInput.value = 'مقبول';
                } else {
                    gradeText = 'راسب';
                    gradeClass = 'fail';
                    gradeInput.value = 'راسب';
                }

                gradeDisplay.textContent = gradeText;
                gradeDisplay.className = `grade-display ${gradeClass}`;
            }

            scoreInput.addEventListener('input', updateGrade);

            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const passwordMismatch = document.getElementById('password-mismatch');
            const submitBtn = document.getElementById('submitBtn');

            function validatePasswords() {
                if (passwordInput.value !== passwordConfirmationInput.value) {
                    passwordConfirmationInput.classList.add('is-invalid');
                    passwordMismatch.style.display = 'block';
                    submitBtn.disabled = true;
                } else {
                    passwordConfirmationInput.classList.remove('is-invalid');
                    passwordMismatch.style.display = 'none';
                    submitBtn.disabled = false;
                }
            }

            passwordInput.addEventListener('input', validatePasswords);
            passwordConfirmationInput.addEventListener('input', validatePasswords);
        });
    </script>
@endsection
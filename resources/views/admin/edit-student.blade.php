@extends('layouts.app')

@section('title', 'تعديل طالب')

@section('styles')
    <style>
        .edit-section {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 2rem auto;
            max-width: 600px;
        }

        .edit-section h3 {
            font-size: 1.8rem;
            color: #1e3a8a;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-label {
            color: #1e3a8a;
            font-weight: 600;
        }

        .form-control,
        .form-select {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.5rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #facc15;
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #dc2626;
        }

        .invalid-feedback {
            color: #dc2626;
            font-size: 0.8rem;
        }

        .btn-primary {
            background: #facc15;
            color: #1e3a8a;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background: #eab308;
            transform: translateY(-2px);
        }

        .btn-back {
            background: #e5e7eb;
            color: #1e3a8a;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .btn-back:hover {
            background: #d1d5db;
            transform: translateY(-2px);
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="edit-section" data-aos="fade-up">
        <h3>✏️ تعديل بيانات الطالب</h3>
        <form method="POST" action="{{ route('admin.student.update', $student) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">الاسم</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $student->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $student->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">رقم الهاتف</label>
                <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $student->phone) }}" required>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">الجنس</label>
                <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror" required>
                    <option value="ذكر" {{ old('gender', $student->gender) == 'ذكر' ? 'selected' : '' }}>ذكر</option>
                    <option value="أنثى" {{ old('gender', $student->gender) == 'أنثى' ? 'selected' : '' }}>أنثى</option>
                </select>
                @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="specialization" class="form-label">التخصص</label>
                <select name="specialization" id="specialization" class="form-select @error('specialization') is-invalid @enderror" required>
                    <option value="هندسة البرمجيات" {{ old('specialization', $student->specialization) == 'هندسة البرمجيات' ? 'selected' : '' }}>هندسة البرمجيات</option>
                    <option value="الأمن السيبراني" {{ old('specialization', $student->specialization) == 'الأمن السيبراني' ? 'selected' : '' }}>الأمن السيبراني</option>
                    <option value="تحليل البيانات" {{ old('specialization', $student->specialization) == 'تحليل البيانات' ? 'selected' : '' }}>تحليل البيانات</option>
                    <option value="تطوير الويب" {{ old('specialization', $student->specialization) == 'تطوير الويب' ? 'selected' : '' }}>تطوير الويب</option>
                </select>
                @error('specialization')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="score" class="form-label">المعدل</label>
                <input type="number" name="score" id="score" class="form-control @error('score') is-invalid @enderror" value="{{ old('score', $student->score) }}" step="0.1" min="0" max="100" required>
                @error('score')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="grade" class="form-label">التقدير</label>
                <input type="text" name="grade" id="grade" class="form-control @error('grade') is-invalid @enderror" value="{{ old('grade', $student->grade) }}" required>
                @error('grade')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="programming_languages" class="form-label">لغات البرمجة</label>
                <select name="programming_languages[]" id="programming_languages" class="form-control @error('programming_languages') is-invalid @enderror" multiple required>
                    @php
                        $languages = is_string($student->programming_languages) ? json_decode($student->programming_languages, true) : $student->programming_languages;
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
                </select>
                @error('programming_languages')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="button-container">
                <button type="submit" class="btn-primary">حفظ التعديلات</button>
                <a href="{{ route('admin.students') }}" class="btn-back">عودة</a>
            </div>
        </form>
    </div>
@endsection
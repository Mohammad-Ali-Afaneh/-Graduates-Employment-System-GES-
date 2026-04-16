@extends('layouts.app')

@section('title', 'تفاصيل الطالب')

@section('styles')
    <style>
        .student-details-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .student-details-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .student-details-header h1 {
            font-size: 2rem;
            color: #1e3a8a;
            position: relative;
            display: inline-block;
        }

        .student-details-header h1::after {
            content: '';
            width: 50%;
            height: 3px;
            background: #facc15;
            position: absolute;
            bottom: -5px;
            left: 25%;
        }

        .student-details-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .info-item {
            background: #e5e7eb;
            padding: 1.5rem;
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .info-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .info-item p {
            margin: 0.5rem 0;
            color: #1e3a8a;
            font-size: 0.95rem;
        }

        .info-item p strong {
            color: #1e3a8a;
            font-weight: 600;
        }

        .cv-download {
            display: inline-block;
            background: #facc15;
            color: #1e3a8a;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.3s ease;
            margin-top: 1rem;
        }

        .cv-download:hover {
            background: #eab308;
            transform: translateY(-2px);
        }

        .notify-form {
            margin-top: 2rem;
        }

        .notify-form .form-group {
            margin-bottom: 1rem;
        }

        .notify-form textarea {
            width: 100%;
            padding: 0.5rem;
            border-radius: 8px;
            border: 1px solid #d1d5db;
        }

        .notify-form button {
            background: #1e3a8a;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .notify-form button:hover {
            background: #1a2e6c;
        }

        @media (max-width: 768px) {
            .student-details-info {
                grid-template-columns: 1fr;
            }
            .student-details-header h1 {
                font-size: 1.7rem;
            }
            .info-item {
                padding: 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="student-details-container" data-aos="fade-up">
        <div class="student-details-header">
            <h1><i class="bi bi-person-fill me-2"></i>تفاصيل الطالب</h1>
        </div>
        @if (isset($student))
            <div class="student-details-info" data-aos="fade-up" data-aos-delay="100">
                <div class="info-item">
                    <p><strong>الاسم:</strong> {{ $student->name }}</p>
                    <p><strong>البريد الإلكتروني:</strong> {{ $student->email }}</p>
                    <p><strong>رقم الهاتف:</strong> {{ $student->phone }}</p>
                    <p><strong>الجنس:</strong> {{ $student->gender }}</p>
                </div>
                <div class="info-item">
                    <p><strong>التخصص:</strong> {{ $student->specialization }}</p>
                    <p><strong>لغات البرمجة:</strong> 
                        @if ($student->programmingLanguages->isNotEmpty())
                            {{ $student->programmingLanguages->pluck('programming_language')->implode(', ') }}
                        @elseif ($student->programming_languages)
                            {{ implode(', ', json_decode($student->programming_languages, true)) }}
                        @else
                            غير متوفرة
                        @endif
                    </p>
                    <p><strong>المعدل:</strong> {{ $student->score }}</p>
                    <p><strong>التقدير:</strong> {{ $student->grade }}</p>
                    @if ($student->cv_path)
                        <a href="{{ route('cv.show', $student->id) }}" class="cv-download" target="_blank"><i class="bi bi-file-earmark-pdf-fill me-2"></i>فتح السيرة الذاتية</a>
                    @else
                        <p><strong>السيرة الذاتية:</strong> غير متوفرة</p>
                    @endif
                </div>
            </div>

            <div class="notify-form" data-aos="fade-up" data-aos-delay="200">
                <h3>إرسال طلب توظيف</h3>
                <form action="{{ route('company.notifyStudent', $student->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="interview_details">تفاصيل المقابلة:</label>
                        <textarea name="interview_details" id="interview_details" required></textarea>
                    </div>
                    <button type="submit"><i class="bi bi-send-fill me-2"></i>إرسال طلب توظيف</button>
                </form>
            </div>
        @else
            <p class="text-center text-muted">لا توجد بيانات للطالب.</p>
        @endif
    </div>
@endsection
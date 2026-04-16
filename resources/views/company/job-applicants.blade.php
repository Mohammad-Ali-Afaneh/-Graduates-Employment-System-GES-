@extends('layouts.app')

@section('title', 'المتقدمين على الوظيفة')

@section('styles')
    <style>
        .applicants-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .applicants-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .applicants-header h1 {
            font-size: 2rem;
            color: #1e3a8a;
            position: relative;
            display: inline-block;
        }

        .applicants-header h1::after {
            content: '';
            width: 50%;
            height: 3px;
            background: #facc15;
            position: absolute;
            bottom: -5px;
            left: 25%;
        }

        .applicant-card {
            background: #e5e7eb;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .applicant-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .applicant-card p {
            margin: 0.5rem 0;
            color: #1e3a8a;
            font-size: 0.95rem;
        }

        .applicant-card p strong {
            color: #1e3a8a;
            font-weight: 600;
        }

        .applicant-card .btn {
            background: #facc15;
            color: #1e3a8a;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .applicant-card .btn:hover {
            background: #eab308;
            transform: translateY(-2px);
        }

        .applicant-actions {
            margin-top: 1rem;
            display: flex;
            gap: 0.5rem;
        }

        .applicant-actions form {
            display: inline-block;
        }

        .applicant-actions button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .applicant-actions .accept-btn {
            background: #166534;
            color: #fff;
        }

        .applicant-actions .accept-btn:hover {
            background: #14532d;
            transform: translateY(-2px);
        }

        .applicant-actions .reject-btn {
            background: #dc2626;
            color: #fff;
        }

        .applicant-actions .reject-btn:hover {
            background: #b91c1c;
            transform: translateY(-2px);
        }

        .empty-message {
            text-align: center;
            color: #6b7280;
            font-size: 1rem;
            padding: 2rem;
        }
    </style>
@endsection

@section('content')
    <div class="applicants-container" data-aos="fade-up">
        <div class="applicants-header">
            <h1><i class="bi bi-people-fill me-2"></i>المتقدمين على الوظيفة: {{ $jobApplication->title }}</h1>
        </div>
        @if ($applicants->isEmpty())
            <p class="empty-message">لا يوجد متقدمون على هذه الوظيفة حاليًا.</p>
        @else
            @foreach ($applicants as $application)
                @if ($application->student)
                    <div class="applicant-card" data-aos="fade-up" data-aos-delay="100">
                        <p><strong>الاسم:</strong> {{ $application->student->name }}</p>
                        <a href="{{ route('company.student-details', $application->student->id) }}" class="btn">عرض التفاصيل</a>
                        @if ($application->response == 'pending' || $application->response == null)
                            <div class="applicant-actions">
                                <form action="{{ route('company.accept-applicant', $application->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="accept-btn">قبول</button>
                                </form>
                                <form action="{{ route('company.reject-applicant', $application->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="reject-btn">رفض</button>
                                </form>
                            </div>
                        @else
                            <p><strong>الحالة:</strong> {{ $application->response == 'accepted' ? 'مقبول' : 'مرفوض' }}</p>
                        @endif
                    </div>
                @endif
            @endforeach
        @endif
        <a href="{{ route('company.receive-request') }}" class="btn mt-3"><i class="bi bi-arrow-return-left me-1"></i>العودة</a>
    </div>
@endsection
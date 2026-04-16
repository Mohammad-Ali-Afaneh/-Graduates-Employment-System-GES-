@extends('layouts.app')

@section('title', 'قائمة المتقدمين')

@section('styles')
    <style>
        .employees-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .employees-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .employees-header h1 {
            font-size: 2rem;
            color: #1e3a8a;
            position: relative;
            display: inline-block;
            font-family: 'Poppins', sans-serif;
        }

        .employees-header h1::after {
            content: '';
            width: 50%;
            height: 3px;
            background: #facc15;
            position: absolute;
            bottom: -5px;
            left: 25%;
        }

        .employees-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .employee-card {
            background: #e5e7eb;
            padding: 1.5rem;
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .employee-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .employee-card p {
            margin: 0.5rem 0;
            color: #1e3a8a;
            font-size: 0.95rem;
        }

        .employee-card p strong {
            color: #1e3a8a;
            font-weight: 600;
        }

        .employee-card .btn {
            background: #facc15;
            color: #1e3a8a;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .employee-card .btn:hover {
            background: #eab308;
            transform: translateY(-2px);
        }

        .responses-section {
            margin-top: 2rem;
            padding: 1.5rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .responses-section h2 {
            font-size: 1.7rem;
            color: #1e3a8a;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .responses-section h2::after {
            content: '';
            width: 50%;
            height: 3px;
            background: #facc15;
            position: absolute;
            bottom: -5px;
            left: 25%;
        }

        .response-card {
            background: #f3f4f6;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            position: relative;
        }

        .response-card p {
            margin: 0.5rem 0;
            color: #1e3a8a;
            font-size: 0.95rem;
        }

        .response-card p strong {
            color: #1e3a8a;
            font-weight: 600;
        }

        .response-card .status-accepted {
            color: #166534;
            font-weight: 600;
        }

        .response-card .status-rejected {
            color: #dc2626;
            font-weight: 600;
        }

        .response-card .status-pending {
            color: #6b7280;
            font-weight: 600;
        }

        .response-actions {
            margin-top: 1rem;
            display: flex;
            gap: 0.5rem;
        }

        .response-actions form {
            display: inline-block;
        }

        .response-actions .delete-btn {
            background: #dc2626;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .response-actions .delete-btn:hover {
            background: #b91c1c;
            transform: translateY(-2px);
        }

        .empty-message {
            text-align: center;
            color: #6b7280;
            font-size: 1rem;
            padding: 2rem;
        }

        .pagination .page-link {
            color: #1e3a8a;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            margin: 0 0.2rem;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .pagination .page-link:hover {
            background: #facc15;
            color: #1e3a8a;
        }

        .pagination .page-item.active .page-link {
            background: #1e3a8a;
            color: #fff;
            border-color: #1e3a8a;
        }

        @media (max-width: 768px) {
            .employees-grid {
                grid-template-columns: 1fr;
            }

            .employees-header h1, .responses-section h2 {
                font-size: 1.7rem;
            }

            .employees-container, .responses-section {
                padding: 1.5rem;
            }

            .employee-card, .response-card {
                padding: 1rem;
            }

            .employee-card p, .response-card p {
                font-size: 0.9rem;
            }

            .employee-card .btn, .response-actions .delete-btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.9rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="employees-container" data-aos="fade-up">
        <!-- قسم الردود -->
        <div class="responses-section" data-aos="fade-up" data-aos-delay="200">
            <h2>ردود الطلاب</h2>
            @if (isset($jobApplications) && $jobApplications->isNotEmpty())
                @foreach ($jobApplications as $application)
                    @if ($application->student && ($application->response == 'accepted' || $application->response == 'rejected'))
                        <div class="response-card">
                            <p><strong>الاسم:</strong> {{ $application->student->name }}</p>
                            <p><strong>التخصص:</strong> {{ $application->student->specialization }}</p>
                            <p><strong>المعدل:</strong> {{ $application->student->score }}</p>
                            <p><strong>التقدير:</strong> {{ $application->student->grade }}</p>
                            @if ($application->response == 'pending' && $application->interview_details)
                                <p><strong>تفاصيل المقابلة:</strong> {{ $application->interview_details }}</p>
                            @endif
                            <p>
                                <strong>حالة الطلب:</strong>
                                @if ($application->response == 'accepted')
                                    <span class="status-accepted">تم القبول</span>
                                @elseif ($application->response == 'rejected')
                                    <span class="status-rejected">تم الرفض</span>
                                @else
                                    <span class="status-pending">في انتظار الرد</span>
                                @endif
                            </p>
                            <div class="response-actions">
                                <a href="{{ route('company.student-details', $application->student->id) }}" class="btn"><i class="bi bi-eye-fill me-1"></i>عرض التفاصيل</a>
                                <form action="{{ route('company.deleteJobApplication', $application->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="redirect_to" value="company.employees">
                                    <button type="submit" class="delete-btn">حذف</button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <p class="empty-message">لا توجد ردود من الطلاب حاليًا.</p>
            @endif
        </div>
    </div>
@endsection
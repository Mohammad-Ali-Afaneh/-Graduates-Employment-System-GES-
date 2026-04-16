@extends('layouts.app')

@section('title', 'الصفحة الرئيسية للطلاب')

@section('styles')
    <style>
        .welcome-section {
            text-align: center;
            padding: 2rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .welcome-section h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e3a8a;
        }

        .welcome-section h1 span {
            color: #facc15;
            font-family: 'Poppins', sans-serif;
        }

        .notifications-section {
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .notifications-section h2 {
            font-size: 1.7rem;
            color: #1e3a8a;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .notifications-section h2::after {
            content: '';
            width: 50%;
            height: 3px;
            background: #facc15;
            position: absolute;
            bottom: -5px;
            left: 25%;
        }

        .notification-badge {
            display: inline-block;
            background: #dc2626;
            color: #fff;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            line-height: 20px;
            text-align: center;
            margin-right: 8px;
            vertical-align: middle;
        }

        .notification-card {
            background: #e5e7eb;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .notification-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .notification-card p {
            margin: 0;
            color: #1e3a8a;
            font-size: 0.95rem;
        }

        .notification-card small {
            color: #6b7280;
            font-size: 0.85rem;
        }

        .notification-actions {
            margin-top: 1rem;
            display: flex;
            gap: 0.5rem;
        }

        .notification-actions form {
            display: inline-block;
        }

        .notification-actions button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .notification-actions .accept-btn {
            background: #166534;
            color: #fff;
        }

        .notification-actions .accept-btn:hover {
            background: #14532d;
            transform: translateY(-2px);
        }

        .notification-actions .reject-btn {
            background: #dc2626;
            color: #fff;
        }

        .notification-actions .reject-btn:hover {
            background: #b91c1c;
            transform: translateY(-2px);
        }

        .notification-actions .delete-btn {
            background: #6b7280;
            color: #fff;
        }

        .notification-actions .delete-btn:hover {
            background: #4b5563;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .welcome-section h1 {
                font-size: 1.7rem;
            }
            .notifications-section h2 {
                font-size: 1.5rem;
            }
            .notification-card p {
                font-size: 0.9rem;
            }
            .notifications-section {
                padding: 1rem;
            }
            .notification-badge {
                width: 18px;
                height: 18px;
                line-height: 18px;
                font-size: 0.7rem;
            }
            .notification-actions button {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="welcome-section" data-aos="fade-up">
        <h1>مرحبًا <span>{{ Auth::guard('student')->user()->name }}</span>!</h1>
    </div>

    <div class="notifications-section" data-aos="fade-up" data-aos-delay="100">
        <h2>
            <i class="bi bi-bell-fill me-2"></i> الإشعارات
            @if ($unreadNotificationsCount > 0)
                <span class="notification-badge">{{ $unreadNotificationsCount }}</span>
            @endif
        </h2>
        @if (isset($notifications) && $notifications->isNotEmpty())
            @foreach ($notifications as $notification)
                <div class="notification-card">
                    <p>{{ $notification->message }}</p>
                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                    <div class="notification-actions">
                        {{-- شرط لعرض أزرار القبول والرفض فقط إذا كان الإشعار من شركة (عرض توظيف) --}}
                        @if (str_contains($notification->message, 'تم إرسال طلب لك من شركة'))
                            <form action="{{ route('student.accept', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="accept-btn">قبول</button>
                            </form>
                            <form action="{{ route('student.reject', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="reject-btn">رفض</button>
                            </form>
                        @endif
                        {{-- زر الحذف دائمًا متاح لجميع الإشعارات --}}
                        <form action="{{ route('student.delete', $notification->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">حذف</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-center text-muted">لا توجد إشعارات حاليًا.</p>
        @endif
    </div>
@endsection
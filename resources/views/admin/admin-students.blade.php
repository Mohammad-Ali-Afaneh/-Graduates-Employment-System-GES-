@extends('layouts.app')

@section('title', 'إدارة الطلاب')

@section('styles')
    <style>
        .admin-section {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 2rem auto;
            max-width: 1200px;
        }

        .admin-section h2 {
            font-size: 1.8rem;
            color: #1e3a8a;
            margin-bottom: 1.5rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .students-table {
            overflow-x: auto;
        }

        .students-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .students-table th,
        .students-table td {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
            color: #1e3a8a;
        }

        .students-table th {
            background: #facc15;
            font-weight: 600;
        }

        .students-table td {
            color: #6b7280;
        }

        .students-table tr:last-child td {
            border-bottom: none;
        }

        .btn-edit,
        .btn-delete {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.3s ease;
            margin: 0 0.25rem;
        }

        .btn-edit {
            background: #1e3a8a;
            color: #fff;
        }

        .btn-edit:hover {
            background: #153074;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #dc2626;
            color: #fff;
        }

        .btn-delete:hover {
            background: #b91c1c;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .admin-section {
                padding: 1rem;
                margin: 1rem;
            }
            .admin-section h2 {
                font-size: 1.5rem;
            }
            .students-table th,
            .students-table td {
                padding: 0.75rem;
                font-size: 0.9rem;
            }
            .btn-edit,
            .btn-delete {
                padding: 0.4rem 0.8rem;
                font-size: 0.9rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="admin-section" data-aos="fade-up">
        <h2><i class="bi bi-person-gear me-2"></i> إدارة الطلاب</h2>

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

        <div class="students-table">
            @if (!isset($students) || $students->isEmpty())
                <p class="text-center text-muted">لا يوجد طلاب مسجلون حاليًا.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>الرقم</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>رقم الهاتف</th>
                            <th>الجنس</th>
                            <th>التخصص</th>
                            <th>المعدل</th>
                            <th>التقدير</th>
                            <th>لغات البرمجة</th>
                            <th>السيرة الذاتية</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $index => $student)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone ?? 'غير متوفر' }}</td>
                                <td>{{ $student->gender ?? 'غير متوفر' }}</td>
                                <td>{{ $student->specialization ?? 'غير متوفر' }}</td>
                                <td>{{ $student->score ?? 'غير متوفر' }}</td>
                                <td>{{ $student->grade ?? 'غير متوفر' }}</td>
                                <td>
                                    @php
                                        $languages = is_string($student->programming_languages) ? json_decode($student->programming_languages, true) : $student->programming_languages;
                                        $languages = is_array($languages) ? $languages : [];
                                    @endphp
                                    {{ implode(', ', $languages) ?: 'غير متوفر' }}
                                </td>
                                <td>
                                    @if ($student->cv_path)
                                        <a href="{{ asset('storage/' . $student->cv_path) }}" target="_blank">عرض</a>
                                    @else
                                        غير متوفر
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.student.edit', $student->id) }}" class="btn-edit">تعديل</a>
                                    <form action="{{ route('admin.student.delete', $student->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" onclick="return confirm('هل أنت متأكد من حذف هذا الطالب؟')">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
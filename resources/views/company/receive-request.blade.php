@extends('layouts.app')

@section('title', 'إعلانات الوظائف')

@section('styles')
    <style>
        :root {
            --gradient-start: #4F6CB6;
            --gradient-end:   #D5DAEE;
            --primary:        #273A75;
            --secondary:      #6B7280;
            --accent:         #FACC15;
            --card-bg:        #ffffff;
        }

        body {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            min-height: 100vh;
        }

        .container.mt-5 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .card.shadow-sm {
            background: var(--card-bg);
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: var(--primary);
            border-bottom: none;
        }

        .card-header h2 {
            color: #fff;
            font-size: 1.75rem;
            letter-spacing: 0.5px;
        }

        .job-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .job-card {
            background: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
        }

        .job-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.12);
        }

        .job-card .card-body {
            padding: 1.5rem;
            flex: 1;
        }

        .job-card h3 {
            font-size: 1.4rem;
            color: var(--primary);
            margin-bottom: 0.75rem;
        }

        .job-card p {
            font-size: 0.95rem;
            color: var(--secondary);
            margin-bottom: 0.5rem;
        }

        .job-card p strong {
            color: var(--primary);
        }

        .job-card .card-footer {
            background: var(--bg-light);
            padding: 1rem 1.5rem;
            text-align: right;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .publish-date {
            font-size: 0.85rem;
            color: var(--secondary);
        }

        .btn-delete {
            background: #dc3545;
            border: none;
            border-radius: 6px;
            padding: 0.25rem 0.75rem;
            color: #fff;
            font-size: 0.85rem;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .btn-delete:hover {
            background: #c82333;
            transform: translateY(-1px);
        }

        .btn-applicants {
            background: #1e3a8a;
            border: none;
            border-radius: 6px;
            padding: 0.25rem 0.75rem;
            color: #fff;
            font-size: 0.85rem;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.3s ease;
            margin-left: 0.5rem;
        }

        .btn-applicants:hover {
            background: #1a2e6c;
            transform: translateY(-1px);
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin: 2rem 0;
            gap: 0.5rem;
        }

        .pagination .page-link {
            background: var(--card-bg);
            border: none;
            color: var(--primary);
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: background 0.3s, color 0.3s;
        }

        .pagination .page-link:hover {
            background: var(--accent);
            color: #fff;
        }

        .pagination .active .page-link {
            background: var(--accent);
            color: var(--primary);
        }

        .pagination .disabled .page-link {
            background: #e5e7eb;
            color: var(--secondary);
            cursor: not-allowed;
        }
    </style>
@endsection

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm rounded mx-auto" style="max-width: 900px;">
        <div class="card-header text-center">
            <h2 class="mb-0">إعلانات الوظائف</h2>
        </div>
        <div class="card-body">
            @if ($jobPostings->isEmpty())
                <p class="text-center text-secondary">لا يوجد إعلانات وظائف حاليًا.</p>
            @else
                <div class="job-grid">
                    @foreach ($jobPostings as $job)
                        <div class="job-card">
                            <div class="card-body">
                                <h3>{{ $job->title }}</h3>
                                <p><strong>الوصف:</strong> {{ Str::limit($job->description, 100) }}</p>
                            </div>
                            <div class="card-footer">
                                <span class="publish-date">نُشرت في: {{ $job->created_at->toDateString() }}</span>
                                <div>
                                    <form action="{{ route('company.deleteJobPosting', $job->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="redirect_to" value="company.receive-request">
                                        <button type="submit" class="btn-delete" onclick="return confirm('هل أنت متأكد من حذف هذا الإعلان الوظيفي؟')">حذف</button>
                                    </form>
                                    <a href="{{ route('company.job-applicants', $job->id) }}" class="btn-applicants">المتقدمين</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        @if ($jobPostings->hasPages())
            <div class="pagination">
                @if ($jobPostings->onFirstPage())
                    <span class="disabled"><span class="page-link"><i class="bi bi-chevron-right"></i></span></span>
                @else
                    <a class="page-link" href="{{ $jobPostings->previousPageUrl() }}"><i class="bi bi-chevron-right"></i></a>
                @endif

                @foreach ($jobPostings->getUrlRange(1, $jobPostings->lastPage()) as $page => $url)
                    <span class="{{ $jobPostings->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </span>
                @endforeach

                @if ($jobPostings->hasMorePages())
                    <a class="page-link" href="{{ $jobPostings->nextPageUrl() }}"><i class="bi bi-chevron-left"></i></a>
                @else
                    <span class="disabled"><span class="page-link"><i class="bi bi-chevron-left"></i></span></span>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
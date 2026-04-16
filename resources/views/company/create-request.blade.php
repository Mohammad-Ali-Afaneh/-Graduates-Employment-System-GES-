@extends('layouts.app')

@section('title', 'إنشاء إعلان وظيفة جديد')

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
            padding: 2rem 0;
        }

        .card.shadow-lg {
            background: var(--card-bg);
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Remove default header border & keep white */
        .card-header {
            border: none;
            background-color: var(--card-bg);
        }

        /* Header title styling + yellow underline */
        .card-header h2 {
            color: var(--primary);
            position: relative;
            display: inline-block;
            padding-bottom: 0.5rem;
        }
        .card-header h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: var(--accent);
            border-radius: 2px;
        }

        .card-body {
            padding: 2rem;
        }

        .form-label {
            color: var(--primary);
            font-weight: 600;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #dde2ed;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: none;
        }

        .btn-outline-primary {
            background-color: var(--accent);
            border-color: var(--accent);
            color: var(--primary);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
        }
    </style>
@endsection

@section('content')
<div class="container mt-5">
  <div class="card shadow-lg rounded mx-auto" style="max-width: 700px;">
    <div class="card-header text-center">
      <h2 class="mb-0">إنشاء إعلان وظيفة جديد</h2>
    </div>
    <div class="card-body">
      <form action="{{ route('company.store-job-posting') }}" method="POST">
        @csrf
        <div class="mb-4">
          <label for="job_title" class="form-label">المسمى الوظيفي</label>
          <input
            type="text"
            id="job_title"
            name="job_title"
            class="form-control form-control-lg"
            placeholder="أدخل المسمى الوظيفي"
            required
          >
          @error('job_title')
            <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-4">
          <label for="description" class="form-label">وصف الوظيفة</label>
          <textarea
            id="description"
            name="description"
            rows="5"
            class="form-control form-control-lg"
            placeholder="اكتب وصف الوظيفة هنا…"
            required
          ></textarea>
          @error('description')
            <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-outline-primary btn-lg">
            إرسال
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'تسجيل الدخول - الشركة')

@section('styles')
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
            max-width: 450px;
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

        .form-control {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px;
            font-size: 0.9rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
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
            border-right: none;
            color: #1e3a8a;
            border-radius: 8px 0 0 8px;
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
              <i class="bi bi-building-fill me-2"></i>تسجيل الدخول - الشركة  
                 <a href="{{ route('home') }}" style="color: #fff; text-decoration: none; position: absolute; left: 5px; top: 50%; transform: translateY(-50%);">
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

                <form action="{{ route('company.login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="company_name" class="form-label">اسم الشركة</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-building-fill"></i></span>
                            <input type="text" name="company_name" id="company_name" class="form-control @error('company_name') is-invalid @enderror" placeholder="أدخل اسم الشركة" value="{{ old('company_name') }}" required>
                        </div>
                        @error('company_name')
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
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            تسجيل الدخول
                        </button>
                    </div>
                    <div class="text-center">
                     <span>ليس لديك حساب؟ </span>
                    <a href="{{ route('company.register') }}" class="link-custom">سجل الآن</a>
                     </div>
                </form>
            </div>
        </div>
    </div>
@endsection
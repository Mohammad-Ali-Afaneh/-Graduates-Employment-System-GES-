@extends('layouts.app')

@section('title', 'تسجيل أدمن')

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
                <h3><i class="bi bi-person-plus-fill me-2"></i>تسجيل أدمن</h3>
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

                <form action="{{ route('admin.register') }}" method="POST">
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
                        <label for="user_name" class="form-label">اسم المستخدم</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                            <input type="text" name="user_name" id="user_name" class="form-control @error('user_name') is-invalid @enderror" placeholder="أدخل اسم المستخدم" value="{{ old('user_name') }}" required>
                        </div>
                        @error('user_name')
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
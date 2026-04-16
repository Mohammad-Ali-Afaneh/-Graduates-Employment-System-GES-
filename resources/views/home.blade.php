@extends('layouts.app')

@section('title', 'الصفحة الرئيسية')

@section('styles')
    <style>
        .home-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 60px);
            text-align: center;
            padding: 2rem;
        }

        .home-container h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 1rem;
        }

        .options {
            display: flex;
            flex-direction: row;
            gap: 1.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .option-card {
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            min-width: 200px;
            text-align: center;
        }

        .option-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .option-card a {
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: 600;
            color: #1e3a8a;
            transition: color 0.3s ease;
        }

        .option-card a:hover {
            color: #facc15;
        }

        @media (max-width: 768px) {
            .home-container h1 {
                font-size: 2rem;
            }
            .options {
                flex-direction: column;
                gap: 1rem;
            }
            .option-card {
                min-width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="home-container" data-aos="fade-up">
        <h1>مرحبًا بك في منصة التوظيف</h1>
        <div class="options">
            <div class="option-card">
                <a href="{{ route('student.login') }}">الطلاب</a>
            </div>
            <div class="option-card">
                <a href="{{ route('company.login') }}">الشركات</a>
            </div>
        </div>
    </div>
@endsection
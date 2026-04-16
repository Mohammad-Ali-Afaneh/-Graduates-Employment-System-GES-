@extends('layouts.app')

@section('title', 'صفحة البداية')

@section('background', 'https://images.unsplash.com/photo-1600585154347-be6161a56a0c')

@section('container_width', '500px')

@section('content')
    <h3 class="text-center">اختيار</h3>
    <div class="text-center">
        <a href="{{ route('student.register') }}" class="blue-button">اضغط هنا</a>
    </div>
@endsection
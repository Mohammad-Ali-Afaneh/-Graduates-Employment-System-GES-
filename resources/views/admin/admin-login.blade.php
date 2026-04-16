<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول الأدمن</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #0057b7;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #0057b7;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        .login-container .form-control {
            margin-bottom: 15px;
            text-align: right;
        }
        .login-container .btn {
            background-color: #0057b7;
            color: white;
            width: 100%;
            padding: 10px;
            border-radius: 25px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>
            تسجيل دخول الأدمن
            <i class="fas fa-user-shield"></i>
        </h2>
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <input type="text" name="user_name" class="form-control" placeholder="أدخل اسم المستخدم" required>
            <input type="password" name="password" class="form-control" placeholder="كلمة المرور" required>
            <button type="submit" class="btn">تسجيل الدخول</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
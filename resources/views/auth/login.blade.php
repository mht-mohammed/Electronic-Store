<x-guest-layout>
    <style>
        /* ===== تنسيقات مخصصة لصفحة تسجيل الدخول ===== */
        
        /* تنسيق الخلفية */
        body {
            background: linear-gradient(135deg, #1a2a3a 0%, #0f1724 100%);
            position: relative;
        }
        
        /* تأثير خلفية متحركة */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(255, 107, 53, 0.08) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        
        /* تنسيق الحاوية الرئيسية */
        .min-h-screen {
            background: transparent !important;
        }
        
        /* تنسيق البطاقة */
        .bg-white {
            background: rgba(255, 255, 255, 0.98) !important;
            border-radius: 35px !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3) !important;
            padding: 40px 35px !important;
            animation: fadeInUp 0.6s ease-out !important;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* تنسيق الحقول */
        .block {
            display: block !important;
        }
        
        .mt-1 {
            margin-top: 0.5rem !important;
        }
        
        .w-full {
            width: 100% !important;
        }
        
        /* تنسيق الـ input */
        input[type="email"],
        input[type="password"] {
            width: 100% !important;
            padding: 12px 16px !important;
            border: 2px solid #e9ecef !important;
            border-radius: 14px !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
            background: #f8f9fa !important;
        }
        
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none !important;
            border-color: #ff6b35 !important;
            background: white !important;
            box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1) !important;
        }
        
        /* تنسيق الـ label */
        label {
            font-weight: 600 !important;
            color: #1a2a3a !important;
            margin-bottom: 8px !important;
            display: block !important;
            font-size: 14px !important;
        }
        
        /* تنسيق زر تسجيل الدخول */
        button[type="submit"] {
            background: linear-gradient(135deg, #ff6b35, #ff5722) !important;
            border: none !important;
            border-radius: 14px !important;
            padding: 12px 24px !important;
            font-weight: 700 !important;
            font-size: 16px !important;
            transition: all 0.3s ease !important;
            cursor: pointer !important;
            width: 100% !important;
            margin-top: 20px !important;
        }
        
        button[type="submit"]:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 25px -5px rgba(255, 107, 53, 0.4) !important;
        }
        
        /* تنسيق الـ Remember Me */
        .inline-flex {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
        }
        
        input[type="checkbox"] {
            width: 16px !important;
            height: 16px !important;
            border-radius: 4px !important;
            border: 2px solid #dee2e6 !important;
            cursor: pointer !important;
            transition: 0.3s !important;
        }
        
        input[type="checkbox"]:checked {
            background-color: #ff6b35 !important;
            border-color: #ff6b35 !important;
        }
        
        /* تنسيق النص بجانب checkbox */
        .text-sm {
            font-size: 14px !important;
            color: #6c757d !important;
        }
        
        /* تنسيق رابط نسيت كلمة المرور */
        .underline {
            text-decoration: none !important;
            color: #ff6b35 !important;
            font-weight: 500 !important;
            font-size: 14px !important;
            transition: 0.3s !important;
        }
        
        .underline:hover {
            color: #ff5722 !important;
            text-decoration: underline !important;
        }
        
        /* تنسيق رسائل الخطأ */
        .text-red-600 {
            color: #dc3545 !important;
            font-size: 12px !important;
            margin-top: 5px !important;
        }
        
        /* تنسيق رسائل النجاح */
        .text-green-600 {
            color: #28a745 !important;
            font-size: 14px !important;
            background: rgba(40, 167, 69, 0.1) !important;
            padding: 12px 15px !important;
            border-radius: 12px !important;
            margin-bottom: 20px !important;
        }
        
        /* تنسيق الحاوية الرئيسية للفورم */
        form {
            max-width: 450px !important;
            margin: 0 auto !important;
        }
        
        /* تنسيقات إضافية للجوال */
        @media (max-width: 480px) {
            .bg-white {
                padding: 30px 20px !important;
                margin: 15px !important;
            }
            
            .flex {
                flex-direction: column !important;
                gap: 12px !important;
                align-items: flex-start !important;
            }
        }
        
        /* إضافة عنوان للصفحة */
        .login-title {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-title .logo {
            font-size: 50px;
            margin-bottom: 10px;
            display: inline-block;
        }
        
        .login-title h2 {
            font-size: 26px;
            font-weight: 800;
            color: #1a2a3a;
            margin-bottom: 8px;
        }
        
        .login-title p {
            color: #6c757d;
            font-size: 14px;
        }
        
        /* تحسين تباعد العناصر */
        .mt-4 {
            margin-top: 1.2rem !important;
        }
        
        .mb-4 {
            margin-bottom: 1.2rem !important;
        }
        
        /* تنسيق الحاوية المرنة */
        .flex.items-center.justify-end {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            margin-top: 20px !important;
        }
        
        /* إضافة تأثير على الحقول عند التركيز */
        input:focus {
            transform: scale(1.01);
        }
        
        /* تنسيق شريط التمرير */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #ff6b35;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #ff5722;
        }
    </style>

    <div class="login-title">
        <div class="logo">
            📱 متجر <span style="color: #ff6b35;">أجهزة</span>
        </div>
        <h2>مرحباً بعودتك</h2>
        <p>قم بتسجيل الدخول إلى حسابك</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('البريد الإلكتروني')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@store.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('كلمة المرور')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('تذكرني') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('نسيت كلمة المرور؟') }}
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <div class="mt-4">
            <x-primary-button class="w-full justify-center">
                <i class="bi bi-box-arrow-in-right me-2"></i>
                {{ __('تسجيل الدخول') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
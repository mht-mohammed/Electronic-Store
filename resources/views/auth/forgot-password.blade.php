<x-guest-layout>
    <style>
        /* ===== تنسيقات مخصصة لصفحة نسيت كلمة المرور ===== */
        
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
        
        /* تنسيق النص الوصفي */
        .description-text {
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 25px;
            padding: 0 10px;
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
        input[type="email"] {
            width: 100% !important;
            padding: 12px 16px !important;
            border: 2px solid #e9ecef !important;
            border-radius: 14px !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
            background: #f8f9fa !important;
        }
        
        input[type="email"]:focus {
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
        
        /* تنسيق زر الإرسال */
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
        }
        
        /* عنوان الصفحة */
        .page-title {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .page-title .logo {
            font-size: 50px;
            margin-bottom: 10px;
            display: inline-block;
        }
        
        .page-title h2 {
            font-size: 26px;
            font-weight: 800;
            color: #1a2a3a;
            margin-bottom: 8px;
        }
        
        .page-title p {
            color: #6c757d;
            font-size: 14px;
        }
        
        /* رابط العودة لتسجيل الدخول */
        .back-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        
        .back-link a {
            color: #ff6b35;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: 0.3s;
        }
        
        .back-link a:hover {
            color: #ff5722;
            text-decoration: underline;
        }
        
        /* تحسين تباعد العناصر */
        .mt-4 {
            margin-top: 1.2rem !important;
        }
        
        .mb-4 {
            margin-bottom: 1.2rem !important;
        }
        
        /* إضافة تأثير على الحقل عند التركيز */
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

    <div class="page-title">
        <div class="logo">
            📱 متجر <span style="color: #ff6b35;">أجهزة</span>
        </div>
        <h2>استعادة كلمة المرور</h2>
        <p>سنرسل لك رابطاً لإعادة تعيين كلمة المرور</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="description-text">
        نسيت كلمة المرور؟ لا مشكلة. فقط أخبرنا بريدك الإلكتروني وسنرسل لك رابطاً لإعادة تعيين كلمة المرور.
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('البريد الإلكتروني')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="admin@store.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="mt-4">
            <button type="submit">
                <i class="bi bi-envelope-paper me-2"></i>
                {{ __('إرسال رابط إعادة التعيين') }}
            </button>
        </div>
    </form>

    <!-- Back to Login Link -->
    <div class="back-link">
        <a href="{{ route('login') }}">
            <i class="bi bi-arrow-right me-1"></i>
            {{ __('العودة إلى تسجيل الدخول') }}
        </a>
    </div>
</x-guest-layout>
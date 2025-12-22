<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col items-center justify-center h-screen font-sans">

    <div class="text-center bg-white p-10 rounded-xl shadow-xl max-w-lg w-full">
        
        <h1 class="text-4xl font-bold text-gray-800 mb-4">مرحباً بك في <span class="text-blue-600">نظامنا</span></h1>
        
        <?php if ($isLoggedIn): ?>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <p class="text-xl text-green-700">أهلاً بعودتك، <strong><?= htmlspecialchars($username) ?></strong> 👋</p>
                <p class="text-gray-600 mt-2">أنت الآن متصل بالنظام.</p>
            </div>

            <div class="space-y-3">
                <a href="/web_final_project/public/dashboard" class="block w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition">
                    الذهاب للوحة التحكم (Dashboard)
                </a>
                <a href="/web_final_project/public/logout" class="block w-full bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600 transition">
                    تسجيل خروج
                </a>
            </div>

        <?php else: ?>
            <p class="text-gray-600 mb-8 text-lg">هذا مشروع تطبيقي لمادة Web Application. يرجى تسجيل الدخول للبدء.</p>

            <div class="flex gap-4 justify-center">
                <a href="/web_final_project/public/login" class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700 transition shadow-md">
                    تسجيل دخول
                </a>
                <a href="/web_final_project/public/register" class="bg-gray-600 text-white font-bold py-2 px-6 rounded hover:bg-gray-700 transition shadow-md">
                    حساب جديد
                </a>
            </div>
        <?php endif; ?>

    </div>

    <p class="mt-8 text-gray-400 text-sm">Built with Native PHP & MVC Pattern</p>

</body>
</html>

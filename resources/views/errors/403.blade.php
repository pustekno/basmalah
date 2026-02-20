<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Forbidden</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 text-center">
            <div class="text-6xl font-bold text-red-600 dark:text-red-400 mb-4">403</div>
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-2">Access Denied</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                You don't have permission to access this resource.
            </p>
            <a href="{{ route('dashboard') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Go to Dashboard
            </a>
        </div>
    </div>
</body>
</html>

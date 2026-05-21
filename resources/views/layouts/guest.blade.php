<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    </head>
    <body>
        <div class="min-h-screen d-flex flex-column justify-content-center align-items-center py-5"
             style="background:#f1f5f9;">
            <div>
                <a href="/" style="text-decoration:none;">
                    <div class="d-flex align-items-center gap-2 mb-4 justify-content-center">
                        <i class="bi bi-heart-pulse-fill" style="font-size:28px;color:#4F46E5;"></i>
                        <span style="font-size:18px;font-weight:700;color:#0f172a;">Clinic Management</span>
                    </div>
                </a>
            </div>

            <div class="w-100" style="max-width:420px;padding:0 16px;">
                <div class="card border-0 shadow-sm" style="border-radius:14px;">
                    <div class="card-body p-4">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>

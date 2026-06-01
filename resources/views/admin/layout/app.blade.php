<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indian Abacus Academy — Admin Dashboard </title>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom-style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/employee-style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom-crud.css') }}">
    <link rel="icon" href="data:,">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('style')

</head>

<body>

    <div class="layout" id="app">
        <div class="overlay" id="overlay" onclick="closeSidebar()"></div>

        <!-- SIDEBAR -->
        @include('admin.layout.sidebar')

        <!-- MAIN -->
        <main class="main" id="main">
            @include('admin.layout.header')

            <div class="content">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ asset('admin/assets/js/scripts.js') }}"></script>

    {{-- Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Dropdown --}}


    <!-- jQuery (required) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @yield('script')

</body>

</html>
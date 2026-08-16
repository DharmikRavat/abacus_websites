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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

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

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    @yield('script')

</body>

</html>
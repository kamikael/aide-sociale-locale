<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: #f4f6f9;
        }
        .sidebar {
            min-height: 100vh;
            background: #1e293b;
            color: white;
        }
        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
        }
        .sidebar a:hover {
            background: #334155;
            color: white;
        }
        .header {
            background: white;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        {{-- Sidebar --}}
        <div class="col-md-2 p-0 sidebar">
            @include('components.sidebar')
        </div>

        {{-- Main Content --}}
        <div class="col-md-10 p-0">

            {{-- Header --}}
            <div class="header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">@yield('page-title')</h5>

                <div>
                    <span class="me-3">
                        {{ auth()->user()->name }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="fa fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="p-4">
                @include('components.alert')
                @yield('content')
            </div>

        </div>

    </div>
</div>

</body>
</html>

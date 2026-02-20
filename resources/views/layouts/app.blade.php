<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Aide sociale locale</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #F8FAFC;
            color: #0F172A;
        }
        header {
            background: #1E3A8A;
            color: white;
            padding: 15px;
        }
        footer {
            background: #DBEAFE;
            padding: 10px;
            text-align: center;
            font-size: 14px;
            margin-top: 40px;
        }
        .container {
            padding: 20px;
        }
        input {
            padding: 8px;
            width: 100%;
            max-width: 300px;
        }
        button {
            background: #2563EB;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <header>
        <h2>Aide sociale locale</h2>
    </header>

        <main class="container">
            @yield('content')
        </main>

    <footer>
        © 2026 — Aide sociale locale
    </footer>

</body>
</html>

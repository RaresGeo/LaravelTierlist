<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Scuffed Tier List</title>
    <script src="{{ asset('js/app.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://kit.fontawesome.com/93cb515c97.js" crossorigin="anonymous"></script>

    <style>
        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
        }

        /* The Close Button */
        .closeModal {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .closeModal:hover,
        .closeModal:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-gray-900">
    <nav class="p-6 bg-gray-300 flex justify-between mb-6">
        <ul class="flex items-center font-semibold">
            <li>
                <a href="/" class="p-3">Home</a>
            </li>
            <li>
                <a href="{{ route('dashboard') }}" class="p-3">Dashboard</a>
            </li>
            <li>
                <a href="/" class="p-3">Posts</a>
            </li>
        </ul>

        <ul class="flex items-center font-semibold">
            @auth
            <li class="mx-5">
                <a href="{{ route('newtemplate') }}" class="p-3">New Template</a>
            </li>
            <li>
                <a href="" class="p-3">{{ auth()->user()->name }}</a>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="post" class="p-3 inline">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </li>
            @endauth

            @guest
            <li>
                <a href="{{ route('login') }}" class="p-3">Login</a>
            </li>
            <li>
                <a href="{{ route('register') }}" class="p-3">Register</a>
            </li>
            @endguest
        </ul>
    </nav>
    @yield('content')
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#B5A8D5]">
    <div class="bg-[#4D55CC] p-2">
        <nav class="flex flex-row justify-between mx-4 my-2">
            <h1 class="text-3xl font-bold text-slate-800">Todolist</h1>
            <div class="flex flex-row gap-x-4">
                <a href="/" class="text-2xl font-bold hover:text-slate-200 text-slate-800  px-4 py-1 hover:bg-[#211C84] bg-[#7A73D1] duration-200 rounded-md">Home</a>
                {{-- <a href="/about">About</a> --}}
            </div>
        </nav>
    </div>
    @yield('content')

</body>

</html>

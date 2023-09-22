<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Sampah USK</title>
    <meta name="author" content="">
    <meta name="description" content="">

    <!-- Tailwind -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');

        .font-family-karla {
            font-family: karla;
        }
    </style>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
            integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-50 font-family-karla">


<!-- Text Header -->
<header class="w-full container mx-auto">
    <div class="flex flex-col items-center py-12">
        <a class="font-bold text-green-800 uppercase hover:text-gray-700 text-5xl" href="{{route('home')}}">
            Bank Sampah USK
        </a>
        <p class="text-lg text-grey-700 mt-4">
            {{\App\Models\TextWidget::getTitle('header')}}
        </p>
    </div>
</header>

<!-- Topic Nav -->
<nav class="w-full py-4 border-t border-b bg-gray-100" x-data="{ open: false }">
    <div class="block sm:hidden">
        <a
            href="#"
            class="block md:hidden text-base font-bold uppercase text-center flex justify-center items-center"
            @click="open = !open"
        >
            Topics <i :class="open ? 'fa-chevron-down': 'fa-chevron-up'" class="fas ml-2"></i>
        </a>
    </div>
    <div :class="open ? 'block': 'hidden'" class="w-full flex-grow sm:flex sm:items-center sm:w-auto">
        <div
            class="w-full container mx-auto flex flex-col sm:flex-row items-center justify-center text-sm font-bold uppercase mt-0 px-6 py-2">
            <a href="{{route('home')}}" class="hover:bg-green-800 hover:text-white rounded py-2 px-4 mx-2">Home</a>
            <a href="/user" class="hover:bg-green-800 hover:text-white rounded py-2 px-4 mx-2">Nasabah</a>
            <a href="/admin" class="hover:bg-green-800 hover:text-white rounded py-2 px-4 mx-2">Admin</a>
            <a href="{{route('about-us')}}" class="hover:bg-green-800 hover:text-white rounded py-2 px-4 mx-2">About
                us</a>
        </div>
    </div>
</nav>


<div class="container mx-auto flex flex-wrap py-6">

    {{ $slot }}

</div>

<footer class="bg-white dark:bg-gray-900">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <a class="flex items-center sm:justify-between">
                <img src="./img/logo.png" class="h-24 mr-3 mb-3" alt="Bank Sampah USK" />
            </a>
            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3 md:grid-cols-2 md:gap-0 md:ml-auto">
                <div class="mr-4">
                    <h2 class="text-sm font-semibold text-green-800 uppercase dark:text-white">Mitra</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li>
                            <a href="https://www.menlhk.go.id/" class="hover:underline">KLHK</a>
                        </li>
                        <li>
                            <a href="https://portal.pln.co.id/" class="hover:underline">PLN Aceh</a>
                        </li>
                        <li>
                            <a href="https://www.aprilasia.com/id/" class="hover:underline">PT RAPP - APRIL Group</a>
                        </li>
                        <li>
                            <a href="https://www.pnm.co.id/" class="hover:underline">Permodalan Nasional Madani</a>
                        </li>
                    </ul>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-semibold text-green-800 uppercase dark:text-white">Media Sosial</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li>
                            <a href="https://www.instagram.com/banksampah.usk/" class="hover:underline ">Instagram</a>
                        </li>
                        <li>
                            <a href="https://api.whatsapp.com/send?phone=6282340980991" class="hover:underline">WhatsApp</a>
                        </li>
                        <li>
                            <a href="https://www.youtube.com/channel/UCeGuTUQOSIXt6XHR6sIoDCA" class="hover:underline">YouTube</a>
                        </li>
                        <li>
                            <a href="mailto:banksampah@usk.ac.id" class="hover:underline">Email</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8"/>
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 Bank Sampah USK. All Rights Reserved.</span>
        </div>
    </div>
</footer>


</body>
</html>

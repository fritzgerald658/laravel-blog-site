<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="navbar bg-base-100">
        <div class="flex-1">
            <a href="{{ route('blog.dashboard') }}" class="btn btn-ghost text-xl">Bloggerist</a>
        </div>
        <div class="flex-none">
            <ul class="menu menu-horizontal px-1">
                <li><a>Blog</a></li>
                <li>
                    <details>
                        <summary>{{ Auth::user()->name }}</summary>
                        <ul class="bg-base-100 rounded-t-none p-2">
                            <li><a>Profile</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="route('logout')"
                                        onclick="event.preventDefault();
                                            this.closest('form').submit();">Log
                                        Out</a>
                                </form>
                            </li>
                        </ul>
                    </details>
                </li>
            </ul>
        </div>
    </div>
    <div>

    </div>

    <div id="blog-container" class=" flex flex-col justify-center items-center gap-2">
        @foreach ($blogs as $blog)
            <div class="card bg-neutral text-white w-[90vw] md:w-[60vw]">
                <div class="card-body">
                    <p class="text-[0.8rem] text-gray-400">{{ $blog->is_private ? 'Private' : 'Public' }}</p>
                    <p class="text-[0.8rem]">Author: {{ $blog->user->name }}</p>
                    <h2 class="card-title">{{ $blog->blog_title }}</h2>
                    <p>{{ $blog->blog_description }}</p>
                </div>
            </div>
        @endforeach
    </div>




</body>
@vite('resources/js/save-blog.js')

</html>

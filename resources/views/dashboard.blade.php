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
            <span class="btn btn-ghost text-xl">Bloggerist</a>
        </div>
        <div class="flex-none">
            <ul class="menu menu-horizontal px-1">
                <li><a>Blog</a></li>
                <li>
                    <details>
                        <summary>{{ Auth::user()->name }}</summary>
                        <ul class="bg-base-100 rounded-t-none p-2">
                            <li><a href="{{ route('blog.profile') }}">Profile</a></li>
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
    <div class="flex flex-col justify-center items-center h-[50vh]">
        <form id="add-blog" class="flex flex-col gap-2  w-[90vw] md:w-[60vw]" method="post">
            @csrf
            @method('post')
            <input name="blog_title" type="text" placeholder="Title" class="input input-bordered w-[60vw]max-w-xs" />
            <textarea name="blog_description" class="textarea textarea-bordered w-full font-sans"
                placeholder="Type your thoughts here"></textarea>
            <div>
                <label class="text-sm" for="">Private</label>
                <input type="checkbox" name="is_private" value="1">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Post</button>
        </form>
    </div>


    <div id="blog-container" class=" flex flex-col justify-center items-center gap-2">
        @foreach ($blogs as $blog)
            <div class="card bg-neutral text-white w-[90vw] md:w-[60vw]">
                <div class="card-body">
                    <p class="text-[0.8rem] text-gray-400">{{ $blog->is_private ? 'Private' : 'Public' }}</p>
                    <div class="border-b-[1px] border-grey py-3">
                        <p class="text-[1rem]">Author: {{ $blog->user->name }}</p>
                    </div>

                    <h2 class="card-title">{{ $blog->blog_title }}</h2>
                    <p class="pl-3">{{ $blog->blog_description }}</p>
                </div>
            </div>
        @endforeach
    </div>



</body>
@vite('resources/js/save-blog.js')

</html>

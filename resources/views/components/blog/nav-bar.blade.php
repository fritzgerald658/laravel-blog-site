@props(['title'])

<div class="navbar bg-base-100">
    <div class="flex-1">
        <form action="{{ route('blog.dashboard') }}" method="get">
            <button type="submit" class="btn btn-ghost text-xl">{{ $title }}</button>
        </form>
    </div>
    <div class="flex-none">
        <ul class="menu menu-horizontal px-1">
            <li><a href="{{ route('blog.post') }}">Blog Posts</a></li>
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

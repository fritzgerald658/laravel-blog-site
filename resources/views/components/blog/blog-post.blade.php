<div id="blog-container" class="flex flex-col gap-2">
    @foreach ($blogs as $blog)
        <div class="card bg-neutral text-white w-[90vw] md:w-[60vw]">
            @php
                $created_at = $blog->created_at;
                $minutes_ago = floor($created_at->diffInMinutes());
                $hours_ago = floor($created_at->diffInHours());
            @endphp
            <div class="card-body">
                @if ($blog->created_at->isToday())
                    @if ($hours_ago > 0)
                        <p class="text-[0.6rem] text-gray-400">{{ $hours_ago }} hour{{ $hours_ago > 1 ? 's' : '' }}
                            ago</p>
                    @else
                        <p class="text-[0.6rem] text-gray-400">{{ $minutes_ago }} min{{ $minutes_ago > 1 ? 's' : '' }}
                            ago </p>
                    @endif
                @elseif ($blog->created_at->isYesterday())
                    <p class="text-[0.6rem] text-gray-400">{{ $blog->created_at->format('l') }}</p>
                @else
                    <p class="text-[0.6rem] text-gray-400">{{ $blog->created_at->format('l, F, d, Y') }}</p>
                @endif
                <p class="text-[0.8rem] text-gray-400" value=0>{{ $blog->is_private ? 'Private' : 'Public' }}</p>
                <p class="text-[0.8rem]">Author: {{ $blog->user->name }}</p>
                <h2 class="card-title">{{ $blog->blog_title }}</h2>
                <p>{{ $blog->blog_description }}</p>
            </div>
        </div>
    @endforeach
</div>
@vite('resources/js/like-blog.js')

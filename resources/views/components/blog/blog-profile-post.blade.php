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
                    <div class="flex items-center">
                        <p class="text-[0.6rem] text-gray-400">{{ $hours_ago }} hour{{ $hours_ago > 1 ? 's' : '' }}
                            ago</p>
                        <button class="btn btn-primary btn-sm edit-content">Edit Post</button>
                    </div>
                @else
                    <div class="flex items-center">
                        <p class="text-[0.6rem] text-gray-400">{{ $minutes_ago }} min{{ $minutes_ago > 1 ? 's' : '' }}
                            ago </p>
                        <button class="btn btn-primary btn-sm edit-content">Edit Post</button>
                    </div>
                @endif
            @elseif ($blog->created_at->isYesterday())
                <div class="flex items-center">
                    <p class="text-[0.6rem] text-gray-400">{{ $blog->created_at->format('l') }}</p>
                    <button class="btn btn-primary btn-sm edit-content">Edit Post</button>
                </div>
            @else
                <div class="flex items-center">
                    <p class="text-[0.6rem] text-gray-400">{{ $blog->created_at->format('l, F, d, Y') }}</p>
                </div>
            @endif
            <p class="text-[0.8rem] text-gray-400">{{ $blog->is_private ? 'Private' : 'Public' }}</p>
            <p class="text-[0.8rem]">Author: {{ $blog->user->name }}</p>
            <form action="" id="blog-edit-container" data-id="{{ $blog->id }}">
                <h2 contenteditable="false" class="card-title blog-edit" data-id="{{ $blog->id }}">
                    {{ $blog->blog_title }}</h2>
                <p contenteditable="false" class="blog-edit" data-id="{{ $blog->id }}">
                    {{ $blog->blog_description }}</p>

                <button id="save-edit" class="hidden btn btn-neutral">Save</button>
            </form>
        </div>
    </div>
@endforeach

@foreach ($blogs as $blog)
    <div id="blog-container" class="flex flex-col gap-2" data-id="{{ $blog->id }}">
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
                            <p class="text-[0.6rem] text-gray-400">{{ $minutes_ago }}
                                min{{ $minutes_ago > 1 ? 's' : '' }}
                                ago </p>

                            <button class="btn btn-primary btn-sm cancel-edit hidden" data-id="{{ $blog->id }}">Cancel
                                Edit</button>
                            <x-blog.blog-dropdown :blog="$blog" />
                        </div>
                    @else
                        <div class="flex items-center">
                            <p class="text-[0.6rem] text-gray-400">{{ $minutes_ago }}
                                min{{ $minutes_ago > 1 ? 's' : '' }}
                                ago </p>

                            <button class="btn btn-primary btn-sm cancel-edit hidden"
                                data-id="{{ $blog->id }}">Cancel
                                Edit</button>
                            <x-blog.blog-dropdown :blog="$blog" />
                        </div>
                    @endif
                @elseif ($blog->created_at->isYesterday())
                    <div class="flex items-center">
                        <p class="text-[0.6rem] text-gray-400">{{ $minutes_ago }} min{{ $minutes_ago > 1 ? 's' : '' }}
                            ago </p>

                        <button class="btn btn-primary btn-sm cancel-edit hidden" data-id="{{ $blog->id }}">Cancel
                            Edit</button>
                        <x-blog.blog-dropdown :blog="$blog" />
                    </div>
                @else
                    <div class="flex items-center">
                        <p class="text-[0.6rem] text-gray-400">{{ $minutes_ago }}
                            min{{ $minutes_ago > 1 ? 's' : '' }}
                            ago </p>

                        <button class="btn btn-primary btn-sm cancel-edit hidden" data-id="{{ $blog->id }}">Cancel
                            Edit</button>
                        <x-blog.blog-dropdown :blog="$blog" />
                    </div>
                @endif
                <p class="text-[0.8rem] text-gray-400">{{ $blog->is_private ? 'Private' : 'Public' }}</p>
                <p class="text-[0.8rem]">Author: {{ $blog->user->name }}</p>
                <form method="POST" action="" class="blog-edit-container" data-id="{{ $blog->id }}">
                    @csrf
                    @method('put')
                    <h2 id="edit" contenteditable="false" class="card-title blog-edit"
                        data-id="{{ $blog->id }}">
                        {{ $blog->blog_title }}</h2>
                    <p id="edit" contenteditable="false" class="blog-edit" data-id="{{ $blog->id }}">
                        {{ $blog->blog_description }}</p>
                    <button data-id="{{ $blog->id }}"
                        class="save-edit mt-5 hidden btn btn-sm btn-accent">Save</button>
                </form>
            </div>
        </div>
    </div>
@endforeach

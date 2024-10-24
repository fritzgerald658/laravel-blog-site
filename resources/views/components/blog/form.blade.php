<div class="flex flex-col justify-center items-center h-[50vh]">
    <form id="add-blog" class="flex flex-col gap-2  w-[90vw] md:w-[60vw]" method="post">
        <x-blog.error-message />
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

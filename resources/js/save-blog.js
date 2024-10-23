function setUpCsrfToken() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
}

function storeBlog() {
    $("#add-blog").on("submit", function (e) {
        e.preventDefault();
        console.log("im clicked");
        $.ajax({
            type: "POST",
            url: "dashboard/store",
            data: $(this).serialize(),
            success: function (response) {
                $("#blog-container").prepend(
                    `<div class="card bg-neutral text-white w-[90vw] md:w-[60vw]">
                        <div class="card-body ">
                            <span>Author: ${response.username}</span>
                            <h2 class="card-title">Title: ${response.blog_title}</h2>
                            <p>Description: ${response.blog_description}</p>
                    </div>
                </div>`
                );
                $("#add-blog")[0].reset();
            },
        });
    });
}

function execute() {
    $(document).ready(function () {
        setUpCsrfToken();
        storeBlog();
    });
}

execute();

function setUpCsrfToken() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
}

function formattedCreatedAt(response) {
    if (response.created_today)
        return response.created_hours_ago > 0
            ? `${response.created_hours_ago} hour ${
                  response.created_hours_ago > 1 ? "s" : ""
              } ago`
            : `${response.created_minutes_ago} min ${
                  response.created_minutes_ago > 1 ? "s" : ""
              } ago`;
    else if (response.created_yesterday) return response.created_days_ago;
    else return response.created_long_ago;
}

function createBlogCard(response) {
    const createdAtDay = formattedCreatedAt(response);
    return `<div class="card bg-neutral text-white w-[90vw] md:w-[60vw]" >
        <div class="card-body">
            <p class="text-[0.6rem] text-gray-400" >${createdAtDay}</p>
            <p class="text-[0.8rem] text-gray-400">${
                response.is_private ? "Private" : "Public"
            }</p>
            <p class="text-[0.8rem]">Author: ${response.username}</p>
            <h2 class="card-title">${response.blog_title}</h2>
            <p>${response.blog_description}</p>
        </div>
    </div>`;
}

function storeBlog() {
    $("#add-blog").on("submit", function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "dashboard/store",
            data: $(this).serialize(),
            success: function (response) {
                const blogCard = createBlogCard(response);
                $("#blog-container").prepend(blogCard);
                $(".error-message").addClass("hidden");
                $("#add-blog")[0].reset();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = "<ul>";
                    for (const key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            errors[key].forEach(function (error) {
                                errorMessage += `<li>${error}</li>`;
                            });
                        }
                    }
                    errorMessage += "</ul>";
                    $(".error-message").removeClass("hidden");
                    $(".error-message").html(`<span>${errorMessage}</span>`);
                }
            },
        });
    });
}

function activateContentEditable() {
    $(".edit-content").click(function () {
        const blogId = $(this).data("id");
        console.log(blogId);
        $(`.blog-edit[data-id="${blogId}"]`)
            .attr("contenteditable", "true")
            .focus();
        $(".edit-content").addClass("hidden");
        $(`.save-edit[data-id="${blogId}"]`).removeClass("hidden");
        $(`.cancel-edit[data-id="${blogId}"]`).removeClass("hidden");
    });
}

function cancelEdit() {
    $(".cancel-edit").click(function (e) {
        const blogId = $(this).data("id");
        e.preventDefault();
        $(`.blog-edit-container[data-id="${blogId}"]`)[0].reset();
        $(`.blog-edit[data-id="${blogId}"]`).attr("contenteditable", "false");
        $(`.save-edit[data-id="${blogId}"]`).addClass("hidden");
        $(this).addClass("hidden");
        $(".edit-content").removeClass("hidden");
    });
}

function updateContent() {
    $(".blog-edit-container").on("submit", function (e) {
        e.preventDefault();
        const blogId = $(this).data("id");
        const blogTitle = $('h2[data-id="' + blogId + '"]')
            .text()
            .trim();
        const blogDescription = $('p[data-id="' + blogId + '"]')
            .text()
            .trim();
        $.ajax({
            type: "PUT",
            url: "profile/update/" + blogId,
            data: {
                blog_title: blogTitle,
                blog_description: blogDescription,
                _method: "PUT", // For method spoofing
                _token: $('meta[name="csrf-token"]').attr("content"), // CSRF token
            },
            success: function (response) {
                $(".edit-content").removeClass("hidden");
                $(".save-edit").addClass("hidden");
                $(".cancel-edit").addClass("hidden");
            },
        });
    });
}

function execute() {
    $(document).ready(function () {
        setUpCsrfToken();
        storeBlog();
        activateContentEditable();
        updateContent();
        cancelEdit();
    });
}

execute();

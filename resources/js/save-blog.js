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
                const createdAtDay = response.created_today
                    ? response.created_hours_ago > 0
                        ? `${response.created_hours_ago} hour ${
                              response.created_hours_ago > 1 ? "s" : ""
                          } ago`
                        : `${response.created_minutes_ago} min ${
                              response.created_minutes_ago > 1 ? "s" : ""
                          } ago`
                    : response.created_yesterday
                    ? `${response.created_days_ago}`
                    : `${response.created_long_ago}`;
                $("#blog-container").prepend(
                    `<div class="card bg-neutral text-white w-[90vw] md:w-[60vw]">
                <div class="card-body">
                <p class="text-[0.6rem] text-gray-400">${createdAtDay}</p>
                <p class="text-[0.8rem] text-gray-400">${
                    response.is_private ? "Private" : "Public"
                }</p>
                        <p class="text-[0.8rem]">Author: ${
                            response.username
                        }</p>
                    <h2 class="card-title">${response.blog_title}</h2>
                    <p>${response.blog_description}</p>
                </div>
                </div>`
                );
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

function execute() {
    $(document).ready(function () {
        setUpCsrfToken();
        storeBlog();
    });
}

execute();

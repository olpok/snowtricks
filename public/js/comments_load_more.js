//Comments load more
$(function () {
    var page = 1;
    var id = window.location.pathname.split('-')[1];

    $("#comments-load-more").on("click", function () {
        page++;
        $.ajax({
            url: "/commentLM",
            data: {
                page: page,
                id: id
            },
            success: function (html) {
                $("#comments").append(html);
            }
        });
    })
})
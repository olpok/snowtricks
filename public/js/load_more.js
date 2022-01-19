//Load more
$(function () {
    var page = 1;

    $("#load-more").on("click", function () {
        page++;

        $.ajax({
            url: "/listLM",
            data: {
                page: page
            },
            success: function (html) {
                $("#tricks").append(html);
            }
        });
    })
})
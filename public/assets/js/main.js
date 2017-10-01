$(document).ready(function () {
    // Pass the CSRF Token with all ajax requests
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': getCSRFToken()}
    });

    $(".delete-article").on("click", function (e) {
        e.preventDefault();

        var $article = $(this).parents("article").first();
        var title = $(this).data("title");
        var url = $(this).attr("href");

        $.Zebra_Dialog('Are you sure you want to delete <span>"' + title + '"</span>?', {
            "type": "question",
            "title": "Confirm Deletion",
            onClose: function (caption) {
                if (caption === "Yes") deletePost();
            }
        });

        function deletePost() {
            $.ajax({
                method: 'DELETE',
                url: url,
                complete: function (response) {
                    if (response.success) {
                        $article.fadeOut(500, function () {
                            $article.remove();
                        });
                    } else {
                        $.Zebra_Dialog(response.message), {
                            "type": "error"
                        };
                    }
                }
            });
        }
    })
});

// ------------------------------------------------------------------------

// Get the CSRF Token
function getCSRFToken() {
    return $("body").data("csrf-token");
}
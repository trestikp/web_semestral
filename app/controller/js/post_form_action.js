$(document).on('click', '#post_action', function() {
    $.ajax("/web_semestral/public/post/submit_post", {
        type: "GET",
        data: $('#post_form').serialize(),
    }).done(function (re) {
        console.log($('#post_form').serialize());
    });
});
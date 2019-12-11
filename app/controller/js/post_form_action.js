$(document).on('click', '#post_action', function() {
    $.ajax("/web_semestral/public/post/submit_post", {
        type: "GET",
        data: $('#post_form').serialize(),
    }).done(function () {
        window.location.replace("/web_semestral/public/post/submit_success");
        // console.log($('#post_form').serialize());
    });
});

$(document).on('click', '#my_posts_red', function() {
    // $.ajax("/web_semestral/public/");
    //     .done(function () {
    //     // window.location.replace("/web_semestral/public/post/submit_success");
    //     // console.log($('#post_form').serialize());
    // });
});

$(document).on('click', '#new_post_red', function() {
    window.location.replace("/web_semestral/public/post/index");
});
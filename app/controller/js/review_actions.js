$(document).on('click', '#send_review', function () {
    // let c1 = $('#criterium_1 option:selected').val();
    // let c2 = $('#criterium_2 option:selected').val();
    // let c3 = $('#criterium_3 option:selected').val();
    // let overall = $('#overall option:selected').val();
    // let comment = $('#review_comment').val();
    // console.log(c1);
    // console.log(c2);
    // console.log(c3);
    // console.log(overall);
    // console.log(comment);

    let form = $('#review_form').serialize();
    console.log(form);
    $.ajax("/web_semestral/public/review/submit_review", {
        data: $('#review_form').serialize(),
        type: "POST"
    }).done(function () {
        window.location.replace("/web_semestral/public/review/success");
    })
});

$(document).on('click', '#goto_reviews', function () {
    window.location.replace("/web_semestral/public/review/index");
});
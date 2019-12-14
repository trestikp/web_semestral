$(document).on('click', '#post_action', function() {
    // $.ajax("/web_semestral/public/post/submit_post", {
    //     type: "POST",
    //     data: $('#post_form').serialize(),
    // }).done(function (re) {
    //     console.log(re);
    //     window.location.replace("/web_semestral/public/post/submit_success");
    //     // console.log($('#post_form').serialize());
    // });


    let file_data = $('#pdf_input').prop('files')[0];
    let form_data = new FormData($('#post_form')[0]);
    form_data.append('pdf_input', file_data);

    $.ajax("/web_semestral/public/post/submit_post", {
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: "POST"
    }).done(function (re) {
        try {
            let arr = JSON.parse(re);

            switch (arr['code']) {
                case 0: window.location.replace("/web_semestral/public/post/submit_success"); break;
                case 1: empty_title(); break;
                case 2: empty_description(); break;
                case 3: wrong_extension(); break;
                case 4: oversize(); break;
                case 5: upload_error(); break;
            }
        } catch (e) {
            // do nothing
        }
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

function empty_title() {
    $('#post_error').text("Musíte zadat titul!");
}

function empty_description() {
    $('#post_error').text("Musíte zadat popisek!");
}

function wrong_extension() {
    $('#post_error').text("Vybraný soubor není pdf!");
}

function oversize() {
    $('#post_error').text("Soubor je příliš velký!");
}

function upload_error() {
    $('#post_error').text("Upload se nezdařil (chyba serveru).");
}
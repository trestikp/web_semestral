function submitForm(action) {
    if(action == "login") {
        $.ajax("/web_semestral/public/login_controller/verify", {
            type: "POST",
            data: $("#login_form").serialize()
        }).done(function (re) {
            // console.log(re);
            switch (re) {
                case '1': login_error("Uživatel neexistuje!"); return;
                case '3': login_error("Špatné heslo!"); return;
            }

            let cur_url = window.location.href;
            window.location.replace("/web_semestral/public/login_controller/log_in_user");
            window.location.replace(cur_url);
        });

    } else if (action == "register") {
        window.location.replace("/web_semestral/public/registration/index");
    }
}

function login_error(msg) {
    $('#log_error').text(msg);
}

$(document).on('click', '#reg_cancel', function () {
    // WTF goes back to random page ??
    window.history.back();
    // console.log(window .history.toString());
    // window.history.back();
    // window.history.back(-1);
});

function logOut() {
    let cur_url = window.location.href;

    // using ajax, because otherwise the cur_url is back before the
    // php function is finished
    $.ajax({
        url: "/web_semestral/public/login_controller/log_out_user"
    }).done(function () {
        window.location.replace(cur_url);
    });
}

$(document).on('click', '#logout', logOut);

// document.addEventListener("click", function (e) {
//     if (e.target && e.target.id == "logout") {
//         logOut();
//     }
// })

// element.onclick(logOut());
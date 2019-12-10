function submitForm(action) {
    if(action == "login") {
        $.ajax("/web_semestral/public/login_controller/verify", {
            type: "POST",
            data: $("#login_form").serialize(),
        }).done(function (re) {
            // alert(re);
            let cur_url = window.location.href;
            window.location.replace("/web_semestral/public/login_controller/log_in_user");
            window.location.replace(cur_url);
            // console.log(re);
        }).fail(function () {
            //TODO: don't forget to remove this please
            alert("FUCK");
        });

    } else if (action == "register") {
        let cur_url = window.location.href;
        window.location.replace("/web_semestral/public/login_controller/log_in_user");
        window.location.replace(cur_url);
    }
}

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
function submitForm(action) {
    if(action == "login") {
        // $.ajax({
        //     url: "/web_semestral/public/login/index",
        //     type: "post",
        //     data: $("#login_form").serialize(),
        //     success: function (re) {
        //         alert(re);
        //     }
        // });


        // $.ajax("/web_semestral/public/login/verify", {
        //     type: "POST",
        //     data: $("#login_form").serialize(),
        // }).done(function (re) {
        //     alert(re);
        // }).fail(function () {
        //     alert("FUCK");
        // })

        $.ajax("/web_semestral/public/login_controller/verify", {
            type: "POST",
            data: $("#login_form").serialize(),
        })
            .done(function (re) {
            // alert(re);
            let cur_url = window.location.href;
            window.location.replace("/web_semestral/public/login_controller/log_in_user");
            window.location.replace(cur_url);
            // console.log(re);
        }).fail(function () {
            alert("FUCK");
        });

        // $.ajax("../login", {
        //     type: "POST",
        //     data: $("#login_form").serialize(),
        // }).done(function (re) {
        //     alert(re);
        // }).fail(function () {
        //     alert("FUCK");
        // })
    } else if (action == "register") {
        let cur_url = window.location.href;
        window.location.replace("/web_semestral/public/login_controller/log_in_user");
        window.location.replace(cur_url);
    }
}

function logOut() {
    let cur_url = window.location.href;
    window.location.replace("/web_semestral/public/login_controller/log_out_user");
    window.location.replace(cur_url);
}
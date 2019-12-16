$(document).on('click', '.r_manage_btn', function () {
    let $id = this.id;

    if ($id.substring(2, 6) == "deny") {
        let $p_id = get_id($id.substring(7));
        let $p_title = get_title($id.substring(7));

        $.ajax("/web_semestral/public/r_mngmnt/deny", {
            data: {p_id: $p_id, p_title: $p_title},
            type: "POST"
        }).done(function (re) {
            window.location.reload(false);
            // console.log(re);
        });
    } else if ($id.substring(2, 8) == "accept") {
        let $p_id = get_id($id.substring(9));
        let $p_title = get_title($id.substring(9));

        $.ajax("/web_semestral/public/r_mngmnt/accept", {
            data: {p_id: $p_id, p_title: $p_title},
            type: "POST"
        }).done(function (re) {
            window.location.reload(false);
            // console.log(re);
        });
    } else {
        //do wtf
    }
});

function get_id($str) {
    let $res = '';
    let $ptr = 0;

    while($str.charAt($ptr) != '_') {
        $res += $str.charAt($ptr);
        $ptr++;
    }

    return $res;
}

function get_title($str) {
    let $ptr = 0;

    while($str.charAt($ptr) != '_') {
        $ptr++;
    }

    return $str.substring($ptr + 1);
}
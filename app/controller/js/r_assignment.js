$(document).on('click', '.r_adding', function () {
    let selected = get_selected(this.id);
    let id = get_id(this.id);

    $.ajax("/web_semestral/public/r_assignment/add_review_queue", {
        data: {p_id: id, r_id: selected},
        type: "POST"
    }).done(function (re) {
        window.location.reload(false);
        // console.log(re);
    });
});

function get_index(id) {
    return id.charAt(id.length - 1);
}

function get_id(id) {
    let res = '';
    let ptr = 2;

    while(id.charAt(ptr) != '_') {
        res += id.charAt(ptr);
        ptr++;
    }

    return res;
}

function get_selected(id) {
    // $('#criterium_1 option:selected').val();
    let index = get_index(id);
    id = get_id(id);
    let selector = "r_" + id + "_select" + index;

    return $('#' + selector).val();
}
// let nav = document.getElementById('navigation');
// let links = nav.getElementsByClassName('page');
//
// for (let i = 0; i < links.length; i++) {
//     links[i].addEventListener('click', function () {
//         let current = document.getElementsByClassName('active');
//         current[0].className = current[0].className.replace("active", "");
//         this.className += "active";
//     });
// }

// $(document).on('click', '#navigation', function () {
//     let nav = document.getElementById('navigation');
//     let links = nav.getElementsByClassName('page');
//
//     for (let i = 0; i < links.length; i++) {
//         links[i].addEventListener('click', function () {
//             let current = document.getElementsByClassName('active');
//             current[0].className = current[0].className.replace("active", "");
//             this.className += "active";
//         });
//     }
// });

// $(document).on('click', '#link', function () {
//     $
//    // let link = document.getElementById('link');
//    // let current = document.getElementsByClassName('active');
//    // if(current != null)
//    // current[0].className = current[0].className.replace("active", "");
//    // link.classList.add('active');
// });

$(document).on('click', '.navigation-link', function () {
    $('ul li a.active').removeClass('active');
    $(this).addClass('active');

    // $.ajax('/web_semestral/public/controller/active_nav_link', {
    //     data: {active_l: $(this).text()},
    //     type: "POST"
    // });
    // $(this).load('controller/active_nav_link/active_l?' + $(this).text());
});
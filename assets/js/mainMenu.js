$(function () {
    $('#nav_btn').on('click', function () {
        $(this).toggleClass("click");
        $('#sidebar').toggleClass("show");

        // $('#sidebar').hasClass('show') ? $('#active_sidebar_div').css('background-color', 'rgba(0, 0, 0, .5)') : $('#active_sidebar_div').css('background-color', '');
        if ($('#sidebar').hasClass('show')) {
            $('#active_sidebar_div').addClass('d-block');
            $('#active_sidebar_div').removeClass('d-none');
        } else {
            $('#active_sidebar_div').addClass('d-none');
            $('#active_sidebar_div').removeClass('d-block');
        }
    });


    $('#sidebar ul li a').on('click', function () {
        var id = $(this).attr('id');
        $('#sidebar ul li ul.item-show-' + id).toggleClass("show");
        $('#sidebar ul li #' + id + ' span').toggleClass("rotate");

    });

    // $('#sidebar ul li').on('click', function () {
    //     $(this).addClass("active").siblings().removeClass("active");
    // });

})
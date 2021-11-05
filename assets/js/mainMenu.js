$(function () {

    $('#nav_btn').on('click', function () {
        $(this).toggleClass("click");
        $('#sidebar').toggleClass("show");

        if ($('#sidebar').hasClass('show')) {
            $('#active_sidebar_div').addClass('d-block');
            $('#active_sidebar_div').removeClass('d-none');
        } else {
            $('#active_sidebar_div').addClass('d-none');
            $('#active_sidebar_div').removeClass('d-block');
        }
    });

    $('#active_sidebar_div').on('click', function () {
        $('#nav_btn').trigger('click');
    });


    $('#sidebar ul li a').on('click', function () {
        var id = $(this).attr('id');
        $('#sidebar ul li ul.item-show-' + id).toggleClass("show");
        $('#sidebar ul li #' + id + ' span').toggleClass("rotate");
    });

})
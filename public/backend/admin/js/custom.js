
$(document).ready(function () {
    //Select 2
    $("select.form-control:not(.no-select)").select2();


    // Slug Generate
    $("#title").on("keyup", function () {
        const titleValue = $(this).val().trim();
        const slugValue = generateSlug(titleValue);
        $("#slug").val(slugValue);
    });

    $('.showpassword').on('click', function () {
        if ($(this).parent().find('input').attr('type') == 'password') {
            $(this).parent().find('input').attr('type', 'text');
            $(this).find('i').removeClass('fas fa-eye-slash').addClass('fas fa-eye');
        } else {
            $(this).parent().find('input').attr('type', 'password');
            $(this).find('i').removeClass('fas fa-eye').addClass('fas fa-eye-slash');
        }
    });

});
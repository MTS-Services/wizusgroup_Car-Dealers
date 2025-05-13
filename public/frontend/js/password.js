
$('.showpassword').on('click', function () {
  if ($(this).parent().find('input').attr('type') == 'password') {
    $(this).parent().find('input').attr('type', 'text');
    // $(this).find('i').attr('data-lucide', 'eye');
  } else {
    $(this).parent().find('input').attr('type', 'password');
    // $(this).find('i').attr('data-lucide', 'eye-off');
  }
});

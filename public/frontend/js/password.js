$('.showpassword').on('click', function () {
  const $input = $(this).parent().find('input');
  const $icon = $(this).find('i');

  if ($input.attr('type') === 'password') {
    $input.attr('type', 'text');
    $icon.removeClass('fa-eye-slash').addClass('fa-eye');
  } else {
    $input.attr('type', 'password');
    $icon.removeClass('fa-eye').addClass('fa-eye-slash');
  }
});

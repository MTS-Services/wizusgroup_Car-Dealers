
// Toggle search form visibility on button click
$('.toggle-search-btn').on('click', function (e) {
  e.stopPropagation(); // Prevent the click from bubbling to window

  const $container = $(this).closest('.search-container');
  const $form = $container.find('.searchForm');

  $form.toggleClass('opacity-0');
  $form.toggleClass('pointer-events-none');
  $form.toggleClass('scale-95');
  $form.toggleClass('scale-100');
  $form.toggleClass('opacity-100');
});

// Hide any open search form when clicking outside
$(window).on('click', function (e) {
  $('.search-container').each(function () {
    const $container = $(this);
    if (!$container.is(e.target) && $container.has(e.target).length === 0) {
      const $form = $container.find('.searchForm');
      if ($form.hasClass('opacity-100')) {
        $form.addClass('opacity-0 pointer-events-none scale-95');
        $form.removeClass('opacity-100 scale-100');
      }
    }
  });
});

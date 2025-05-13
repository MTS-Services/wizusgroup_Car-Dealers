$(document).ready(function () {
  const $openSidebar = $('.openFilterSidebar');
  const $closeSidebar = $('.closeFilterSidebar');
  const $sidebar = $('.filterSidebar'); // Select the sidebar element globally

  // Sidebar open functionality
  $openSidebar.on('click', function () {
    $sidebar.css('transform', 'translateX(0)'); // Show the sidebar
    // $(this).addClass('hidden'); // Hide the open button
  });

  $closeSidebar.on('click', function () {
    $sidebar.css('transform', 'translateX(-100%)'); // Hide the sidebar
    setTimeout(() => {
      // $openSidebar.removeClass('hidden'); // Show all openSidebar buttons
    }, 300); // Delay for the sidebar transition
  });

  // Price Range
  const $minRange = $('#min-ranges');
  const $maxRange = $('#max-ranges');
  const $sliderRange = $('#slider-ranges');
  const $minPrice = $('#min-prices');
  const $maxPrice = $('#max-prices');

  function updateSlider() {
    const minVal = parseInt($minRange.val());
    const maxVal = parseInt($maxRange.val());
    const minPercent = (minVal / parseInt($minRange.attr('max'))) * 100;
    const maxPercent = (maxVal / parseInt($maxRange.attr('max'))) * 100;

    $sliderRange.css({
      left: minPercent + '%',
      width: (maxPercent - minPercent) + '%'
    });

    $minPrice.text('$' + minVal);
    $maxPrice.text('$' + maxVal);
  }

  // Set initial positions
  updateSlider();

  // Event listeners
  $minRange.on('input', function () {
    if (parseInt($minRange.val()) > parseInt($maxRange.val()) - 10) {
      $minRange.val(parseInt($maxRange.val()) - 10);
    }
    updateSlider();
  });

  $maxRange.on('input', function () {
    if (parseInt($maxRange.val()) < parseInt($minRange.val()) + 10) {
      $maxRange.val(parseInt($minRange.val()) + 10);
    }
    updateSlider();
  });

});

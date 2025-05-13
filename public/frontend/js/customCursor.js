$(document).ready(function () {
  const $cursorWrapper = $('.cursor-wrapper');
  const $cursor = $('.custom-cursor');

  // Move the wrapper with the mouse
  $(document).on('mousemove', function (e) {
    const x = e.clientX;
    const y = e.clientY;
    $cursorWrapper.css('transform', `translate(${x}px, ${y}px) translate(-50%, -50%)`);

    // Randomly create stars (less frequent)
    // if (Math.random() < 0.3) {
    //     createStarTopLeft(x, y);
    // }
  });

  // Add animation on click
  $(document).on('mousedown', function () {
    $cursor.addClass('click');
  });

  $(document).on('mouseup', function () {
    $cursor.removeClass('click');
  });

  // Add pulsing effect when hovering over buttons and links
  $('a, button').hover(
    function () {
      $cursor.addClass('animate-scalePulse');
    },
    function () {
      $cursor.removeClass('animate-scalePulse');
    }
  );

  // Create colorful stars rising from the top-left corner of the circle
  // function createStarTopLeft(x, y) {
  //     const $star = $('<div class="star"></div>');

  //     // Add random colors
  //     const colors = ['#FF5733', '#33FF57', '#5733FF', '#FFFF33', '#33FFFF'];
  //     const color = colors[Math.floor(Math.random() * colors.length)];
  //     $star.css('background', `radial-gradient(circle, ${color}, transparent)`);

  //     // Position the star
  //     const offsetX = -10;
  //     const offsetY = -10;
  //     $star.css({
  //         position: 'absolute',
  //         left: `${x + offsetX}px`,
  //         top: `${y + offsetY}px`,
  //     });

  //     // Append to body and remove after animation
  //     $('body').append($star);
  //     $star.on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function() {
  //         $(this).remove();
  //     });
  // }
});
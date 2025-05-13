$(document).ready(function () {
  const $openSidebar = $('.openSidebar');
  const $closeSidebar = $('.closeSidebar');
  const $sidebar = $('.sidebar'); // Select the sidebar element globally

  const $firstNavbar = $('#first-navbar');
  const $secondNavbar = $('#second-navbar');
  let lastScrollPosition = 0;

  // Sidebar open functionality
  $openSidebar.on('click', function () {
    $sidebar.css('transform', 'translateX(0)'); // Show the sidebar
    // $(this).addClass('hidden'); // Hide the open button
  });

  // Sidebar close functionality
  $closeSidebar.on('click', function () {
    $sidebar.css('transform', 'translateX(100%)'); // Hide the sidebar
    setTimeout(() => {
      // $openSidebar.removeClass('hidden'); // Show all openSidebar buttons
    }, 300); // Delay for the sidebar transition
  });

  // // Scroll event listener for navbar transitions
  // $(window).on('scroll', function() {
  //     const scrollPosition = $(this).scrollTop();

  //     // Scrolling down
  //     if (scrollPosition > 50 && scrollPosition > lastScrollPosition) {
  //         $firstNavbar.removeClass('navbar-show').addClass('navbar-hide');
  //         $secondNavbar.removeClass('navbar-hide').addClass('navbar-show');
  //     }
  //     // Scrolling up
  //     else if (scrollPosition < lastScrollPosition && scrollPosition <= 50) {
  //         $firstNavbar.removeClass('navbar-hide').addClass('navbar-show');
  //         $secondNavbar.removeClass('navbar-show').addClass('navbar-hide');
  //     }

  //     // Update last scroll position
  //     lastScrollPosition = scrollPosition;
  // });
});
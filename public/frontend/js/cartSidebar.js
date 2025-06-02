$(document).ready(function () {
    const $openSidebar = $('.openCartSidebar');
    const $closeSidebar = $('.closeCartSidebar');
    const $sidebar = $('.cartSidebar'); // Select the sidebar element globally

    // Sidebar open functionality
    $openSidebar.on('click', function () {
        $sidebar.css('transform', 'translateX(0)'); // Show the sidebar
        // $(this).addClass('hidden'); // Hide the open button
    });

    $closeSidebar.on('click', function () {
        $sidebar.css('transform', 'translateX(100%)'); // Hide the sidebar
        setTimeout(() => {
            // $openSidebar.removeClass('hidden'); // Show all openSidebar buttons
        }, 300); // Delay for the sidebar transition
    });
});

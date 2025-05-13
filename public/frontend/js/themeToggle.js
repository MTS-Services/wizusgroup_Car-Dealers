
$(document).ready(function () {
  const $html = $('#html');
  const $themeToggle = $('.theme-toggle');
  const $darkModeLogos = $('.dark-mode-logo');
  const $lightModeLogos = $('.light-mode-logo');

  // Load saved theme
  const savedTheme = localStorage.getItem('theme') || 'light';
  setTheme(savedTheme);

  // Toggle theme on any switch change
  $themeToggle.on('change', function () {
    const newTheme = $(this).is(':checked') ? 'dark' : 'light';
    setTheme(newTheme);
  });

  function setTheme(theme) {
    $html.removeClass('light dark').addClass(theme).attr('data-theme', theme);
    localStorage.setItem('theme', theme);
    toggleLogos(theme);
    $themeToggle.prop('checked', theme === 'dark');
  }

  function toggleLogos(theme) {
    if (theme === 'dark') {
      $darkModeLogos.removeClass('hidden');
      $lightModeLogos.addClass('hidden');
    } else {
      $darkModeLogos.addClass('hidden');
      $lightModeLogos.removeClass('hidden');
    }
  }
});

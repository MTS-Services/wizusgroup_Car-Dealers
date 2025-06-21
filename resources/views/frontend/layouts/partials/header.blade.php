<section>
  <!-- Header -->
  <header class="bg-bg-light dark:bg-bg-dark-secondary px-4 py-4 sm:py-6 border-b border-gray-200 dark:border-bg-dark-secondary">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row flex-wrap items-center justify-between gap-3 sm:gap-4">
      
      <!-- Left Side (Logo + Info) -->
      <div class="flex flex-col lg:flex-row items-start md:items-center gap-3 md:gap-4 w-full lg:w-auto">
        <!-- Logo -->
        <div class="w-full lg:w-auto flex justify-between items-center">
          <a href="{{ url('/') }}" class="flex-shrink-0">
            <img src="{{ settings('site_logo') ? storage_url(settings('site_logo')) : asset('frontend/images/logo.png') }}" 
                 alt="Logo" 
                 class="w-24 sm:w-28 h-auto">
          </a>
          <!-- Mobile menu toggle (visible on xs and lg+) -->
          <button id="mobile-menu-toggle" class="lg:hidden text-gray-700 dark:text-white focus:outline-none text-2xl">
            ☰
          </button>
        </div>

        <!-- Info: Time & Search -->
        <div class="flex flex-col gap-2 w-full lg:w-auto">
          <!-- Japan Time -->
          <div class="flex items-center text-gray-700 dark:text-white text-sm tablet:text-base">
            <i class="fas fa-clock mr-2 text-gray-500 dark:text-gray-300"></i>
            <span style="word-spacing: 0.5rem;" class="font-medium">Japan Time 13:33</span>
          </div>

          <!-- Search -->
          <div class="flex w-full">
            <input type="text" placeholder="Search Keyword"
              class="px-3 py-2 w-full xs:w-40 text-sm bg-white dark:bg-bg-dark border border-gray-300 dark:border-gray-600 rounded-l focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
            <button class="bg-bg-primary text-white px-3 py-2 rounded-r hover:bg-bg-primary/80 transition-colors">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Right Side (Buttons + Lang/Theme) -->
      <div class="flex flex-col xs:flex-row items-center gap-2 w-full xs:w-auto justify-end">
        <div class="flex flex-row gap-2 w-full xs:w-auto">
          <a href="{{ route('register') }}" class="bg-bg-wiz_orange w-full xs:w-44 text-center text-white py-2 text-xs sm:text-sm font-medium hover:bg-bg-wiz_orange/80 transition-colors rounded">
            Member Registration
          </a>
          <a href="{{ route('login') }}" class="bg-bg-black text-center w-full xs:w-40 text-white px-4 sm:px-6 py-2 text-xs sm:text-sm hover:bg-bg-dark-tertiary/90 transition-colors rounded">
            Login
          </a>
        </div>
        <div class="flex flex-row items-center gap-2 w-full xs:w-auto justify-between xs:justify-end">
          <span class="xs:hidden flex items-center text-gray-700 dark:text-white text-sm">
            <i class="fas fa-globe mr-2"></i> Language
          </span>
          <span class="hidden sm:flex">
            <x-frontend.language />
          </span>
          <div class="border p-[3px] !pl-3 border-blue-500 text-center dark:border-gray-600 hidden sm:flex">
            <x-frontend.theme />
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Navigation Bar - Visible on medium and small screens -->
  <nav class="hidden lg:block bg-bg-primary dark:bg-bg-dark-tertiary text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex tablet:justify-between items-center ">
        <!-- Main Menu Links -->
        <div id="menu-items" class="hidden xs:flex flex-wrap items-center w-full xs:w-auto space-x-0 sm:space-x-1">
          <a href="{{ url('/') }}" class="py-4 px-3 sm:px-4 lg:pl-1 tablet:px-6 xl:px-10 hover:bg-blue-800 transition-colors font-medium text-sm tablet:text-base">
            <span>Home ▼</span>
          </a>
          <a href="{{ route('frontend.about') }}" class="py-4 px-3 sm:px-4 lg:pl-1 tablet:px-6 xl:px-10 hover:bg-blue-800 transition-colors font-medium text-sm tablet:text-base">
            <span>About Us ▼</span>
          </a>
          <a href="{{ route('frontend.group_shipping') }}" class="py-4 px-3 sm:px-4 lg:pl-1 tablet:px-6 xl:px-10 hover:bg-blue-800 transition-colors font-medium text-sm tablet:text-base">
            <span>Group Shipping ▼</span>
          </a>
          <a href="{{ route('frontend.products') }}" class="py-4 px-3 sm:px-4 lg:pl-1 tablet:px-6 xl:px-10 hover:bg-blue-800 transition-colors font-medium text-sm tablet:text-base">
            <span>Products ▼</span>
          </a>
          <a href="{{ route('frontend.parts-accessories') }}" class="py-4 px-3 sm:px-4 lg:pl-1 tablet:px-6 xl:px-10 hover:bg-blue-800 transition-colors font-medium text-sm tablet:text-base">
            <span>Parts & Accessories ▼</span>
          </a>
          <a href="{{ route('frontend.contact') }}" class="py-4 px-3 sm:px-4 lg:pl-1 tablet:pl-6 xl:px-10 hover:bg-blue-800 transition-colors font-medium text-sm tablet:text-base">
            <span>Contact ▼</span>
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Mobile Menu Items - Visible when toggled on small and large screens -->
  <div id="mobile-menu" class="hidden bg-bg-primary dark:bg-bg-dark-tertiary text-white px-4">
    <a href="{{ url('/') }}" class="block py-3 border-b border-white/10 text-sm">Home ▼</a>
    <a href="{{ route('frontend.about') }}" class="block py-3 border-b border-white/10 text-sm">About Us ▼</a>
    <a href="{{ route('frontend.group_shipping') }}" class="block py-3 border-b border-white/10 text-sm">Group Shipping ▼</a>
    <a href="{{ route('frontend.products') }}" class="block py-3 border-b border-white/10 text-sm">Products ▼</a>
    <a href="{{ route('frontend.parts-accessories') }}" class="block py-3 border-b border-white/10 text-sm">Parts & Accessories ▼</a>
    <a href="{{ route('frontend.contact') }}" class="block py-3 border-b border-white/10 text-sm">Contact ▼</a>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const toggleBtn = document.getElementById('mobile-menu-toggle');
      const mobileMenu = document.getElementById('mobile-menu');

      if (toggleBtn && mobileMenu) {
        toggleBtn.addEventListener('click', () => {
          mobileMenu.classList.toggle('hidden');
          // Toggle aria-expanded attribute for accessibility
          const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
          toggleBtn.setAttribute('aria-expanded', !isExpanded);
        });
      }
    });
  </script>
</section>
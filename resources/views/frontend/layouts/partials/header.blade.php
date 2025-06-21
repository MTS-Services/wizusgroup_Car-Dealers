<section>
    <header
        class="bg-bg-light dark:bg-bg-dark-secondary px-4 py-3 border-b border-gray-200 dark:border-bg-dark-secondary">
        <div class="flex justify-between max-w-7xl mx-auto">
            <!-- Logo -->
            <div class="flex items-center">
                <div class="w-30 h-30 flex items-center justify-center mr-4">
                    <a href="{{ url('/') }}" class="">
                        <img src="{{ settings('site_logo') ? storage_url(settings('site_logo')) : asset('frontend/images/logo.png') }}"
                            alt="Logo" class="w-28">
                    </a>
                </div>

                <!-- Center Section with Time and Search -->
                <div class="items-center space-y-4">
                    <!-- Japan Time -->
                    <div class="flex items-center text-gray-700 text-base">
                        <i class="fas fa-clock mr-2 text-gray-500"></i>
                        <span style="word-spacing: 0.5rem;" class="font-medium dark:text-white">Japan Time 13:33</span>
                    </div>

                    <!-- Search Bar -->
                    <div class="flex">
                        <input type="text" placeholder="Search Keyword"
                            class="px-3 py-2.5 w-40 text-sm bg-white dark:bg-bg-dark border border-gray-300 dark:border-gray-600 rounded-l focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                        <button
                            class="bg-bg-primary text-white px-3 py-2.5 rounded-r hover:bg-bg-primary transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="flex items-center space-x-2 py-4">
                <button
                    class="bg-bg-wiz_orange w-44 text-white py-2.5 text-sm font-medium hover:bg-bg-wiz_orange/80 transition-colors rounded">
                    Member Registration
                </button>
                <button
                    class="bg-bg-black w-40 text-white px-6 py-2.5 text-sm hover:bg-bg-dark-tertiary/90 transition-colors rounded">Login</button>

                <span class="hidden tablet:flex">
                    <x-frontend.language />
                </span>


                <div class="border p-[3px] !pl-3 border-blue-500 dark:border-gray-600">
                    <span class="hidden tablet:flex"><x-frontend.theme /></span>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation Bar -->
    <nav class="bg-bg-primary dark:bg-bg-dark-tertiary text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center">
                <a href="{{ url('/') }}"
                    class="py-4 hover:bg-blue-800 px-12 cursor-pointer transition-colors font-medium">
                    <span class="text-base">Home ▼</span>
                </a>

                <a href="{{ route('frontend.about') }}"
                    class="py-4 hover:bg-blue-800 px-12 cursor-pointer transition-colors font-medium ">
                    <span class="text-base">About Us ▼</span>
                </a>

                <a href="{{ route('frontend.group_shipping') }}"
                    class="py-4 hover:bg-blue-800 px-12 cursor-pointer transition-colors font-medium ">
                    <span class="text-base">Group Shipping ▼</span>
                </a>

                <a href="{{ route('frontend.products') }}"
                    class="py-4 hover:bg-blue-800 px-12 cursor-pointer transition-colors font-medium ">
                    <span class="text-base">Products ▼</span>
                </a>

                <a href="{{ route('frontend.parts-accessories') }}"
                    class="py-4 hover:bg-blue-800 px-12 cursor-pointer transition-colors font-medium ">
                    <span class="text-base">Parts & Accessories ▼</span>
                </a>

                <a href="{{ route('frontend.contact') }}"
                    class="py-4 hover:bg-blue-800 px-12 cursor-pointer transition-colors font-medium ">
                    <span class="text-base">Contact ▼</span>
                </a>
            </div>
        </div>
    </nav>

</section>

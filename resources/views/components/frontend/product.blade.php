 <div class="product-card bg-bg-light dark:bg-bg-dark-tertiary  w-full hover:translate-y-[-8px] hover:shadow-lg dark:hover:shadow-dark-card transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
     data-product="1">
     <!-- Car Image -->
     <div class="relative">
         <div class="w-full overflow-hidden">
             <img src="{{ asset('frontend/images/products/TAFE-IMT-tractor.png') }}" alt="Kubota ZL1-215"
                 class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
         </div>
         <!-- Timer Badge -->
         <div
             class="absolute z-50 bottom-[-10px] left-3 bg-bg-orange text-text-white px-3 py-1 rounded-md text-sm font-medium">
             {{ __('2d 04h 15m') }}
         </div>
     </div>

     <!-- Card Content -->
     <div class="p-4">
         <h2 class="text-base lg:text-lg font-semibold text-text-primary dark:text-text-light">
             {{ __('Honda CR-V') }}</h2>
         <p class="text-text-danger text-base lg:text-lg font-bold mt-1">{{ __("US$ 4,500") }}</p>
         <div class="flex items-center mt-3 text-text-dark dark:text-text-light text-opacity-50 text-sm">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
             </svg>
             {{ __('All Categories') }}
         </div>
         <div class="flex items-center mt-2 text-text-dark dark:text-text-light text-opacity-50 text-sm">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
             </svg>
             {{ __('Chiba') }}
         </div>

         <!-- Bid Button -->
         <button onclick="openModal()" class="w-full btn-primary hover:bg-bg-tertiary px-4 rounded-md mt-4">
             {{ __('Place Bid') }}
         </button>
     </div>
 </div>

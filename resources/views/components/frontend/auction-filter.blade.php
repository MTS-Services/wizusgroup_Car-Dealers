 @props(['categories', 'companies'])

 <form action="{{ route('frontend.auctions.filter') }}" method="post">
     @csrf
     <div class="space-y-6 shadow-card dark:shadow-dark-card rounded-lg dark:bg-bg-dark-tertiary overflow-hidden mt-3">
         <h2
             class="text-lg md:text-xl font-semibold capitalize border-b bg-bg-light dark:bg-bg-light dark:bg-opacity-20 border-border-gray dark:border-opacity-50 p-4">
             {{ __(' Auction fillters') }}</h2>
         <div class="px-4">
             <h3 class="text-sm md:text-base font-medium">{{ __('Category') }}</h3>

             <select class="select mt-2" name="category">
                 <option value="" selected>All Category</option>
                 @foreach ($categories as $category)
                     <option value="{{ $category->slug }}"
                         {{ request()->category == $category->slug ? 'selected' : '' }}>
                         {{ $category->name }}</option>
                 @endforeach
             </select>
             <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'category']" />

         </div>
         <div class="px-4">
             <h3 class="text-sm md:text-base font-medium">{{ __('Make') }}</h3>
             <select class="select mt-2" name="company">
                 <option value="" selected>Select Make</option>
                 @foreach ($companies as $company)
                     <option value="{{ $company->slug }}" {{ request()->company == $company->slug ? 'selected' : '' }}>
                         {{ $company->name }}</option>
                 @endforeach
             </select>
             <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'company']" />
         </div>
         <div class="px-4">
             <h3 class="text-sm md:text-base font-medium">{{ __('End Time') }}</h3>
             <input type="date" class="input py-0 px-4 mt-2" name="date" value="{{ request()->date }}">
             <span class="date-error text-xs text-red-500"></span>
             <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'date']" />
         </div>
         <div class="px-4 pb-4">
             <button id="filterBtn" class="w-full btn-primary group">
                 <span>{{ __('Filter') }}</span>
                 <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-4 w-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M14 5l7 7m0 0l-7 7m7-7H3" />
                 </svg>
             </button>
         </div>
     </div>
 </form>

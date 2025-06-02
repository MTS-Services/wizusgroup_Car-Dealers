 @extends('frontend.layouts.app', ['page_slug' => 'product_details'])

 @section('title', 'Products Details')
 @section('content')
     {{-- ===================== Product Carousel Section Start ===================== --}}
     <!-- Top-level wrapper -->
     <section class="overflow-x-hidden">
         <div class="product_carousel_section 2xl:py-16 xl:py-12 lg:py-10  py-6  overflow-hidden">
             <div class="container mx-auto overflow-hidden">
                 <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 dark:bg-bg-dark dark:text-text-light">
                     <!-- Left: Image Slider -->
                     <div class="w-full overflow-hidden">
                         <!-- Main Product Slider -->
                         <div class="relative hover-wrapper">
                             <div
                                 class="swiper static product_slider_image w-full max-w-full h-[300px] sm:h-[400px] md:h-[500px] lg:h-[600px] xl:h-[700px] mx-auto bg-bg-light dark:bg-bg-dark-tertiary rounded-lg overflow-hidden">
                                 <div class="swiper-wrapper">
                                     @foreach ($product->images as $image)
                                         <div class="swiper-slide flex items-center justify-center">
                                             <img src="{{ storage_url($image->image) }}"
                                                 alt="{{ $image->alt ?? $product->name }}"
                                                 class="zoomable block w-full h-full object-cover" />
                                         </div>
                                     @endforeach
                                 </div>
                                 <div class="swiper-button swiper-button-prev">
                                     <i data-lucide="chevron-left" class="w-5 h-5 text-blue-800"></i>
                                 </div>
                                 <div class="swiper-button swiper-button-next">
                                     <i data-lucide="chevron-right" class="w-5 h-5 text-blue-800"></i>
                                 </div>
                             </div>
                             <div id="zoomResult"></div>
                             <div id="lens"></div>
                         </div>

                         <!-- Thumbnail Slider -->
                         <div
                             class="swiper product_slider_thumbs h-16 sm:h-20 mt-2 box-border py-1 px-2 bg-bg-light dark:bg-bg-dark-tertiary rounded-lg overflow-hidden">
                             <div class="swiper-wrapper">
                                 @foreach ($product->images as $image)
                                     <div
                                         class="swiper-slide w-1/5 sm:w-1/6 md:w-1/8 h-full opacity-40 transition-opacity duration-300 cursor-pointer hover:opacity-70 swiper-slide-thumb-active:opacity-100 dark:swiper-slide-thumb-active:opacity-100">
                                         <img src="{{ storage_url($image->image) }}"
                                             alt="{{ $image->alt ?? $product->name }}"
                                             class="block w-full h-full object-cover rounded" />
                                     </div>
                                 @endforeach
                             </div>
                         </div>
                     </div>

                     <!-- Right: Product Info -->
                     <div class="w-full">
                         <div class="mx-auto" x-data="{ tab: 'basic' }">
                             <!-- Tabs -->
                             <div
                                 class="flex flex-col xs:flex-row flex-wrap items-start sm:items-center gap-1 sm:gap-2 2xl:justify-between border-b border-border-gray dark:border-bg-dark-secondary mb-4 sm:mb-6">


                                 <button @click="tab = 'basic'"
                                     :class="tab === 'basic' ?
                                         'bg-bg-white dark:bg-bg-dark-secondary xs:border-b-2 border-primary dark:border-primary font-semibold text-text-primary dark:text-text-light' :
                                         'bg-bg-light-secondary dark:bg-bg-dark-tertiary text-text-secondary dark:text-text-secondary hover:bg-bg-light dark:hover:bg-bg-dark-secondary'"
                                     class="px-3 xs:px-4 xl:px-6 py-2 text-sm sm:text-base xs:rounded-t-md transition-colors text-left xs:text-center border-l-2 xs:border-l-0 border-primary dark:border-primary xs:border-none">
                                     {{ __('Basic Info') }}
                                 </button>

                                 @foreach ($groupedInfo as $category => $type)
                                     <button @click="tab = '{{ $category }}'"
                                         :class="tab === 'airbag' ?
                                             'bg-bg-white dark:bg-bg-dark-secondary xs:border-b-2 border-primary dark:border-primary font-semibold text-text-primary dark:text-text-light' :
                                             'bg-bg-light-secondary dark:bg-bg-dark-tertiary text-text-secondary dark:text-text-secondary hover:bg-bg-light dark:hover:bg-bg-dark-secondary'"
                                         class="px-3 xs:px-4 xl:px-6 py-2 text-sm sm:text-base xs:rounded-t-md transition-colors text-left xs:text-center border-l-2 xs:border-l-0 border-primary dark:border-primary xs:border-none">
                                         {{ $category }}
                                     </button>
                                 @endforeach


                                 {{-- <button @click="tab = 'airbag'"
                                     :class="tab === 'airbag' ?
                                         'bg-bg-white dark:bg-bg-dark-secondary xs:border-b-2 border-primary dark:border-primary font-semibold text-text-primary dark:text-text-light' :
                                         'bg-bg-light-secondary dark:bg-bg-dark-tertiary text-text-secondary dark:text-text-secondary hover:bg-bg-light dark:hover:bg-bg-dark-secondary'"
                                     class="px-3 xs:px-4 xl:px-6 py-2 text-sm sm:text-base xs:rounded-t-md transition-colors text-left xs:text-center border-l-2 xs:border-l-0 border-primary dark:border-primary xs:border-none">
                                     {{ __('Air-bag') }}
                                 </button>

                                 <button @click="tab = 'other'"
                                     :class="tab === 'other' ?
                                         'bg-bg-white dark:bg-bg-dark-secondary xs:border-b-2 border-primary dark:border-primary font-semibold text-text-primary dark:text-text-light' :
                                         'bg-bg-light-secondary dark:bg-bg-dark-tertiary text-text-secondary dark:text-text-secondary hover:bg-bg-light dark:hover:bg-bg-dark-secondary'"
                                     class="px-3 xs:px-4 xl:px-6 py-2 text-sm sm:text-base xs:rounded-t-md transition-colors text-left xs:text-center border-l-2 xs:border-l-0 border-primary dark:border-primary xs:border-none">
                                     {{ __('Other Info') }}
                                 </button>

                                 <button @click="tab = 'development'"
                                     :class="tab === 'development' ?
                                         'bg-bg-white dark:bg-bg-dark-secondary xs:border-b-2 border-primary dark:border-primary font-semibold text-text-primary dark:text-text-light' :
                                         'bg-bg-light-secondary dark:bg-bg-dark-tertiary text-text-secondary dark:text-text-secondary hover:bg-bg-light dark:hover:bg-bg-dark-secondary'"
                                     class="px-3 xs:px-4 xl:px-6 py-2 text-sm sm:text-base xs:rounded-t-md transition-colors text-left xs:text-center border-l-2 xs:border-l-0 border-primary dark:border-primary xs:border-none">
                                     {{ __('Development') }}
                                 </button>

                                 <button @click="tab = 'docs'"
                                     :class="tab === 'docs' ?
                                         'bg-bg-white dark:bg-bg-dark-secondary xs:border-b-2 border-primary dark:border-primary font-semibold text-text-primary dark:text-text-light' :
                                         'bg-bg-light-secondary dark:bg-bg-dark-tertiary text-text-secondary dark:text-text-secondary hover:bg-bg-light dark:hover:bg-bg-dark-secondary'"
                                     class="px-3 xs:px-4 xl:px-6 py-2 text-sm sm:text-base xs:rounded-t-md transition-colors text-left xs:text-center border-l-2 xs:border-l-0 border-primary dark:border-primary xs:border-none">
                                     {{ __('Documents') }}
                                 </button> --}}
                             </div>
                             <!-- Tab Content -->
                             <div
                                 class="bg-bg-white dark:bg-bg-tertiary/25 shadow-card dark:shadow-none p-4 sm:p-6 rounded-b-lg border border-border-gray dark:border-bg-dark-secondary overflow-auto max-h-[400px] lg:max-h-[520px] xl:max-h-[670px]">

                                 <!-- Basic Info -->
                                 <div x-show="tab === 'basic'" x-cloak>
                                     <table class="w-full table-auto text-sm sm:text-base">
                                         <tbody>
                                             @if ($product->name)
                                                 <tr class=" border-border-gray dark:border-bg-dark-secondary">
                                                     <td
                                                         class="font-semibold w-32 sm:w-52 py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Name') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->name }}
                                                     </td>
                                                 </tr>
                                             @endif
                                             @if ($product->price)
                                                 <tr class=" border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td
                                                         class="font-semibold w-32 sm:w-52 py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Price.') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->price }}
                                                     </td>
                                                 </tr>
                                             @endif
                                             @if ($product->short_description)
                                                 <tr class=" border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td
                                                         class="font-semibold w-32 sm:w-52 py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Short Description.') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->short_description }}
                                                     </td>
                                                 </tr>
                                             @endif
                                             @if ($product->stock_no)
                                                 <tr class=" border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td
                                                         class="font-semibold w-32 sm:w-52 py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Stock No.') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->stock_no }}
                                                     </td>
                                                 </tr>
                                             @endif
                                             @if ($product->company?->name)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Maker') }}
                                                     </td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->company?->name }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->model?->name)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Model') }}
                                                     </td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->model?->name ?? 'N/A' }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->grade)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Grade') }}
                                                     </td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->grade ?? 'N/A' }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->body)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Body Type') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->body ?? 'N/A' }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->first_registration)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('First Registration') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->first_registration ?? 'N/A' }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->type)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Type') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->type ?? 'N/A' }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->displacement)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Displacement') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->displacement ?? 'N/A' }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->specification_no)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Specification No') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->specification_no ?? 'N/A' }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->classification_no)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Classification No') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->classification_no }}</td>
                                             @endif
                                             </tr>
                                             @if ($product->chassis_no)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Chassis No') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->chassis_no }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->serial_no)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Serial No') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->serial_no }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->engine_type)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Engine Type') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->engine_type }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->fuel_type)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Fuel') }}
                                                     </td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->fuel_type }}
                                                     </td>
                                                 </tr>
                                             @endif
                                             @if ($product->mileage)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Mileage') }}
                                                     </td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->mileage }}
                                                     </td>
                                                 </tr>
                                             @endif
                                             @if ($product->color)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Color') }}
                                                     </td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->color }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->drive_system)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Drive System') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->drive_system }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->transmission)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Transmission') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->transmission }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->classification_no)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Capacity') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->capacity }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->odometer_replacement)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Odometer') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->odometer_replacement }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->steering_wheel)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Steering Wheel') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->steering_wheel }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->length_m)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Length (m)') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->length_m }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->width_m)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Width (m)') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->width_m }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->height_m)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Height (m)') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->height_m }}</td>
                                                 </tr>
                                             @endif
                                             @if ($product->weight_kg)
                                                 <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                     <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Weight (Kg)') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->weight_kg }}</td>
                                                 </tr>
                                             @endif
                                         </tbody>
                                         <tfoot class="border-t border-border-gray dark:border-bg-dark-secondary">
                                             @if ($product->remarks)
                                                 <tr>
                                                     <td colspan="2"
                                                         class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Remarks') }}</td>
                                                 </tr>
                                                 <tr>
                                                     <td colspan="2">{!! $product->remarks !!}</td>
                                                 </tr>
                                             @endif
                                         </tfoot>
                                     </table>
                                 </div>


                                 @foreach ($infos as $key => $info)
                                     <div x-show="tab === '{{ $category }}'" x-cloak>
                                         <table class="w-full table-auto text-sm sm:text-base">
                                             <tbody>
                                                 {{-- @dd($type->toArray()) --}}
                                                 <p>{{ $info->infoCategory->catagoryTypes[$key]->name }}</p>

                                                 @foreach ($info->infoCategory->catagoryTypes as $type)
                                                     @if (!empty($type->features))
                                                         @foreach ($type->features as $feature)
                                                             <tr class=" border-border-gray dark:border-bg-dark-secondary">
                                                                 <td
                                                                     class="font-semibold w-32 sm:w-52 py-2 sm:py-3 dark:text-text-light">
                                                                     {{ $feature->name }}</td>
                                                                 <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                                     {{ $info->description ?? 'N/A' }}

                                                                 </td>
                                                             </tr>
                                                         @endforeach
                                                     @endif
                                                 @endforeach



                                                 {{-- <tr class=" border-border-gray dark:border-bg-dark-secondary">
                                                     <td
                                                         class="font-semibold w-32 sm:w-52 py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Name') }}</td>
                                                     <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                         {{ $product->name ?? 'N/A' }}
                                                     </td>
                                                 </tr> --}}
                                             </tbody>
                                             {{-- <tfoot class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                 <tr>
                                                     <td colspan="2"
                                                         class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Description') }}</td>
                                                 </tr>
                                                 <tr>
                                                     <td colspan="2">{{ $product->description ?? 'N/A' }}</td>
                                                 </tr>
                                                 <tr>
                                                     <td colspan="2"
                                                         class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                         {{ __('Remarks') }}</td>
                                                 </tr>
                                                 <tr>
                                                     <td colspan="2">{{ $product->remarks ?? 'N/A' }}</td>
                                                 </tr>
                                             </tfoot> --}}
                                         </table>
                                     </div>
                                 @endforeach

                                 {{-- <!-- Airbag Info -->
                                 <div x-show="tab === 'airbag'" x-cloak>
                                     <p class="text-text-secondary dark:text-text-secondary text-lg">
                                         {{ __('No airbag data available.') }}</p>
                                 </div>

                                 <!-- Other Info -->
                                 <div x-show="tab === 'other'" x-cloak>
                                     <p class="text-text-secondary dark:text-text-secondary text-lg">
                                         {{ __('No additional information provided.') }}</p>
                                 </div>

                                 <!-- Development -->
                                 <div x-show="tab === 'development'" x-cloak>
                                     <p class="text-text-secondary dark:text-text-secondary text-lg">
                                         {{ __('Development info not available.') }}</p>
                                 </div>

                                 <!-- Documents -->
                                 <div x-show="tab === 'docs'" x-cloak>
                                     <p class="text-text-secondary dark:text-text-secondary text-lg">
                                         {{ __('No documents attached.') }}</p> --}}
                             </div>
                         </div>
                         <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-2">
                             <a href="@auth('web')
                                     javascript:void(0)
                                 @else
                                     {{ route('login') }}
                                 @endauth"
                                 @auth('web')
                                         onclick="document.getElementById('reserve-{{ $product->slug }}').showModal()"
                                    @endauth
                                 class="btn-primary w-full">{{ __('Buy Now') }}</a>

                             <x-backend.user.reserve :product="$product" />

                             <a href="@auth('web')
                                     javascript:void(0)
                                 @else
                                     {{ route('login') }}
                                 @endauth"
                                 @auth('web')
                                         onclick="document.getElementById('inquiry-{{ $product->slug }}').showModal()"
                                    @endauth
                                 class="btn-primary w-full">{{ __('WhatsApp Inquiry') }}</a>
                         </div>
                         <x-backend.user.inquiry :product="$product" :label="__('Product Inquiry')" />
                     </div>
                 </div>
                 {{-- Description --}}
                 <div class="mt-6">
                     <h2 class="text-text-primary dark:text-text-primary text-lg font-semibold mb-2">
                         {{ __('Description') }}</h2>
                     <p class="text-text-gray dark:text-text-light-secondary text-sm lg:text-base">{!! $product->description !!}
                     </p>
                 </div>
             </div>
         </div>
         </div>
     </section>

     {{-- ===================== End Product Details Section ===================== --}}
     {{-- ===================== Releted Product Section ===================== --}}

     <section class="xl:pt-2 lg:py-12 py-6 xl:mb-12 md:mb-10 mb-8">
         <div class="container">
             <div class="header bg-bg-primary mb-2 py-4 pl-4">
                 <h2 class="text-2xl font-bold text-text-white ">{{ __('Related Products') }}</h2>
             </div>
             <div class="relative">
                 <div class="swiper related_product static">
                     <div class="swiper-wrapper p-2">
                         @foreach ($related_products as $r_product)
                             <div class="swiper-slide">
                                 <a href="{{ route('frontend.product.details', $r_product->slug) }}">
                                     <div class="product-card hover:shadow-md transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                                         data-product="1">
                                         <div class="max-h-80 w-full overflow-hidden">
                                             <img src="{{ storage_url($r_product->primaryImage->first()?->image) }}"
                                                 alt="{{ $r_product->primaryImage->first()?->alt ?? $r_product->name }}"
                                                 class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                         </div>
                                         <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                             <h3
                                                 class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                                 {{ $r_product->model?->name }}
                                             </h3>
                                             <p class="text-xl font-bold text-text-danger">
                                                 {{ number_format($r_product->price, 2) }}</p>
                                             <div
                                                 class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                                 <span>{{ $r_product->year }}</span>
                                                 <span class="mx-2">|</span>
                                                 <span>{{ $r_product->brand?->name }}</span>
                                             </div>
                                         </div>
                                     </div>
                                 </a>
                             </div>
                         @endforeach
                     </div>

                     <div class="hidden xl:block">
                         <div class="swiper-pagination z-10 !-bottom-6 lg:!-bottom-8"></div>
                         <!-- Navigation buttons -->
                         <div class="swiper-button swiper-button-prev 3xl:-left-13 2xl:-left-9">
                             <i data-lucide="chevron-left" class="w-5 h-5"></i>
                         </div>

                         <div class="swiper-button swiper-button-next 3xl:-right-13 2xl:-right-9">
                             <i data-lucide="chevron-right" class="w-5 h-5"></i>
                         </div>
                     </div>
                 </div>
             </div>

         </div>
     </section>

 @endsection

 @push('js')

     @if ($errors->any())
         @if (old('form_type') === 'inquiry')
             <script>
                 document.getElementById('inquiry-{{ $product->slug }}')?.showModal();
             </script>
         @elseif (old('form_type') === 'reserve')
             <script>
                 document.getElementById('reserve-{{ $product->slug }}')?.showModal();
             </script>
         @endif
     @endif


     <!-- Alpine.js for tab switching -->
     <script src="//unpkg.com/alpinejs" defer></script>
     <!-- Initialize Swiper JS -->
     <script type="module">
         import Swiper from '/frontend/js/swiper.min.js';

         document.addEventListener('DOMContentLoaded', function() {
             // Initialize thumbnail Swiper
             const galleryThumbs = new Swiper('.product_slider_thumbs', {
                 spaceBetween: 8,
                 slidesPerView: 5,
                 freeMode: true,
                 watchSlidesProgress: true,
                 watchSlidesVisibility: true,
                 breakpoints: {
                     480: {
                         slidesPerView: 4
                     },
                     768: {
                         slidesPerView: 6
                     },
                     1024: {
                         slidesPerView: 7
                     },
                     1280: {
                         slidesPerView: 8
                     },

                 }
             });

             // Initialize main image Swiper
             const galleryTop = new Swiper('.product_slider_image', {
                 spaceBetween: 10,
                 navigation: {
                     nextEl: '.swiper-button-next',
                     prevEl: '.swiper-button-prev',
                 },
                 thumbs: {
                     swiper: galleryThumbs
                 }
             });

             // Zoom functionality
             const zoomResult = document.getElementById("zoomResult");
             const lens = document.getElementById("lens");

             // Re-attach zoom logic every time slide changes
             function attachZoom() {
                 document.querySelectorAll('.zoomable').forEach(img => {
                     img.addEventListener('mousemove', function(e) {
                         const rect = img.getBoundingClientRect();
                         const wrapperRect = img.closest('.hover-wrapper').getBoundingClientRect();
                         const x = e.clientX - rect.left;
                         const y = e.clientY - rect.top;

                         const zoomFactor = 2; // You can adjust this
                         const resultWidth = zoomResult.offsetWidth;
                         const resultHeight = zoomResult.offsetHeight;

                         zoomResult.style.backgroundImage = `url('${img.src}')`;
                         zoomResult.style.backgroundSize =
                             `${rect.width * zoomFactor}px ${rect.height * zoomFactor}px`;
                         zoomResult.style.backgroundPosition =
                             `-${x * zoomFactor - resultWidth / 2}px -${y * zoomFactor - resultHeight / 2}px`;

                         lens.style.display = 'block';
                         lens.style.width = `100px`;
                         lens.style.height = `100px`;
                         lens.style.left = `${e.clientX - wrapperRect.left - 50}px`;
                         lens.style.top = `${e.clientY - wrapperRect.top - 50}px`;

                         zoomResult.style.display = 'block';
                     });

                     img.addEventListener('mouseenter', function() {
                         zoomResult.style.display = 'block';
                         lens.style.display = 'block';
                     });

                     img.addEventListener('mouseleave', function() {
                         zoomResult.style.display = 'none';
                         lens.style.display = 'none';
                         zoomResult.style.backgroundImage = '';
                     });
                 });
             }

             // Initial attach
             attachZoom();

             // Optional: Re-attach on slide change to ensure only current image responds
             galleryTop.on('slideChangeTransitionEnd', () => {
                 attachZoom(); // Refresh listeners if needed
             });



             const swiper = new Swiper(".related_product", {
                 loop: true,
                 spaceBetween: 10,
                 slidesPerView: 1,
                 breakpoints: {
                     640: {
                         slidesPerView: 2,
                     },
                     768: {
                         slidesPerView: 3,
                     },
                     1024: {
                         slidesPerView: 4,
                     },
                     1280: {
                         slidesPerView: 5,
                     },
                     1536: {
                         slidesPerView: 6,
                     },
                 },
                 navigation: {
                     nextEl: ".swiper-button-next",
                     prevEl: ".swiper-button-prev",
                 },
                 pagination: {
                     el: ".swiper-pagination",
                     clickable: true,
                 },
             });
         });
     </script>


     {{-- <script type="module">
        import Swiper from '/frontend/js/swiper.min.js';
        // Initialize Swiper
        const swiperThumbs = new Swiper(".product_slider_thumbs", {
            loop: true,
            spaceBetween: 10,
            slidesPerView: 6,
            freeMode: true,
            watchSlidesProgress: true,
        });

        const swiperMain = new Swiper(".product_slider_image", {
            loop: true,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiperThumbs,
            },
        });
    </script> --}}
 @endpush

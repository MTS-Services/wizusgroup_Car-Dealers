@extends('frontend.layouts.app', ['page_slug' => 'auction_details'])

@section('title', 'Auction Details')
@section('content')
    {{-- ===================== Product Carousel Section Start ===================== --}}
    <!-- Top-level wrapper -->
    <section class="overflow-x-hidden">
        <div class="auction_carousel_section 2xl:py-16 xl:py-12 lg:py-10  py-6  overflow-hidden">
            <div class="container mx-auto overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 dark:bg-bg-dark dark:text-text-light">
                    <!-- Left: Image Slider -->
                    <div class="w-full overflow-hidden">
                        <!-- Main Product Slider -->
                        <div class="relative hover-wrapper">
                            <div
                                class="swiper static product_slider_image w-full max-w-full h-[300px] sm:h-[400px] md:h-[500px] lg:h-[600px] xl:h-[700px] mx-auto bg-bg-light dark:bg-bg-dark-tertiary rounded-lg overflow-hidden">
                                <div class="swiper-wrapper">
                                    @foreach ($auction->product->images as $image)
                                        <div class="swiper-slide flex items-center justify-center">
                                            <img src="{{ storage_url($image->image) }}"
                                                alt="{{ $image->alt ?? $auction->name }}"
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
                                @foreach ($auction->product->images as $image)
                                    <div
                                        class="swiper-slide w-1/5 sm:w-1/6 md:w-1/8 h-full opacity-40 transition-opacity duration-300 cursor-pointer hover:opacity-70 swiper-slide-thumb-active:opacity-100 dark:swiper-slide-thumb-active:opacity-100">
                                        <img src="{{ storage_url($image->image) }}"
                                            alt="{{ $image->alt ?? $auction->name }}"
                                            class="block w-full h-full object-cover rounded" />
                                    </div>
                                @endforeach
                                {{-- @for ($i = 1; $i <= 10; $i++)
                                    <div
                                        class="swiper-slide w-1/5 sm:w-1/6 md:w-1/8 h-full opacity-40 transition-opacity duration-300 cursor-pointer hover:opacity-70 swiper-slide-thumb-active:opacity-100 dark:swiper-slide-thumb-active:opacity-100">
                                        <img src="https://swiperjs.com/demos/images/nature-{{ $i }}.jpg"
                                            class="block w-full h-full object-cover rounded" />
                                    </div>
                                @endfor --}}
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

                                <button @click="tab = 'airbag'"
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
                                </button>
                            </div>
                            <!-- Tab Content -->
                            <div
                                class="bg-bg-white dark:bg-bg-tertiary/25 shadow-card dark:shadow-none p-4 sm:p-6 rounded-b-lg border border-border-gray dark:border-bg-dark-secondary overflow-auto max-h-[400px] lg:max-h-[520px] xl:max-h-[670px]">

                                <!-- Basic Info -->
                                <div x-show="tab === 'basic'" x-cloak>
                                    <table class="w-full table-auto text-sm sm:text-base">
                                        <tbody>
                                            @if ($auction->product?->name)
                                                <tr class=" border-border-gray dark:border-bg-dark-secondary">
                                                    <td
                                                        class="font-semibold w-32 sm:w-52 py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Name') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->name }}
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->price)
                                                <tr class=" border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td
                                                        class="font-semibold w-32 sm:w-52 py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Price.') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->price }}
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->short_description)
                                                <tr class=" border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td
                                                        class="font-semibold w-32 sm:w-52 py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Short Description.') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->short_description }}
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->stock_no)
                                                <tr class=" border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td
                                                        class="font-semibold w-32 sm:w-52 py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Stock No.') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->stock_no }}
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->company?->name)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Maker') }}
                                                    </td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->company?->name }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->model?->name)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Model') }}
                                                    </td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->model?->name ?? 'N/A' }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->grade)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Grade') }}
                                                    </td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->grade ?? 'N/A' }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->body)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Body Type') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->body ?? 'N/A' }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->first_registration)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('First Registration') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->first_registration ?? 'N/A' }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->type)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Type') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->type ?? 'N/A' }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->displacement)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Displacement') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->displacement ?? 'N/A' }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->specification_no)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Specification No') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->specification_no ?? 'N/A' }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->classification_no)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Classification No') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->classification_no }}</td>
                                            @endif
                                            </tr>
                                            @if ($auction->product?->chassis_no)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Chassis No') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->chassis_no }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->serial_no)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Serial No') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->serial_no }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->engine_type)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Engine Type') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->engine_type }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->fuel_type)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Fuel') }}
                                                    </td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->fuel_type }}
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->mileage)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Mileage') }}
                                                    </td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->mileage }}
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->color)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Color') }}
                                                    </td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->color }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->drive_system)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Drive System') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->drive_system }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->transmission)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Transmission') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->transmission }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->classification_no)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Capacity') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->capacity }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->odometer_replacement)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Odometer') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->odometer_replacement }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->steering_wheel)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Steering Wheel') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->steering_wheel }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->length_m)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Length (m)') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->length_m }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->width_m)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Width (m)') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->width_m }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->height_m)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Height (m)') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->height_m }}</td>
                                                </tr>
                                            @endif
                                            @if ($auction->product?->weight_kg)
                                                <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                                    <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Weight (Kg)') }}</td>
                                                    <td class="py-2 sm:py-3 dark:text-text-secondary">
                                                        {{ $auction->product?->weight_kg }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        <tfoot class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            @if ($auction->product?->remarks)
                                                <tr>
                                                    <td colspan="2"
                                                        class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                        {{ __('Remarks') }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">{!! $auction->product?->remarks !!}</td>
                                                </tr>
                                            @endif
                                        </tfoot>
                                    </table>
                                </div>

                                <!-- Airbag Info -->
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
                                        {{ __('No documents attached.') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center gap-2 mt-2">
                            <a href="@auth('web')
                                     javascript:void(0)
                                 @else
                                     {{ route('login') }}
                                 @endauth"
                                @auth('web')
                                         onclick="document.getElementById('inquiry-{{ $auction->slug }}').showModal()"
                                    @endauth
                                class="btn-primary w-full">{{ __('WhatsApp Inquiry') }}</a>
                            @auth('web')
                                <button onclick="document.getElementById('{{ $auction->id }}-modal').showModal()"
                                    class="btn-primary w-full">{{ __('Place a Bid') }}</button>
                            @endauth
                        </div>
                        <x-backend.user.inquiry :product="$auction" :label="__('Auction Inquiry')" />
                    </div>
                </div>
                {{-- Description --}}
                <div class="mt-6">
                    <h2 class="text-text-primary dark:text-text-primary text-lg font-semibold mb-2">
                        {{ __('Description') }}</h2>
                    <p class="text-text-gray dark:text-text-light-secondary text-sm lg:text-base">{!! $auction->product?->description !!}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Auction Bid Place Modal  --}}
    <dialog id="{{ $auction->id }}-modal" class="modal">
        <div class="modal-box bg-bg-light dark:bg-bg-dark-tertiary p-6 rounded-lg w-full max-w-sm shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">{{ __('Place Your Bid') }}</h2>
                <form method="dialog">
                    <button onclick="closeModal()"
                        class="text-text-primary hover:text-text-tertiary text-2xl dark:text-text-light btn btn-sm btn-circle btn-ghost"><i
                            data-lucide="x" class="w-4 h-4"></i></button>
                </form>
            </div>
            <form id="place-bid-form-{{ $auction->id }}" method="post">
                @csrf
                <div class="space-y-2 pb-3">
                    <label
                        class="block text-sm font-medium text-text-primary dark:text-text-light text-opacity-50">{{ __('Your Whatsapp Number') }}</label>
                    <input type="number" name="whatsapp_number"
                        class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bg-primary"
                        placeholder="Enter your whatsapp number" />
                    <p class="text-red-500 text-sm mt-1" id="whatsapp_number_error_{{ $auction->id }}"></p>
                    <label
                        class="block text-sm font-medium text-text-primary dark:text-text-light text-opacity-50">{{ __('Your Bid (USD)') }}</label>
                    <input type="number" name="bid_amount"
                        class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bg-primary"
                        placeholder="Enter your bid" />
                    <p class="text-red-500 text-sm mt-1" id="bid_amount_error_{{ $auction->id }}"></p>
                </div>

                <button class="w-full btn-primary py-2 rounded-md hover:bg-bg-tertiary transition">
                    {{ __('Submit Bid') }}
                </button>
            </form>
        </div>
    </dialog>

    {{-- ===================== End Product Details Section ===================== --}}
    {{-- ===================== Releted Product Section ===================== --}}

    <section class="xl:pt-2 lg:py-12 py-6 xl:mb-12 md:mb-10 mb-8">
        <div class="container">
            <div class="header bg-bg-primary mb-2 py-4 pl-4">
                <h2 class="text-2xl font-bold text-text-white ">{{ __('Related Auctions Products') }}</h2>
            </div>
            <div class="relative">
                {{-- Product 1 --}}
                <div class="swiper related_product static py-4">
                    <div class="swiper-wrapper h-full">
                        @foreach ($auctions as $auction)
                            <div class="swiper-slide">
                                <x-frontend.auction-card :auction="$auction" />
                            </div>
                        @endforeach
                        <!-- Repeat swiper-slide for other products -->
                    </div>

                    <!-- Optional controls -->
                    <div class="swiper-pagination !-bottom-10"></div>
                    <!-- Navigation buttons -->
                    <div class="swiper-button swiper-button-prev 3xl:-left-13 2xl:-left-9">
                        <i data-lucide="chevron-left" class="w-5 h-5 text-blue-800"></i>
                    </div>
                    <div class="swiper-button swiper-button-next 3xl:-right-13 2xl:-right-9 ">
                        <i data-lucide="chevron-right" class="w-5 h-5 text-blue-800"></i>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('js')
    <script>
        (function() {
            const placeBidForm = document.getElementById(`place-bid-form-{{ $auction->id }}`);

            placeBidForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const route = "{{ route('user.auction.bid-place', ['slug']) }}";
                const url = route.replace('slug', "{{ $auction->slug }}");


                axios.post(url, formData)
                    .then(response => {
                        // Close Modal
                        const modal = document.getElementById('{{ $auction->id }}-modal');
                        modal.close()

                        // Clear Everything
                        document.getElementById('whatsapp_number_error_{{ $auction->id }}').textContent =
                            '';
                        document.getElementById('bid_amount_error_{{ $auction->id }}').textContent = '';
                        document.getElementById('place-bid-form-{{ $auction->id }}').reset();

                        toastr.success('Bid Placed Successfully');
                        // console.log(response.data);

                    })
                    .catch(error => {
                        // Clear existing errors
                        document.getElementById('whatsapp_number_error_{{ $auction->id }}').textContent =
                            '';
                        document.getElementById('bid_amount_error_{{ $auction->id }}').textContent = '';

                        if (error.response && error.response.status === 422) {
                            const errors = error.response.data.errors;

                            if (errors.whatsapp_number) {
                                document.getElementById('whatsapp_number_error_{{ $auction->id }}')
                                    .textContent = errors.whatsapp_number[0];
                            }

                            if (errors.bid_amount) {
                                document.getElementById('bid_amount_error_{{ $auction->id }}')
                                    .textContent = errors.bid_amount[0];
                            }
                        } else {
                            toastr.error('Something went wrong');
                            console.error(error);
                        }
                    });
            });
        })();
    </script>

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

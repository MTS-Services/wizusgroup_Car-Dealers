@extends('frontend.layouts.app', ['page_slug' => 'about'])
@section('title', 'About')
@section('content')
    <section>
        <div class="">
            <div class="min-h-[50vh]  flex flex-col items-center justify-center relative bg-bg-dark bg-opacity-50">
                <div class="w-full ">
                    <img src="{{ asset('frontend/images/about/about-banner.jpg') }}" alt=""
                        class="w-full object-contain">
                </div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                    {{-- line height --}}
                    <h1 class="text-4xl lg:text-5xl !leading-[72px] font-semibold text-text-white text-center">
                        {{ __("Connecting Africa to japan & China's Best Machines") }}</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="py-15">
        <div class="container">
            {{-- Our Story --}}
            <h2 class="text-xl lg:text-2xl pb-2 font-semibold text-text-primary dark:text-text-light">{{ __('Our Story') }}
            </h2>
            <p>{{ __("Founded to bridge the gap between Africa's growing industrial needs and Asia's leading machinery markets, Wiz afrik has established itself as trusted partner for African entrepreneurs. Our mission is to make it easier for businesses in Africa to access high-quality, affordable used equipment from Japan and China.") }}
            </p>
        </div>
    </section>
    <section>
        <div class="container">
            {{-- What We Offer --}}
            <h2 class="text-xl lg:text-2xl pb-2 font-semibold text-text-primary dark:text-text-light">
                {{ __('What We Offer') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                    <div>
                        <h3 class="text-lg font-semibold text-text-primary dark:text-text-light">{{ __('Buying') }}
                        </h3>
                    </div>
                    <p class="text-text-primary dark:text-text-light">Buying from Wiz Afrik means you have access to a
                        wide
                        range of used machinery from Japan and China. Our platform connects you with a vast network of
                        reliable sellers who offer quality equipment at affordable prices.</p>
                </div>
                <div class="flex flex-col gap-2">
                    <div>
                        <h3 class="text-lg font-semibold text-text-primary dark:text-text-light">{{ __('Selling') }}
                        </h3>
                    </div>
                    <p class="text-text-primary dark:text-text-light">Selling on Wiz Afrik is a hassle-free process that
                        allows you to sell your used machinery to a wide audience of potential buyers. Our platform
                        connects you with a global network of buyers who are looking for quality equipment at
                        affordable prices.</p>
                </div>
            </div>
    </section>
@endsection

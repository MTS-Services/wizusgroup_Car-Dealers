@extends('frontend.layouts.app', ['page_slug' => 'regions'])

@section('title', 'Regions')
@section('content')
    <div class="bg-bg-light py-15 px-4 md:px-18">
        <div class="container mx-auto">
            <h2 class="text-3xl font-poppins font-semibold text-text-primary mb-10">{{ __('Regions We Serve') }}</h2>

            {{-- Interactive Region Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-15">
                @foreach ($regions as $region)
                    <div class="bg-bg-white p-6 rounded-2xl shadow-card hover:shadow-lg transition-shadow">
                        <h3 class="text-xl font-semibold text-text-primary mb-2">{{ __($region->name ) }}</h3>
                        <p class="text-sm !text-text-secondary">{!! $region->description !!}</p>
                    </div>
                @endforeach
            </div>

            <!-- Shipping Timelines and Ports -->
            <div class="bg-gradient-light p-8 rounded-3xl shadow-shadowPrimary mb-15 animate-fade-in">
                <h3 class="text-3xl font-bold text-text-primary mb-6 border-b border-border-gray pb-3">
                    🚢 {{ __('Shipping Timelines & Port Listings') }}
                </h3>
                <ul class="text-text-primary text-base leading-relaxed items-center gap-4 justify-between grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
                    <li class="flex items-start gap-3">
                        <span class="text-xl text-bg-primary">🌍</span>
                        <span><strong>{{ __('Africa') }}:</strong> {{ __('15-30 days') }}<br><span class="text-sm text-text-secondary">{{ __('Ports: Lagos, Mombasa') }}</span></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-xl text-bg-primary">🕌</span>
                        <span><strong>{{ __('Middle East') }}:</strong> {{ __('10-20 days') }}<br><span class="text-sm text-text-secondary">{{ __('Ports: Jebel Ali, Dammam') }}</span></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-xl text-bg-primary">🌏</span>
                        <span><strong>{{ __('Asia') }}:</strong> {{ __('7-15 days') }}<br><span class="text-sm text-text-secondary">{{ __('Ports: Shanghai, Chittagong') }}</span></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-xl text-bg-primary">🌍</span>
                        <span><strong>{{ __('Europe') }}:</strong> {{ __('20-35 days') }}<br><span class="text-sm text-text-secondary">{{ __('Ports: Rotterdam, Hamburg') }}</span></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-xl text-bg-primary">🌎</span>
                        <span><strong>{{ __('North America') }}:</strong> {{ __('25-40 days') }}<br><span class="text-sm text-text-secondary">{{ __('Ports: New York, Los Angeles') }}</span></span>
                    </li>
                </ul>
            </div>

            {{-- Language Support Awareness --}}
            <div class="relative bg-bg-light p-8 rounded-3xl shadow-shadowPrimary animate-fade-in">
                <!-- Accent Badge -->
                <div class="absolute -top-3 left-6 bg-bg-primary text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                    {{ __('Multilingual') }}
                </div>

                <!-- Title -->
                <h3 class="text-2xl md:text-3xl font-bold text-text-primary mb-4 flex items-center gap-2">
                    🌍 {{ __('We Speak Your Language') }}
                </h3>

                <!-- Description -->
                <p class="text-base text-text-secondary leading-relaxed mb-5 font-inter">
                    {{ __('Our platform supports multiple languages to provide seamless communication and a personalized experience across all regions.') }}
                </p>

                <!-- Language Pills -->
                <div class="flex flex-wrap gap-2">
                    @foreach (['English', 'Arabic', 'French', 'Swahili', 'Mandarin', 'Spanish'] as $lang)
                        <span class="bg-gradient-primary text-white text-sm px-3 py-1 rounded-full font-medium">{{ __($lang) }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection


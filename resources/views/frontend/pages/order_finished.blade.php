@extends('frontend.layouts.app', ['page_slug' => 'orders'])

@section('title', 'Orders')

@section('content')
    <section class="py-15">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-3xl font-semibold text-text-primary dark:text-text-light text-center">
                        {{ __('Order Finished') }}</h1>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('frontend.layouts.app', ['page_slug' => 'order_form'])

@section('title', 'Order Form')

@section('content')
    <section class="my-40">
        <div class="max-w-xl mx-auto mt-10 bg-bg-light dark:bg-bg-dark p-6 rounded-xl shadow-md">
            <h2 class="text-2xl font-semibold mb-6 text-center text-gray-700">Place Your Order</h2>

            <form action="#" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block mb-1 font-medium text-gray-600">Full Name</label>
                    <input type="text" name="name" placeholder="Enter your full name"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"
                        required>
                </div>

                <div>
                    <label class="block mb-1 font-medium text-gray-600">Phone Number</label>
                    <input type="text" name="phone" placeholder="Enter your phone number"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"
                        required>
                </div>

                <div>
                    <label class="block mb-1 font-medium text-gray-600">Shipping Address</label>
                    <textarea name="address" rows="3" placeholder="Enter your shipping address"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300" required></textarea>
                </div>

                <div>
                    <label class="block mb-1 font-medium text-gray-600">Product</label>
                    <input type="text" name="product" placeholder="Enter the product name"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                </div>

                <div>
                    <label class="block mb-1 font-medium text-gray-600">Quantity</label>
                    <input type="number" name="quantity" min="1" value="1" placeholder="Enter quantity"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"
                        required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </section>
@endsection

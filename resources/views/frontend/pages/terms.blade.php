@extends('frontend.layouts.app', ['page_slug' => 'regions'])

@section('title', 'Regions')

@section('content')
    <section class="bg-gray-50 text-gray-800 font-sans leading-relaxed">
        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8 ">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-6">Terms and Conditions</h1>

                <div class="mb-8 p-4 bg-blue-50 border-l-4 border-blue-500">
                    <p class="text-sm text-gray-600">
                        <strong>Last Updated:</strong> December 14, 2024
                    </p>
                    <p class="text-sm text-gray-600 mt-1">
                        <strong>Effective Date:</strong> December 14, 2024
                    </p>
                </div>

                <!-- Introduction -->
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">1. Introduction</h2>
                    <p class="mb-4">
                        Welcome to Wiz Global Machinery ("we," "our," or "us"). These Terms and Conditions ("Terms") govern
                        your use of our website and services related to industrial machinery, equipment sales, rentals, and
                        maintenance services.
                    </p>
                    <p>
                        By accessing our website or using our services, you agree to be bound by these Terms. If you do not
                        agree with any part of these terms, you may not use our services.
                    </p>
                </section>

                <!-- Definitions -->
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">2. Definitions</h2>
                    <div class="space-y-3">
                        <div>
                            <strong class="text-gray-900">"Company"</strong> refers to Wiz Global Machinery and its
                            subsidiaries.
                        </div>
                        <div>
                            <strong class="text-gray-900">"Services"</strong> includes machinery sales, rentals,
                            maintenance, repairs, and consulting.
                        </div>
                        <div>
                            <strong class="text-gray-900">"Equipment"</strong> refers to all industrial machinery and
                            related components.
                        </div>
                        <div>
                            <strong class="text-gray-900">"Customer"</strong> refers to any individual or entity using our
                            services.
                        </div>
                    </div>
                </section>

                <!-- Services -->
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">3. Services Offered</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-lg mb-2">Equipment Sales</h3>
                            <ul class="list-disc list-inside text-sm space-y-1">
                                <li>New and used industrial machinery</li>
                                <li>Spare parts and components</li>
                                <li>Custom equipment solutions</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-lg mb-2">Rental Services</h3>
                            <ul class="list-disc list-inside text-sm space-y-1">
                                <li>Short-term and long-term rentals</li>
                                <li>Flexible rental agreements</li>
                                <li>Delivery and pickup services</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-lg mb-2">Maintenance & Repair</h3>
                            <ul class="list-disc list-inside text-sm space-y-1">
                                <li>Preventive maintenance programs</li>
                                <li>Emergency repair services</li>
                                <li>Equipment inspections</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-lg mb-2">Consulting</h3>
                            <ul class="list-disc list-inside text-sm space-y-1">
                                <li>Equipment selection guidance</li>
                                <li>Operational efficiency consulting</li>
                                <li>Safety compliance assistance</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- Payment Terms -->
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">4. Payment Terms</h2>
                    <div class="space-y-4">
                        <div class="border-l-4 border-green-500 pl-4">
                            <h3 class="font-semibold">Equipment Purchases</h3>
                            <p class="text-sm">Payment terms are Net 30 days unless otherwise specified. A deposit may be
                                required for custom orders.</p>
                        </div>
                        <div class="border-l-4 border-blue-500 pl-4">
                            <h3 class="font-semibold">Rental Payments</h3>
                            <p class="text-sm">Rental fees are due in advance. Security deposits may be required based on
                                equipment value.</p>
                        </div>
                        <div class="border-l-4 border-orange-500 pl-4">
                            <h3 class="font-semibold">Service Payments</h3>
                            <p class="text-sm">Service fees are due upon completion unless a service contract specifies
                                otherwise.</p>
                        </div>
                    </div>
                </section>

                <!-- Warranties -->
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">5. Warranties and Disclaimers</h2>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                        <h3 class="font-semibold text-lg mb-3">Equipment Warranties</h3>
                        <ul class="list-disc list-inside space-y-2 mb-4">
                            <li>New equipment comes with manufacturer warranties</li>
                            <li>Used equipment sold "as-is" unless otherwise stated</li>
                            <li>Warranty terms vary by manufacturer and equipment type</li>
                        </ul>
                        <div class="bg-red-50 border border-red-200 rounded p-4">
                            <p class="text-sm font-semibold text-red-800">
                                DISCLAIMER: EXCEPT AS EXPRESSLY PROVIDED, ALL EQUIPMENT AND SERVICES ARE PROVIDED "AS IS"
                                WITHOUT WARRANTIES OF ANY KIND.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Liability -->
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">6. Limitation of Liability</h2>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                        <p class="mb-4">
                            Our liability for any claim arising from equipment or services shall not exceed the amount paid
                            by the customer for the specific equipment or service giving rise to the claim.
                        </p>
                        <p class="font-semibold">
                            We shall not be liable for consequential, incidental, or punitive damages, including but not
                            limited to loss of profits, business interruption, or equipment downtime.
                        </p>
                    </div>
                </section>

                <!-- Safety and Compliance -->
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">7. Safety and Compliance</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-semibold mb-2">Customer Responsibilities</h3>
                            <ul class="list-disc list-inside text-sm space-y-1">
                                <li>Proper equipment operation and maintenance</li>
                                <li>Compliance with safety regulations</li>
                                <li>Adequate operator training</li>
                                <li>Regular safety inspections</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2">Our Commitments</h3>
                            <ul class="list-disc list-inside text-sm space-y-1">
                                <li>Equipment meets industry standards</li>
                                <li>Proper documentation provided</li>
                                <li>Safety training available</li>
                                <li>Compliance support services</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- Intellectual Property -->
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">8. Intellectual Property</h2>
                    <p class="mb-4">
                        All content on our website, including text, graphics, logos, and software, is the property of Wiz
                        Global Machinery or its licensors and is protected by copyright and other intellectual property
                        laws.
                    </p>
                    <p>
                        Customers may not reproduce, distribute, or create derivative works from our content without written
                        permission.
                    </p>
                </section>

                <!-- Termination -->
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">9. Termination</h2>
                    <p class="mb-4">
                        Either party may terminate service agreements with appropriate notice as specified in individual
                        contracts. Immediate termination may occur in cases of:
                    </p>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Breach of payment terms</li>
                        <li>Misuse of equipment</li>
                        <li>Violation of safety protocols</li>
                        <li>Non-compliance with applicable laws</li>
                    </ul>
                </section>

                <!-- Governing Law -->
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">10. Governing Law</h2>
                    <p>
                        These Terms shall be governed by and construed in accordance with the laws of [Your Jurisdiction].
                        Any disputes shall be resolved through binding arbitration or in the courts of [Your Jurisdiction].
                    </p>
                </section>

                <!-- Contact Information -->
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">11. Contact Information</h2>
                    <div class="bg-blue-50 rounded-lg p-6">
                        <div class="grid md:grid-cols-3 gap-6">
                            <div>
                                <h3 class="font-semibold mb-2">General Inquiries</h3>
                                <p class="text-sm">Email: info@wizglobalmachinery.com</p>
                                <p class="text-sm">Phone: +1 (555) 123-4567</p>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-2">Legal Department</h3>
                                <p class="text-sm">Email: legal@wizglobalmachinery.com</p>
                                <p class="text-sm">Phone: +1 (555) 123-4568</p>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-2">Mailing Address</h3>
                                <p class="text-sm">
                                    Wiz Global Machinery<br>
                                    123 Industrial Boulevard<br>
                                    Manufacturing District<br>
                                    City, State 12345
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Changes to Terms -->
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">12. Changes to Terms</h2>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <p class="mb-2">
                            We reserve the right to modify these Terms at any time. Changes will be effective immediately
                            upon posting on our website.
                        </p>
                        <p class="text-sm text-gray-600">
                            Continued use of our services after changes constitutes acceptance of the modified Terms.
                        </p>
                    </div>
                </section>

                <!-- Acknowledgment -->
                <section class="mb-8">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <h3 class="font-semibold text-lg mb-3">Acknowledgment</h3>
                        <p class="mb-4">
                            By using our services, you acknowledge that you have read, understood, and agree to be bound by
                            these Terms and Conditions.
                        </p>
                        <p class="text-sm text-gray-600">
                            If you have questions about these Terms, please contact our legal department before using our
                            services.
                        </p>
                    </div>
                </section>
            </div>
        </main>

      
    </section>
@endsection

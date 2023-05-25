<x-site-layout>
    @section("pageTitle")
    Contact Us
    @endSection

    <x-banner bg="/img/team-valor-award.jpg">
        <div class="text-3xl lg:text-6xl">Contact Information</div>
    </x-banner>

    <div class="flex-1">

        <section>
            <div class="max-w-7xl mx-auto px-4 py-12">

                <div class="lg:flex lg:gap-6">
                    <div class="flex-1">

                        <div class="mb-12 text-2xl">
                            For sponsorship opportunities, networking suggestions, or general inquiries please contact us.
                        </div>

                        <div class="grid lg:grid-cols-2 gap-12">
                            <div>
                                <h3 class="text-2xl font-semibold">
                                    Mailing Address
                                </h3>
                                <div class="mb-4 text-gray-500 text-sm">Regular Mail</div>
                                <div class="text-xl">
                                    Ohio Tactical Officers Association<br>
                                    17000 St Clair Ave<br>
                                    Suite 108<br>
                                    Cleveland, OH 44110<br>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-2xl font-semibold">
                                    Shipping Address
                                </h3>
                                <div class="mb-4 text-gray-500 text-sm">UPS, FedEx, DHL, Truck Deliveries, etc</div>
                                <div class="text-xl">
                                    Ohio Tactical Officers Association<br>
                                    17000 St. Clair Avenue<br>
                                    Dock # 1<br>
                                    Cleveland, OH 44110
                                </div>
                            </div>
                            <div>
                                <h3 class="text-2xl font-semibold">
                                    General Questions
                                </h3>
                                <div>
                                    <x-a href="mailto:office@otoa.org" target="_blank">office@otoa.org</x-a>
                                </div>
                                <div class="text-xl">
                                    (216) 282-7928
                                </div>
                            </div>
                            <div>
                                <h3 class="text-2xl font-semibold">
                                    Billing and Invoice Questions
                                </h3>
                                <div>
                                    <x-a href="mailto:office@otoa.org" target="_blank">office@otoa.org</x-a>
                                </div>
                                <div class="text-xl">
                                    (216) 282-7928
                                </div>
                            </div>
                            <div>
                                <h3 class="text-2xl font-semibold">
                                    Training Questions
                                </h3>
                                <div>
                                    <x-a href="mailto:training@otoa.org" target="_blank">training@otoa.org</x-a>
                                </div>
                                <div class="text-xl">
                                    (216) 282-7928
                                </div>
                            </div>
                            <div>
                                <h3 class="text-2xl font-semibold">
                                    Conference Vendor Exhibition Questions
                                </h3>
                                <div>Terry Graham - President / Director of Exhibitions</div>
                                <div>
                                    <x-a href="mailto:terry.graham@otoa.org" target="_blank">terry.graham@otoa.org</x-a>
                                </div>
                                <div class="text-xl">
                                    (419) 656-0440
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-6 lg:mt-0 lg:w-96">

                        @livewire('contact-form')
                    </div>
                </div>







            </div>

        </section>

    </div>

</x-site-layout>
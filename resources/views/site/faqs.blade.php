<x-site-layout>
    @section("pageTitle")
    Frequently Asked Questions
    @endSection

    <x-banner bg="/img/faq-back.jpg">
        <div class="text-3xl lg:text-6xl">FAQs</div>
        <div class="text-xl lg:text-2xl">Frequently Asked Questions</div>
    </x-banner>

    <div class="flex-1">

        @foreach($categories as $category)
        <section class="{{ $loop->index % 2 > 0 ? 'bg-otsteel' :'' }}">
            <div class="max-w-7xl mx-auto p-6 pb-2 lg:flex lg:gap-6">
                <div class="text-xl font-medium lg:w-72 text-center lg:text-left mb-4 lg:mb-0">{{ $category->category }}</div>
                <div class="lg:flex-1">
                    @foreach($category->faqs as $faq)
                    <div class="onePod mb-4 border border-otblue bg-white">
                        <div class="oneHandle cursor-pointer text-lg flex items-center gap-3 transform duration-300">
                            <div class="py-2 px-4 flex-1">
                                {{ $faq->question }}
                            </div>
                            <div class="py-2 px-4 arrow transform duration-300">
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                        </div>
                        <div class="oneContent p-4 prose max-w-full text-lg" style="display:none;">
                            {!! $faq->answer !!}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endforeach


        <script type="text/javascript">
            $(document).ready(function() {
                $(".oneHandle").click(function() {
                    if ($(this).parent(".onePod").children(".oneContent").is(":visible")) {
                        $(this).parent(".onePod").children(".oneContent").slideUp(300);
                        $(this).children(".arrow").removeClass("rotate-90");
                        $(this).removeClass("bg-otblue");
                        $(this).removeClass("text-white");
                    } else {
                        $(this).parent(".onePod").children(".oneContent").slideDown(300);
                        $(this).children(".arrow").addClass("rotate-90");
                        $(this).addClass("bg-otblue");
                        $(this).addClass("text-white");
                    }
                });	
            });
        </script>

    </div>

</x-site-layout>
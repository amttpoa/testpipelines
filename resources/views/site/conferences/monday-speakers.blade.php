<x-site-layout>
    @section("pageTitle")
    {!! $page->name !!}
    @endSection

    <x-banner bg="/img/conventions12.jpg">
        <div class="text-3xl lg:text-6xl">Monday Speakers</div>
        <div class="text-base lg:text-lg">at the</div>
        <div class="text-xl lg:text-4xl">General Session Lecture Series</div>
    </x-banner>

    <div class="flex-1 bg-otsteel">
        <div class="max-w-4xl bg-white mx-auto p-6 py-12 ">

            <div class="mb-8">
                <div class="flex gap-3 items-center mb-4">
                    <div class="w-32">
                        <img class="w-32 h-32 rounded-full" src="https://otoa-website.s3.us-east-2.amazonaws.com/profiles/Jon%20Photo%202021-1675341879.jpg" />
                    </div>
                    <div class="flex-1">
                        <div class="text-2xl font-medium">IT STARTS WITH US: Leadership, Teamwork & Mindset</div>
                        <div class="text-otgray">presented by</div>
                        <div>
                            <x-a class="text-xl" href="https://otoa.org/staff/2130">Jon Gordon</x-a>
                            <span class="text-sm">– Best-Selling Author and Keynote Speaker</span>
                        </div>

                    </div>
                </div>
                <div class="mb-4">
                    Teams rise and fall on culture, leadership, relationships, attitude, and effort. Three things you control daily are your attitude, effort, and actions to be a great teammate. It doesn’t matter what is happening around you and who you think is being unfair. Every day you can focus on being positive, working hard, and making others around you better.
                </div>
                <div class="mb-4">
                    Jon Gordon's best-selling books and talks have inspired readers and audiences worldwide. His principles have been tested by numerous Fortune 500 companies, professional and college sports teams, school districts, hospitals, and non-profits. He is the author of 25 books, including 13 best sellers and 5 children’s books. His books include the timeless classic The Energy Bus which has sold over 2 million copies, The Carpenter which was a top 5 business book of the year; Training Camp, The Power of Positive Leadership, The Power of a Positive Team, The Coffee Bean, Stay Positive, The Garden, Relationship Grit, and The Sale. Jon and his tips have been featured on The Today Show, CNN, CNBC, The Golf Channel, Fox and Friends and in numerous magazines and newspapers. His clients include The Los Angeles Dodgers, The Atlanta Falcons, Campbell Soup, Dell, Publix, Southwest Airlines, LA Clippers, Miami Heat, Pittsburgh Pirates, Truist Bank, Clemson Football, Northwestern Mutual, Bayer, West Point Academy, and more.
                </div>
                <div class="mb-4">
                    Jon graduated from Cornell University and holds a Masters in Teaching from Emory University. He and his training/consulting company are passionate about developing positive leaders, organizations, and teams.
                </div>
            </div>



            <div class="mb-8">
                <div class="flex gap-3 items-center mb-4">
                    <div class="w-32 text-center">
                        <img class="w-20 h-20 rounded-full inline-block mb-2" src="https://otoa-website.s3.us-east-2.amazonaws.com/profiles/Eggers-1682339283.jpg" />
                        <img class="w-20 h-20 rounded-full inline-block" src="https://otoa-website.s3.us-east-2.amazonaws.com/profiles/Joerger-1682339240.jpg" />
                    </div>
                    <div class="flex-1">
                        <div class="text-2xl font-medium">Kidnapping/Hostage Rescue - Officer Involved Shooting Debrief</div>
                        <div class="text-otgray">presented by</div>
                        <div>
                            <x-a class="text-xl" href="https://otoa.org/staff/3758">Sgt. Ryan Eggers</x-a>
                            <div class="text-xs">and</div>
                            <x-a class="text-xl" href="https://otoa.org/staff/3759">Sgt. Shane Joerger</x-a>
                            <div class="text-sm mt-2">Indian River County, Florida Sheriff's Office</div>
                        </div>

                    </div>
                </div>
                <div class="mb-4">
                    In June of 2022, a multi-time convicted felon took two women hostage, shooting one. He led law enforcement on a three-county-wide pursuit that ended with a short vehicle barricade. The barricade turned into a rural manhunt and ended with a deputy-involved shooting. The incident was captured on dash, body worn, and an aviation camera. The debrief will chronologically break down the event, including the aforementioned videos, and finish with lessons learned.
                </div>
            </div>



            <div class="mb-8">
                <div class="flex gap-3 items-center mb-4">
                    <div class="w-32">
                        <img class="w-32 h-32 rounded-full" src="https://otoa-website.s3.us-east-2.amazonaws.com/profiles/unnamed-1675363006.jpg" />
                    </div>
                    <div class="flex-1">
                        <div class="text-2xl font-medium">Henry Pratt Active Shooter Debrief</div>
                        <div class="text-otgray">presented by</div>
                        <div>
                            <x-a class="text-xl" href="https://otoa.org/staff/1356">Chief Richard Robertson</x-a>
                            <span class="text-sm">– Aurora, Illinois Police Department</span>
                        </div>

                    </div>
                </div>
                <div class="mb-4">
                    On 15FEB19 at approximately 1330hrs, an employee brought a handgun to his termination meeting. After fatally shooting five co-workers and critically wounding another, he set up ambush points and waited for responding officers. The initial responding officers were fired upon by the offender, five of which were struck by gunfire. Additional responding officers made entry into the building, extracted an officer that was shot inside the building, and began to clear the 290,000-square-foot structure. Approximately 90 minutes after the beginning of the incident, the offender was located in his final ambush position, and the threat was terminated during a gunfight with officers.
                </div>
            </div>





            <div class="max-w-full prose hidden">
                {!! $page->content !!}
            </div>

        </div>
    </div>
</x-site-layout>
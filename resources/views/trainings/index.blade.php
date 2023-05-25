<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            Trainings
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.trainings.create') }}">Create Training</x-button-link>
        </div>
    </x-crumbs.bar>

    <x-cards.plain>

        <div class="overflow-hidden w-full">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead class="">
                        <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3 text-center">Active</th>
                            <th class="px-4 py-3 text-center">Hours</th>
                            <th class="px-4 py-3 text-center">Days</th>
                            <th class="px-4 py-3 text-center">Price</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-ot-steel">


                        @foreach($trainings as $training)
                        <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                            <td class="px-4 py-3 font-medium">
                                <a href="{{ route('admin.trainings.show', $training) }}">
                                    {{ $training->name }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-center">
                                {{ $training->active ? 'Active' : ''}}
                            </td>
                            <td class="px-4 py-3 text-center">
                                {{ $training->hours }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                {{ $training->days }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                ${{ $training->price }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a class="inline-flex items-center gap-1 text-otgold font-semibold" href="{{ route('admin.trainings.edit', $training) }}">
                                    <x-icons.edit class="w-4 h-4" /> Edit
                                </a>

                                <a class="ml-3 inline-flex items-center gap-1 text-otgold font-semibold" href="{{ route('admin.training-courses.create', $training) }}">
                                    <x-icons.add class="w-4 h-4" /> Course
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </x-cards.plain>

</x-app-layout>
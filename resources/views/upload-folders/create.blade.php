<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.upload-folders.index') }}">Upload Folders</x-crumbs.a>
            Create Folder
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>
        <x-form-errors />

        <form method="POST" id="main-form" x-data="slugHandler()" action="{{ route('admin.upload-folders.store') }}">
            @csrf

            <div class="grid xl:grid-cols-2 gap-3 mb-3">
                <div class="mb-3">
                    <x-label for="Name">Name</x-label>
                    <x-input id="name" name="name" x-model="name" @keyup="slugName" />
                </div>

                <div class="mb-3">
                    <x-label for="Slug">Slug</x-label>
                    <x-input id="slug" name="slug" x-model="slug" />
                </div>
            </div>
            <script type="text/javascript">
                function slugHandler() {
                return {
                    name: '',
                    slug: '',
                    slugName() {
                        // console.log(this.name);
                        this.slug = this.slugify(this.name);
                    },
                    slugify(text) {
                        return text
                            .toString()                           // Cast to string (optional)
                            .normalize('NFKD')            // The normalize() using NFKD method returns the Unicode Normalization Form of a given string.
                            .toLowerCase()                  // Convert the string to lowercase letters
                            .trim()                                  // Remove whitespace from both sides of a string (optional)
                            .replace(/\s+/g, '-')            // Replace spaces with -
                            .replace(/[^\w\-]+/g, '')     // Remove all non-word chars
                            .replace(/\-\-+/g, '-');        // Replace multiple - with single -
                    }
                }
            }
            </script>

            <x-fields.input-text label="Description" name="description" class="mb-3" />
            <div class="flex gap-3">
                <x-fields.select label="Restriction" name="restriction" :selections="$restrictions" class="mb-3" />
                <x-fields.input-text label="Order" type="number" name="order" class="mb-3" />
            </div>
        </form>
    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>
</x-app-layout>
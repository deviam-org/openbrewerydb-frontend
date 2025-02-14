<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Breweries') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
            <div class="px-10 mt-8 mx-auto md:px-6 2xl:px-10">

                <!-- Table start -->
                <x-table
                    name="breweries"
                    url="{{ route('breweries.ajax.index') }}"
                    :defaultSort="'name'"
                    :defaultSortOrder="'asc'"
                    :resultsPerPage="10"
                    :filters='[
                        "by_name" => [
                            "label" => "Name",
                            "placeholder" => "Search by Name",
                            "type" => "text",
                            "default" => ""
                        ],
                        "by_country" => [
                            "label" => "Country",
                            "placeholder" => "Search by Country",
                            "type" => "text",
                            "default" => ""
                        ]
                    ]'
                    :columns='[
                        "name" => [
                            "sortable" => true,
                            "label" => "Name"
                        ],
                        "type" => [
                            "sortable" => true,
                            "label" => "Type",
                        ],
                        "address" => [
                            "sortable" => false,
                            "label" => "Address",
                        ],
                        "country" => [
                            "sortable" => true,
                            "label" => "Country",
                        ],
                        "state" => [
                            "sortable" => false,
                            "label" => "State",
                        ],
                        
                ]' />
                <!-- Table end -->

            </div>
        </div>
</x-app-layout>
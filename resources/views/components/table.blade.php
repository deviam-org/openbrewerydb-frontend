<div
    x-data="{
        name: @js($name),
        isLoading: true,
        rows: [],
        meta: [],
        page: 1,
        sort: @js($defaultSort),
        dir: @js($defaultSortOrder),
        limit: @js(Session::get($tableLimit) ?? $resultsPerPage),
        filters: JSON.parse(JSON.stringify(@js(!empty(Session::get($tableFilters)) ? Session::get($tableFilters) : (object) []))),
        tableColumns: @js(json_decode($tableColumns)),

        makeRequest: function(key, value, resetPage = false) {

            if (key === 'page') {
                this.page = value;
            }

            this.isLoading = true;

            axios.post('{{ $url }}', {
                tableColumns: this.tableColumns,
                page: this.page,
                sort: `${this.sort}`,
                dir: `${this.dir}`,
                limit: this.limit,
                filters: this.filters,
                trashed: this.trashed,
            })
            .then(response => {
                setTimeout(()=>{
                    const data = response.data;
                    this.rows = data.html;
                    this.meta = data.meta;

                    this.isLoading = false;

                }, 150);

            })
            .catch(error => {
                setTimeout(()=>{
                    this.isLoading = false;
                }, 150);
            });
        },

        toggleSort(columnName, dir) {
            this.sort = columnName;
            this.dir = dir;
            this.makeRequest();
        },

        changePage(pageNumber) {
            this.page = pageNumber;
            this.makeRequest();
        },

        changeLimit(limit) {
            this.limit = limit;
            this.makeRequest();
        },

        clearFilters() {
            this.filters = {};
            this.makeRequest();
        },
    }"
    class="px-0"
    x-init="makeRequest()"
    x-on:keydown.window.enter="makeRequest()">

    <div class="flex items-center justify-between bg-white dark:bg-gray-800 shadow rounded-lg p-4">

        <div class="flex flex-row space-x-3 items-center">
            @foreach($filters as $filter_name => $filter)

            @if($filter['type'] == 'text')
            <x-form.input-text
                x-model="filters.{{ $filter_name }}"
                id="{{ $filter_name }}"
                name="{{ $filter_name }}"
                :clear-button="true"
                placeholder="{{ __($filter['placeholder']) }}"
                :value="Session::get('$tableFilters'.$filter_name)" />
            @endif

            @endforeach

            <div>
                <button
                    @click="makeRequest()"
                    type="button"
                    class="inline-flex w-full justify-center gap-x-1.5 px-3 py-2 rounded-md bg-green-500 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-black-200"
                    title="Search">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </div>

            <div>
                <button
                    @click="clearFilters()"
                    type="button"
                    class="inline-flex w-full items-center justify-center gap-x-1.5 px-3 py-2 rounded-md bg-red-400 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-red-200"
                    title="Clear">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex flex-row space-x-3 items-center">
            <div class="flex items-center justify-end">
                <select
                    id="per-page-results-toggler"
                    model="limit"
                    x-model="limit"
                    class="pr-8 rounded-md py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    @change="changeLimit($event.target.value)">
                    <option :value="5">5</option>
                    <option :value="10">10</option>
                    <option :value="25">25</option>
                </select>
            </div>
        </div>

    </div>
    <!-- Commands block end -->

    <div class="relative">
        <div
            x-show="isLoading"
            class="absolute inset-0 z-50 flex items-center justify-center bg-gray-100 bg-opacity-50"
            style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;">

            <div class="loader"></div>


        </div>

        <!-- Table start -->
        <div class="mt-8 flow-root" x-on:refresh-table.window="makeRequest">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">

                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">



                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-200 border-[1px] border-gray-300">
                                <tr class="divide-x divide-gray-300">

                                    <template x-for=" (column, index) in tableColumns" :key="index">
                                        <th scope="col"
                                            x-show="!column.hidden"
                                            x-cloak
                                            class="py-3.5 px-4 text-xs font-semibold text-gray-500"
                                            :data-column="index"
                                            :data-order="column.sortable ? 'asc' : 'desc'"
                                            @click="column.sortable ? toggleSort(index, dir == 'desc' ? 'asc' : 'desc') : null">
                                            <div class="flex items-center 'justify-start'" :class="column.class">
                                                <span x-text="column.label"></span>
                                                <div x-show="column.sortable" x-cloak>
                                                    <x-fas-sort class="ml-2 h-4 w-4 opacity-20" x-show="sort != index" x-cloak />
                                                    <x-fas-sort-down class="ml-2 h-4 w-4 opacity-70" x-show="dir == 'desc' && sort == index" x-cloak />
                                                    <x-fas-sort-up class="ml-2 h-4 w-4 opacity-70" x-show="dir == 'asc' && sort == index" x-cloak />
                                                </div>
                                            </div>
                                        </th>
                                    </template>
                                </tr>
                            </thead>

                            <template x-if="typeof rows === 'string' && rows.trim() !== ''">
                                <tbody x-html="rows" id="table-body" class="divide-y divide-gray-200 bg-white">

                                </tbody>
                            </template>

                            <template x-if="!rows || (typeof rows === 'string' && rows.trim() === '')">
                                <tbody id="table-body" class="divide-y divide-gray-200 bg-white">
                                    <tr class="bg-gray-50">
                                        <td colspan="100%" class="py-4 px-4 text-center text-sm text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto size-12">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                            </svg>
                                            No records found
                                        </td>
                                    </tr>
                                </tbody>
                            </template>

                        </table>

                        <x-paginators.default :baseRoute="$url" :currentPage="$currentPage" />

                    </div>
                </div>
            </div>
        </div>
        <!-- Table end -->
    </div>


</div>
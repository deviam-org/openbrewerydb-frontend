<div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
  <div class="flex flex-1 justify-between sm:hidden">
    <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
    <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
  </div>
  <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
    <div>
      <p class="text-sm text-gray-700">

        Showing from
        <template x-if="meta.current_page == 1 && meta.total_pages > 0">
          <span class="font-medium" x-text="1"></span>
        </template>
        <template x-if="meta.current_page == 1 && meta.total_pages == 0">
          <span class="font-medium" x-text="0"></span>
        </template>

        <template x-if="meta.current_page > 1">
          <span class="font-medium" x-text="(meta.current_page - 1) * meta.per_page + 1"></span>
        </template>

        to

        <template x-if="meta.current_page == meta.total_pages">
          <span class="font-medium" x-text="meta.total"></span>
        </template>
        <template x-if="meta.current_page < meta.total_pages">
          <span class="font-medium" x-text="meta.current_page * meta.per_page"></span>
        </template>
        Of
        <span class="font-medium" x-text="meta.total_items"></span>
        records
      </p>
    </div>
    <div>
      <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">

        <a href="#"
          @click.prevent="meta.current_page > 1 ? makeRequest('page', Number(Number(meta.current_page) - 1), true) : null"
          class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
          <span class="sr-only">Previous</span>
          <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
            <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
          </svg>
        </a>

        <template x-for="page in meta.total_pages">
          <a href="#"
            x-text="page"
            x-show="meta.current_page == page || meta.current_page == page - 1 || meta.current_page == page + 1"
            aria-current="page"
            @click="makeRequest('page', page, true)"
            :class="{
                    'bg-indigo-600 text-white' : page == meta.current_page,
                    'relative z-10 inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0 focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' : true
                }">
          </a>
        </template>

        <a href="#"
          @click.prevent="meta.total_pages !== meta.current_page ? makeRequest('page', Number(Number(meta.current_page) + 1), true) : null"
          class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
          <span class="sr-only">Next</span>
          <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
          </svg>
        </a>

      </nav>
    </div>
  </div>
</div>
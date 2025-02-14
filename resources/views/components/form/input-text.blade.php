@props([
'id' => '',
'name' => '',
'placeholder' => '',
'inputClass' => '',
'wrapperClass' => '',
'clearButton' => false,
])

<div @if($wrapperClass) class="{{$wrapperClass}}" @endif>

    <div class="flex rounded-md">
        <div class="relative flex flex-grow items-stretch focus-within:z-10">

            <input
                id="{{$id}}"
                name="{{$name}}"
                type="text"
                placeholder="{{ $placeholder }}"
                @class([ 
                    'block w-full border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 ' . $inputClass, 'rounded-none rounded-l-md'=> $clearButton == true,
                    'rounded-md' => $clearButton == false
                ])
                {{ $attributes }}
            />
        </div>

        @if($clearButton)
        <button
            class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-md px-3 py-2 text-sm font-semibold text-gray-500 ring-1 ring-inset ring-gray-300 bg-gray-100 hover:bg-gray-50"
            @click="document.getElementById('{{ $id }}').value = ''; {{ $attributes->get('x-model') }} = ''">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </button>
        @endif

    </div>

</div>
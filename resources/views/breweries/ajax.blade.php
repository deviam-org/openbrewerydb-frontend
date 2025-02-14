@if(!empty($data) && count($data) > 0)

@foreach($data as $row)

<tr class="divide-x divide-gray-200">

    <td class="w-[350px] px-4 py-2">
        <div class="text-sm">
            {{ $row['name'] }}
        </div>
    </td>

    <td class="px-4 py-2 text-center">
        <div class="text-sm text-gray-900 font-semibold">
            <span class="font-normal">{{ $row['brewery_type'] ?? '-'}}</span>
        </div>
    </td>

    <td class="px-4 py-2 text-center">
        <div class="text-sm text-gray-900 font-semibold">
            <span class="font-normal">
                {{ $row['address']['address_1'] ?? '-' }} - {{ $row['address']['city'] ?? '-' }}
            </span>
        </div>
    </td>

    <td class="w-[150px] px-4 py-2 text-center">
        <div class="text-sm text-gray-900">
            {{ $row['address']['country'] ?? '-' }}
        </div>
    </td>

    <td class="w-[150px] px-4 py-2 text-center">
        <div class="text-sm text-gray-900">
            {{ $row['address']['state_province'] ?? '-' }}
        </div>
    </td>

</tr>

@endforeach

@endif
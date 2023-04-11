<table class="w-full max-w-[50ch] mb-8 table-auto">
    @foreach ($content as $row)
        @php $is_header_row = $loop->first @endphp
        <tr>
            @foreach ($row as $cell)
                @if ($withHeadings && $is_header_row)
                    <th class="type-xs-mono border-b border-sand-dark p-4 pl-0 text-left">
                    @else
                    <td class="border-b border-sand-dark p-4 pl-0">
                @endif
                {!! $cell !!}
                @if ($withHeadings && $is_header_row)
                    </th>
                @else
                    </td>
                @endif
            @endforeach
        </tr>
    @endforeach
</table>

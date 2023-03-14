@if ($layout->details)
    <h3 class="type-xs-mono">Info:</h3>
    <table class="mt-4 mb-12 border-t border-sand-dark w-full max-w-[55ch] table-fixed">
        @foreach ($layout->details as $key => $value)
            <tr class="border-b border-sand-dark">
                <td class="py-4 font-bold w-48">{{ $key }}</td>
                <td class="py-4">{{ $value }}</td>
            </tr>
        @endforeach
    </table>
@endif

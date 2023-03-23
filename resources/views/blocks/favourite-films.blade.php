@if ($layout->favourite_films)
    @php $layout->favourite_films = (array) $layout->favourite_films @endphp
    <h3 class="type-xs-mono">My top
        {{ count($layout->favourite_films) > 1 ? count($layout->favourite_films) . ' films' : 'film' }} </h3>
    <table class="mt-4 mb-12 border-t border-sand-dark w-full max-w-[55ch] table-auto">
        @foreach ($layout->favourite_films as $film => $year)
            <tr class="border-b border-sand-dark">
                <td class="py-4 font-bold">{{ $film }}</td>
                <td class="py-4">{{ $year }}</td>
            </tr>
        @endforeach
    </table>
@endif

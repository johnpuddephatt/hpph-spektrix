@if ($layout->favourite_films)
    <h3 class="type-xs-mono">My top
        {{ count($layout->favourite_films) > 1 ? count($layout->favourite_films) . ' films' : 'film' }} <h3>
            <table class="mt-4 mb-12 border-t border-sand-dark w-full max-w-[55ch] table-auto">
                @foreach ($layout->favourite_films as $film)
                    <tr class="border-b border-sand-dark">
                        <td class="py-4">{{ $film }}</td>
                    </tr>
                @endforeach
            </table>
@endif

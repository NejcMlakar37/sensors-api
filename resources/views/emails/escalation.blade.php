<x-mail::message>
# {{ $incident['type'] == 'temp'? 'Temperatura pri senzorju ' . $sensor['location'] . ' je izven mej!' : 'Vlaga pri senzorju ' . $sensor['location'] . ' je izven mej!'   }}

<x-mail::panel color="red">
    Vrednost {{ $measurements['value'] }} je izven mej {{ $measurements['min'] }} in {{ $measurements['max'] }}!
    Za senzor: {{ $sensor['name'] }} v {{ $sensor['location'] }}.
</x-mail::panel>

</x-mail::message>

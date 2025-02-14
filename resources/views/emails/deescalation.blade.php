<x-mail::message>
# {{ $incident['type'] == 'temp'? 'Temperatura pri senzorju ' . $sensor['location'] . ' je nazaj v mejah!' : 'Vlaga pri senzorju ' . $sensor['location'] . ' je nazaj v mejah!'   }}

<x-mail::panel color="green">
    {{ $incident['type'] == 'temp'? 'Temperatura' : 'Vlaga' }} se je stabilizirala. Za senzor: {{ $sensor['name'] }} v {{ $sensor['location'] }}.
</x-mail::panel>

</x-mail::message>

<x-mail::message>
# Baterija senzorja {{ $sensor['name'] }} je padla pod 25%!

<x-mail::panel color="red">
    Senzor {{ $sensor['name'] }} v {{ $sensor['location'] }} ima le še {{ $battery }} % baterije!
    Potrebno je zamenjati baterijo.
</x-mail::panel>

</x-mail::message>

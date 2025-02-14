<x-mail::message>
# Nova naloga!

<x-mail::panel>
    Dodeljena vam je bila nova naloga: <br/> {{ $task['description'] }} <br/>
    z rokom izvedbe {{ $task['deadline'] }}!
</x-mail::panel>

<x-mail::button :url="$url">
    Ogled naloge
</x-mail::button>

</x-mail::message>

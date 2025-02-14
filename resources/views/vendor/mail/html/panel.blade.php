@props([
    'color' => 'primary',
])

<table class="panel panel-{{ $color }}" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td class="panel-content panel-content-{{ $color }}">
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="panel-item">
                        {{ $slot }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

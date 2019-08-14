{!! img('character', $row->character_id, 64, ['class' => 'img-circle eve-icon small-icon'], false) !!}
@if (! is_null($row->character))
    <a href="{{ route('character.view.sheet', ['character_id' => $row->character_id]) }}">
        {{ $row->character->name }}
    </a>
@else
    <span class="id-to-name" data-id="{{ $row->character_id }}">{{ trans('web::seat.unknown') }}</span>
@endif
@if(! is_null($row->user) && ! is_null($row->user->group->main_character_id) && $row->user->group->main_character_id != 0)
<span class="text-muted pull-right">
    <i>(<span rel="id-to-name">{{ $row->user->group->main_character_id }}</span>)</i>
</span>
@endif

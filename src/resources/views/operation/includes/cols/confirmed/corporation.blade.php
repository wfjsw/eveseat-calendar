@if(! is_null($row->corporation))
    <a href="{{ route('corporation.view.summary', ['corporation_id' => $row->corporation->corporation_id]) }}">
        {!! img('corporation', $row->character->corporation_id, 64, ['class' => 'img-circle eve-icon small-icon'], false) !!}
        {{ $row->corporation->name }}
    </a>
@elseif (! is_null($row->character))
    {!! img('corporation', $row->character->corporation_id, 64, ['class' => 'img-circle eve-icon small-icon'], false) !!}
    <span class="id-to-name" data-id="{{ $row->character->corporation_id }}">{{ trans('web::seat.unknown') }}</span>
@endif

@if(!$type)
    <a class="btn btn-secondary text-center" href="{{ route('recreate_password',$body['_token']) }}">Վերականգնել գաղտնաբառը</a>
@else

    @if(!empty($body['message']))
        <h4>{{ $body['message'] }}</h4>
    @endif

@endif
@extends('layouts.app')

@section('content')
    <div class="container">
        <game url="{{ $game->url_code }}"></game>
    </div>
@endsection

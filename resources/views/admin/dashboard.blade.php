@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Your Games</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (count($games) > 0)
                        <ul>
                            @foreach ($games as $game)
                                <li>{{ $game->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        You don't have any games yet!
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

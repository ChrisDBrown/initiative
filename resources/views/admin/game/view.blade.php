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

                        {{ $game->name }}<br>
                        {{ $game->state }}
                        {!! Form::open(['action' => ['Admin\GameController@nextState', $game->id]]) !!}
                        <fieldset>
                            {!! Form::token() !!}
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    {!! Form::submit('Next State', ['class' => 'btn btn-lg btn-info pull-right'] ) !!}
                                </div>
                            </div>
                        </fieldset>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

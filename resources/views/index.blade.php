@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h3>Форма для сокращения ссылок</h3>

                <div class="card-body">
                    {{ Form::open(['action' => ['LinkController@create']]) }}
                    {{ Form::label('url', 'URL адрес') }}&nbsp;
                    {{ Form::text('url') }}
                    {{ Form::token() }}
                    {{ Form::submit('Сократить') }}
                    {{ Form::close() }}
                </div>

                @if(count($errors))
                    <div class="form-group">
                        <div class="alert alert-danger">
                            <ul class="list-group list-unstyled">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="mt-5">
                    <h3>Список сокращенных ссылок</h3>
                    <ul class="list-group">
                        @forelse ($links as $link)
                            @php
                                $shortUrl = route('link.get', ['token' => $link->token]);
                            @endphp
                            <li class="list-group-item">
                                <a href="{{ $shortUrl }}" target="_blank">{{ $shortUrl }}</a> ({{ $link->url }})
                            </li>
                        @empty
                            <p>Ссылок пока нет</p>
                        @endforelse
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

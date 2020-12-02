@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>{{ $thread->title }}</h2>
            <hr>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <small>Criado por {{ $thread->user->name }} há {{ $thread->created_at->diffForHumans() }}</small>
                </div>
                <div class="card-body">
                    {{ $thread->body }}
                </div>
                @can('update', $thread)
                <div class="card-footer">
                    <a href="{{ route('threads.edit', $thread->slug) }}" class="btn btn-sm btn-primary">Editar</a>
                    <button class="btn btn-sm btn-danger"
                            onclick="event.preventDefault();
                                document.querySelector('.thread-rm').submit()">
                        Remover</button>
                    <form method="post" action="{{ route('threads.destroy', $thread->slug) }}" class="thread-rm">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                @endcan
            </div>
            <hr>
        </div>

        @if($thread->replies->count() > 0)
        <div class="col-12">
            <h5>Respostas</h5>
            <hr>
            @foreach($thread->replies as $reply)
                <div class="card mb-3">
                    <div class="card-body">
                        {{ $reply->reply }}
                    </div>
                    <div class="card-footer">
                        <small>Respondido por {{ $reply->user->name }} há {{ $reply->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @endforeach
        </div>
        @endif

        <div class="col-12">
        @auth()
            <hr>
            <form method="post" action="{{ route('replies.store') }}">
                @csrf
                <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                <div class="form-group">
                    <label for="reply">Responder</label>
                    <textarea name="reply" id="" cols="30" rows="5" class="form-control @error('reply') is-invalid @enderror">{{ old('reply') }}</textarea>
                    @error('reply')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">Responder</button>
            </form>
        @else
            <div class="text-center">
                <h5>Faça login para poder comentar o tópico.</h5>
            </div>
        @endauth
        </div>
    </div>
@endsection

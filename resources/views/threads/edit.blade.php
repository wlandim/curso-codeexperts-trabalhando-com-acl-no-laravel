@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>Editar Tópico</h2>
            <hr>
        </div>
        <div class="col-12">
            <form method="post" action="{{ route('threads.update', $thread->slug) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Título do tópico</label>
                    <input name="title" id="title" value="{{ $thread->title }}" class="form-control @error('title') is-invalid @enderror">
                    @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="body">Conteúdo do tópico</label>
                    <textarea name="body" id="body" cols="30" rows="10" class="form-control @error('body') is-invalid @enderror">{{ $thread->body }}</textarea>
                    @error('body')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-lg btn-success">Atualizar tópico</button>
            </form>
        </div>
    </div>
@endsection

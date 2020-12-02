@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>Criar Tópico</h2>
            <hr>
        </div>
        <div class="col-12">
            <form method="post" action="{{ route('threads.store') }}">
                @csrf
                <div class="form-group">
                    <label for="channel_id">Canal:</label>
                    <select name="channel_id" id="channel_id" class="form-control @error('channel_id') is-invalid @enderror">
                        <option value="">Selecione um canal</option>
                        @foreach($channels as $channel)
                            <option value="{{ $channel->id }}"
                                    @if(old('channel_id') == $channel->id) selected @endif
                            >{{ $channel->name }}</option>
                        @endforeach
                    </select>
                    @error('channel_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="title">Título do tópico</label>
                    <input name="title" id="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror">
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="body">Conteúdo do tópico</label>
                    <textarea name="body" id="body" cols="30" rows="10" class="form-control @error('body') is-invalid @enderror">{{ old('body') }}</textarea>
                    @error('body')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-lg btn-success">Criar tópico</button>
            </form>
        </div>
    </div>
@endsection

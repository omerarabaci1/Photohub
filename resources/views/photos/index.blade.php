@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Fotoğraflar</h2>

    <a href="{{ route('photos.create') }}" class="btn btn-success mb-3 d-block mx-auto" style="max-width: 200px;">Yeni Fotoğraf Yükle</a>

    <div class="row">
        @foreach ($photos as $photo)
            <div class="col-12 col-sm-6 col-md-4 mb-4">

                <div class="card">
                    <img src="{{ asset('storage/' . $photo->image_path) }}" class="card-img-top img-fluid" alt="Fotoğraf">

                    <div class="card-body">
                        <p>{{ $photo->caption }}</p>
                        <small class="text-muted">Yükleyen: {{ $photo->user->name }}</small>

                        {{-- Beğeni Butonu ve Sayısı --}}
                        <div class="mt-2">
                            <form action="{{ $photo->isLikedByUser(auth()->id()) ? route('photos.unlike', $photo) : route('photos.like', $photo) }}" method="POST">
                                @csrf
                                @if($photo->isLikedByUser(auth()->id()))
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Beğenme ❤️</button>
                                @else
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Beğen ❤️</button>
                                @endif
                            </form>
                            <small>{{ $photo->likes()->count() }} Beğeni</small>
                        </div>
                        {{-- Beğeni Bitiş --}}

                        {{-- Yorumlar --}}
                        <div class="mt-3">
                            <h6>Yorumlar</h6>
                            @foreach ($photo->comments as $comment)
                                <div class="border p-2 mb-1">
                                    <strong>{{ $comment->user->name }}</strong>:
                                    {{ $comment->comment }}
                                    <br>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                            @endforeach

                            {{-- Yorum Ekleme Formu --}}
                            <form action="{{ route('photos.comment', $photo) }}" method="POST">
                                @csrf
                                <div class="input-group mt-2">
                                    <input type="text" name="comment" class="form-control" placeholder="Yorum yaz..." required>
                                    <button class="btn btn-primary" type="submit">Gönder</button>
                                </div>
                                @error('comment')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </form>
                        </div>
                        {{-- Yorumlar Bitiş --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

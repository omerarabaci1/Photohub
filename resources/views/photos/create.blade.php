@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Fotoğraf Yükle</h2>
    <form method="POST" action="{{ route('photos.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Fotoğraf Seç</label>
            <input type="file" name="image" class="form-control" required>
            @error('image')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Açıklama (Opsiyonel)</label>
            <input type="text" name="caption" class="form-control" maxlength="255">
            @error('caption')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Yükle</button>
    </form>
</div>
@endsection

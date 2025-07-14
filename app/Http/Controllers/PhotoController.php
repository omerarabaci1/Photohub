<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use App\Models\PhotoLike;
use Illuminate\Support\Facades\Auth;
use App\Models\PhotoComment;

class PhotoController extends Controller
{
    public function storeComment(Request $request, Photo $photo)
{
    $request->validate([
        'comment' => 'required|string|max:1000',
    ]);

    PhotoComment::create([
        'user_id' => auth()->id(),
        'photo_id' => $photo->id,
        'comment' => $request->comment,
    ]);

    return redirect()->back()->with('success', 'Yorumunuz eklendi!');
}
    public function like(Photo $photo)
{
    $user = Auth::user();

    if (!$photo->isLikedByUser($user->id)) {
        PhotoLike::create([
            'user_id' => $user->id,
            'photo_id' => $photo->id,
        ]);
    }

    return redirect()->back();
}

public function unlike(Photo $photo)
{
    $user = Auth::user();

    PhotoLike::where('user_id', $user->id)->where('photo_id', $photo->id)->delete();

    return redirect()->back();
}
    public function index()
    {
        // Tüm fotoğrafları kullanıcı bilgisiyle birlikte getir
        $photos = Photo::latest()->with('user')->get();
        return view('photos.index', compact('photos'));
    }

    public function create()
    {
        // Fotoğraf yükleme formunu göster
        return view('photos.create');
    }

    public function store(Request $request)
    {
        // Gelen veriyi doğrula
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:20048',
            'caption' => 'nullable|string|max:255',
        ]);

        // Fotoğrafı storage/app/public/photos klasörüne kaydet
        $imagePath = $request->file('image')->store('photos', 'public');

        // Veritabanına kaydet
        Photo::create([
            'user_id' => auth()->id(),
            'image_path' => $imagePath,
            'caption' => $request->caption,
        ]);

        return redirect()->route('photos.index')->with('success', 'Fotoğraf başarıyla yüklendi!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        // Fetch paginated posts (6 per page) instead of all
        $posts = Post::latest()->paginate(6);
        return view('home', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'media' => 'required|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480', // 20MB max
        ]);

        $file = $request->file('media');
        $mediaType = $file->getClientMimeType();

        $path = $file->store('media', 'public');

        $type = str_contains($mediaType, 'image') ? 'image' : 'video';

        Post::create([
            'media_path' => $path,
            'media_type' => $type,
        ]);

        return redirect()->route('home');
    }
}

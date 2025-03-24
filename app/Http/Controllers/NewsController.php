<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('category', 'user')->latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $category = Category::all();
        return view('admin.news.create', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::all();
        $news = News::find($id);
        return view('admin.news.edit', compact('news', 'category'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'content' => 'required'
        ]);
        $news = News::find($id);
        if($news->exists()) {
            $data = [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'category_id' => $request->category,
                'content' => $request->content,
                'user_id' => 1
            ];
            $news->update($data);
            return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui');
        }
        return response()->json(['message' => 'Berita tidak ditemukan'], 404);
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/images', $fileName, 'public');
            return response()->json([
                'url' => asset('storage/uploads/images/' . $fileName),
                'filename' => $fileName
            ]);
        }
        return response()->json(['error' => 'gagal mengupload gambar'], 500);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'image' => 'required',
            'content' => 'required'
        ]);
        // dd($validated);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category_id' => $request->category,
            'image' => $request->image,
            'content' => $request->content,
            'user_id' => 1
        ];
        $save = News::create($data);
        // dd($save);
        return redirect()->route('news.index')->with('success', 'Berita berhasil disimpan');
    }

    public function deleteImage(string $filename)
    {
        if(file_exists(storage_path('app/public/uploads/images/' . $filename))) {
            unlink(storage_path('app/public/uploads/images/' . $filename));
        }
    }

    public function destroy(string $id)
    {
        $theNews = News::find($id);
        if($theNews->exists()) {
            $this->deleteImage($theNews->image);
            $theNews->delete();
            return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus');
        }
        return response()->json(['message' => 'Berita tidak ditemukan'], 404);
    }
}

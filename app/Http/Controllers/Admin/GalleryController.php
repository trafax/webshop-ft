<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::all();

        return view('gallery.admin.index')->with('galleries', $galleries);
    }

    public function create()
    {
        return view('gallery.admin.create');
    }

    public function store(Request $request)
    {
        $gallery = new Gallery();
        $gallery->fill($request->all());
        $gallery->save();

        return redirect()->route('admin.gallery.index')->with('message', 'Fotoalbum succesvol toegevoegd.');
    }

    public function edit(Gallery $gallery)
    {
        return view('gallery.admin.edit')->with('gallery', $gallery);
    }

    public function update(Request $request, Gallery $gallery)
    {
        $gallery->fill($request->all());
        $gallery->save();

        return redirect()->route('admin.gallery.index')->with('message', 'Fotoalbum succesvol aangepast.');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('message', 'Fotoalbum succesvol verwijderd.');
    }
}

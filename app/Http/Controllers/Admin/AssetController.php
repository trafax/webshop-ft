<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AssetController extends Controller
{
    public function upload(Request $request)
    {
        $path = $request->file('file')->store('assets', 'public');

        $data = array_merge($request->all(), ['file' => $path]);

        $asset = new Asset();
        $asset->fill($data);
        $asset->save();

        return $path;
    }

    public function sort(Request $request)
    {
        foreach ($request->get('items') as $key => $id)
        {
            $asset = Asset::find($id);
            $asset->sort = $key;
            $asset->save();
        }
    }

    public function delete(Asset $asset, $hash = 'images')
    {
        Storage::disk('public')->delete($asset->file);

        $asset->delete();

        return redirect()->to(url()->previous() . '#'.$hash);
    }

    public function upload_tinymce(Request $request)
    {
        $path = $request->file('file')->store('assets', 'public');

        $data = array_merge($request->all(), ['file' => $path]);

        $asset = new Asset();
        $asset->fill($data);
        $asset->save();

        return response()->json(['location' => '/storage/'.$path]);

    }
}

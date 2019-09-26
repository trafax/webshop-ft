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
        // $image = $request->file('file');
        // Image::make($image)->fit(2000)->save();
        // $path = $image->store('assets', 'public');

        $data = array_merge($request->all(), ['file' => $path]);

        $asset = new Asset();
        $asset->fill($data);
        $asset->save();

        return $path;
    }

    public function delete(Asset $asset, $hash = 'images')
    {
        Storage::disk('public')->delete($asset->file);

        $asset->delete();

        return redirect()->to(url()->previous() . '#'.$hash);
    }
}

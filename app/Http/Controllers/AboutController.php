<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class AboutController extends Controller
{
    public function index()
    {
        $info = About::find(1);
        return view('admin.about', compact('info'));
    }
    public function update(Request $request)
    {
        // return $request;

        $info = About::find(1);

        if ($request->logo == null) {
            $data = $request->validate([
                'name' => 'required|max:255',
                'address' => 'required|max:255',
                'phone' => 'required|max:255',
            ]);
            $info->update($data);
        } else {

            $data = $request->validate([
                'name' => 'required|max:255',
                'address' => 'required|max:255',
                'phone' => 'required|max:255',
                'logo' => 'image|mimes:jpeg,png,jpg'
            ]);
            $file = $request->logo;
            $originalName = $file->getClientOriginalName();
            $file->move(public_path('logo'), $originalName);
            $data['logo'] = $originalName;
            $info->update($data);
        }

        return redirect()->route('about');
    }
}

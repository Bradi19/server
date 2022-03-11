<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class BannerController extends BaseController
{
    public function edit(Request $request)
    {
        if ($request->method() === 'POST') {

            $file = $request->file('image');
            if ($file) {
                $path = Storage::putFile('public', $file);
                Storage::setVisibility($file, 'public');
            }

            $banner = Banner::find($request->input('id'));
            $banner->title = $request->input('title');
            $banner->body = $request->input('body');

            if(isset($path)){
                $banner->paramsBanner = json_encode(['url' => $path, 'public_url' => str_replace('public', 'public/storage', $path)]);
            }
            $banner->save();
        }
        return response()->json(['data' => [], 'success' => true]);

    }
    public function add(Request $request)
    {
        if ($request->method() === 'POST') {

            $file = $request->file('image');
            $path = '';
            if ($file) {
                $path = Storage::putFile('public', $file);

                Storage::setVisibility($file, 'public');
            }
            $banner = new Banner();
            $banner->title = $request->input('title');
            $banner->paramsBanner =  json_encode(['url' => $path, 'public_url' => str_replace('public', '/storage', $path)]);
            $banner->body = $request->input('body');
            $banner->save();
            $data = $banner->all();
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['paramsBanner'] = json_decode($data[$i]['paramsBanner']);
            }
        }
        return response()->json(['data' => $data, 'success' => true]);
    }
    public function remove(Request $request)
    {

        if($request->method() === 'POST'){
            $banner = Banner::find($request->input('id'));
            $banner->delete();
        }
        return response()->json(['data' => $request->input('id'), 'success' => true]);

    }
    public function addBanner(Request $request)
    {
        $banner = new Banner();
        $data = $banner->all();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['paramsBanner'] = json_decode($data[$i]['paramsBanner']);
        }
        return view('dashboard.addBanner', ['data' => $data]);
    }
    public function index()
    {
        return view('dashboard');
    }
}

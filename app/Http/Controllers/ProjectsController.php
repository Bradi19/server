<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class ProjectsController extends Controller
{
    public function add(Request $request)
    {
        if ($request->method() === 'POST') {

            $file = $request->file('image');
            $name = "";
            $path = "";
            if (!empty($file)) {
                $path = Storage::putFile('public', $file);
                $name = str_replace('public/', '', $path);
                Storage::setVisibility($file, 'public');
            }

            $banner = new Projects();
            $banner->title = $request->input('title');
            $banner->lang = $request->input('lang');
            $banner->paramsBanner =  json_encode(['url' => $path, 'public_url' => str_replace('public', '/storage', $path)]);
            $banner->body = $request->input('body');
            $banner->link =  storage_path('app/public');
            $banner->img = str_replace('?', '', trim($name));
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
        if ($request->method() === 'POST') {
            $banner = Projects::find($request->input('id'));
            $banner->delete();
        }
        return response()->json(['data' => $request->input('id'), 'success' => true]);
    }
    public function edit(Request $request)
    {
        if ($request->method() === 'POST') {

            $file = $request->file('image');
            $path = "";
            $name = "";
            if (!empty($file)) {
                $path = Storage::putFile('public', $file);
                Storage::setVisibility($file, 'public');
                $name = str_replace('public/', '', $path);
            }

            $banner = Projects::find($request->input('id'));
            $banner->title = $request->input('title');
            $banner->lang = $request->input('lang');
            $banner->paramsBanner =  json_encode(['url' => $path, 'public_url' => str_replace('public', '/storage', $path)]);
            $banner->body = $request->input('body');
            $banner->link =  storage_path('app/public');
            $banner->img = str_replace('?', '', trim($name));
            $banner->save();
        }
        return response()->json(['data' => [], 'success' => true]);
    }
    public function getData(Request $request)
    {
        $id = (int)$request->input('id');
        $project = Projects::find($id);
        $project['paramsBanner'] = json_decode($project['paramsBanner']);
        $project['link'] = Storage::url(str_replace("?", "", trim($project['img'])));
        return response()->json(['data' => $project, 'success' => true]);
    }
    public function index(Request $request)
    {
        $banner = new Projects();
        $data = $banner->all();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['paramsBanner'] = json_decode($data[$i]['paramsBanner']);
            $data[$i]['link'] = Storage::url(str_replace("?", "", trim($data[$i]['img'])));
        }
        return view('dashboard.addProject', ['data' => $data]);
    }
}

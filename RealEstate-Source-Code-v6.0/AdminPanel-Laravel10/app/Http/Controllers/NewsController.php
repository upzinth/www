<?php

namespace App\Http\Controllers;

use App\Library\FileHelper;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    public $validationRules = [
        'category_id' => 'required',
        'title' => 'required',
        'content' => 'required',
        'image_name' => 'required',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::all();
        return view('news.index', ['news' => $news]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('news.create', ['news_categories' => NewsCategory::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationRules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $imageName = $request->input('image_name');
        $news = new News;
        $news->category_id = $request->input('category_id');
        $news->title = $request->input('title');
        $news->content = $request->input('content');
        $news->image_name = $imageName;
        $news->save();
        FileHelper::moveCacheToImages($imageName);
        return redirect('news');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $news = News::findOrFail($id);
        $newsCategories = NewsCategory::all();
        return view('news.edit', ['news' => $news, 'news_categories' => $newsCategories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->validationRules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $imageName = $request->input('image_name');
        $news = News::findOrFail($id);
        if ($news->image_name != $imageName) {
            FileHelper::removeImageFile($news->image_name);
        }
        $news->category_id = $request->input('category_id');
        $news->title = $request->input('title');
        $news->content = $request->input('content');
        $news->image_name = $imageName;
        $news->update();
        FileHelper::moveCacheToImages($imageName);
        return redirect('news');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        FileHelper::removeImageFile($news->image_name);
        $news->delete();
        return redirect('news');
    }
}

<?php

namespace App\Http\Controllers\api\v1;

use App\Models\News;

class NewsController extends BaseAPIController
{
    public function get()
    {
        $news = News::with('category')->get();
        return $this->responseJSON($news);
    }
}
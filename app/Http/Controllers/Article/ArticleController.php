<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::get();
        return ArticleResource::collection($articles);
        //jika tidak ingin menggunakan ArticleCollection maka gunakan method ini
        // return new ArticleCollection($articles);
        //jika anda ingin menampilakn data dengan response maka lebih baik menggunakan ArticleCollection ini, jika tidak perlu ArticleResource sdh cukup
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'body' => ['required'],
            'subject' => ['required'],
        ]);

        $articles = auth()->user()->articles()->create($this->articleStore());

        return $articles;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $article->update($this->articleStore());
        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json('The article was delete', 200);
    }

    public function articleStore()
    {
        return [
            'title' => request('title'),
            'slug' => \Str::slug(request('title')) ,
            'body' => request('body'),
            'subject_id' => request('subject'),
        ];
    }
}

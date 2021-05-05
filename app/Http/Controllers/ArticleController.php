<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Traits\ApiResponser;
use App\Transformers\ArticleTransformer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    use ApiResponser;

    protected $transformer;

    public function __construct(ArticleTransformer $articleTransformer)
    {
        $this->transformer = $articleTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::where('user_id', Auth::id())->with('autor')->get();

        return $this->successResponse($this->transformer->transformCollection($articles->all(), 'list'), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $article = Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return $this->successResponse($this->transformer->transform($article), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $this->authorize('view', $article);

        // if (Auth::id() != $article->user_id) {
        //     return $this->errorResponse('Access denied!', Response::HTTP_FORBIDDEN);
        // }

        return $this->successResponse($this->transformer->transform($article), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);

        // if (Auth::id() != $article->user_id) {
        //     return $this->errorResponse('Access denied!', Response::HTTP_FORBIDDEN);
        // }

        $article->fill($request->all())->save();

        return $this->successResponse($this->transformer->transform($article), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        // if (Auth::id() != $article->user_id) {
        //     return $this->errorResponse('Access denied!', Response::HTTP_FORBIDDEN);
        // }

        $article->delete();

        return $this->successResponse('', Response::HTTP_NO_CONTENT);
    }
}

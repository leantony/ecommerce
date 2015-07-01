<?php

namespace App\Http\Controllers\Backend\Articles;

use app\Antony\DomainLogic\Modules\Articles\ArticlesRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Articles\ArticleRequest;
use app\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use yajra\Datatables\Datatables;

class ArticlesController extends Controller
{
    /**
     * @var ArticlesRepository
     */
    private $articlesEntity;

    /**
     * @param ArticlesRepository $articlesEntity
     */
    public function __construct(ArticlesRepository $articlesEntity)
    {

        $this->articlesEntity = $articlesEntity;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('backend.articles.index');
    }

    /**
     * @return mixed
     */
    public function getDataTable()
    {

        $articles = $this->articlesEntity->select(['id', 'topic', 'created_at', 'updated_at']);

        return Datatables::of($articles)->addColumn('edit', function ($article) {
            return link_to(route('backend.articles.edit', ['articles' => $article->id]), 'Edit', ['data-target-model' => $article->id, 'class' => 'btn btn-xs btn-primary']);
        })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ArticleRequest $request
     * @return Response
     */
    public function store(ArticleRequest $request)
    {
        $this->data = $this->articlesEntity->add($request->all());

        return $this->handleRedirect($request, route('backend.articles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return Response
     */
    public function show(Article $article)
    {
        return view('backend.articles.edit', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Article $article
     * @return Response
     */
    public function edit(Article $article)
    {
        return view('backend.articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ArticleRequest $request
     * @param Article $article
     * @return Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $this->data = $article->update($request->all());

        return $this->handleRedirect($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Article $article
     * @return Response
     * @throws \Exception
     */
    public function destroy(Request $request, Article $article)
    {
        $this->data = $article->delete();

        return $this->handleRedirect($request, route('backend.articles.index'));
    }


}

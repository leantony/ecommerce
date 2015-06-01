<?php namespace App\Http\Controllers\Backend;

use app\Antony\DomainLogic\Modules\Articles\Base\ArticlesEntity;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Articles\ArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticlesController extends Controller
{
    /**
     * @var ArticlesEntity
     */
    private $articlesEntity;

    /**
     * @param ArticlesEntity $articlesEntity
     */
    public function __construct(ArticlesEntity $articlesEntity)
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
        $articles = $this->articlesEntity->get();

        return view('backend.articles.index', compact('articles'));
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
        $this->data = $this->articlesEntity->create($request->all());

        return $this->handleRedirect($request, route('backend.articles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $article = $this->articlesEntity->retrieve($id);

        return view('backend.articles.edit', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $article = $this->articlesEntity->retrieve($id);

        return view('backend.articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ArticleRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(ArticleRequest $request, $id)
    {
        $this->data = $this->articlesEntity->edit($id, $request->all());

        $this->redirectToUrlInSession = true;

        return $this->handleRedirect($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $this->data = $this->articlesEntity->delete($id);

        return $this->handleRedirect($request, route('backend.articles.index'));
    }


}

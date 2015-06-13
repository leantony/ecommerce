<?php namespace App\Http\Controllers\Shared;

use app\Antony\DomainLogic\Modules\Articles\ArticlesRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use app\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HelpController extends Controller
{

    /**
     * @var ArticlesRepository
     */
    private $articles;

    /**
     * @param ArticlesRepository $repository
     */
    public function __construct(ArticlesRepository $repository)
    {

        $this->articles = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // display help articles
        $articles = $this->articles->paginate();

        return view('shared.articles.help.index', compact('articles'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function displayFAQ()
    {
        return view('shared.articles.help.faq');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Article $article
     * @return Response
     */
    public function show(Request $request, Article $article)
    {
        return $request->get('popup') == 1 ? view('shared.articles.help.popup', compact('article')) : view('shared.articles.help.view-article', compact('article'));

    }
}

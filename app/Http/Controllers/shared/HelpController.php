<?php namespace App\Http\Controllers\Shared;

use app\Antony\DomainLogic\Modules\Articles\Base\ArticlesEntity;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use app\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HelpController extends Controller
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
        // display help articles
        $articles = $this->articlesEntity->get();

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
        if($request->get('popup') == 1){

            // display help popup
            return view('shared.articles.help.popup', compact('article'));
        } else {

            return view('shared.articles.help.view-article', compact('article'));
        }

    }
}

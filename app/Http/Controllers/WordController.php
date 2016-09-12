<?php

namespace App\Http\Controllers;

use App\Repositories\WordRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\Criterias\WordListCriteria;

class WordController extends Controller
{

    protected $repository;
    
    protected $category;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(WordRepository $repository, CategoryRepository $category)
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(app(WordListCriteria::class));
        
        $this->category = $category;
    }

    /**
     * The welcome board
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $words = $this->repository->all();
        return view('word.index', [
            'pageTitle' => 'Word List',
            'words' => $words,
            'categories' =>  $this->category->getListCategories()
        ]);
    }

}

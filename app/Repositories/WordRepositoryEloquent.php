<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Entities\Word;

/**
 * Class HomeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class WordRepositoryEloquent extends BaseRepository implements WordRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Word::class;
    }

}

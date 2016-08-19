<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;
use App\Entities\Lesson;
/**
 * Interface HomeRepository
 * @package namespace App\Repositories;
 */
interface LessonRepository extends RepositoryInterface
{

    public function isFinished(Lesson $lesson);

    public function startLesson($categoryId);

    public function getQuestion(Lesson $lesson);

    public function getMaxQuestionsCount();

    public function saveAnswer(Lesson $lesson, $wordId, $wordAnswerId);
}

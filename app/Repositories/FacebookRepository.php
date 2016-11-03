<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;
/**
 * Interface HomeRepository
 * @package namespace App\Repositories;
 */
interface FacebookRepository extends RepositoryInterface
{

    public function getAuthorizationUri(array $scopes);

    public function connect();

    public function getClient();

    public function setClient($client);
}

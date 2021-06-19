<?php

namespace App\Service;

use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;

class Pagination
{
    private $repository;

    /**
     * Pagination constructor.
     * @param CommentRepository $repository
     */
    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $count
     * @param Request $request
     * @return array
     */
    public function pagination($count, $request){

        $params = array();

        $routeParameters = $request->attributes->get('_route_params');
        $page = (int)$routeParameters['page'];

        $perPage = 2;

        $first = ceil($page * $perPage) - $perPage;
        $pages = ceil($count / $perPage);

        $nbPages = array();

        for($p = 0; $p <= $pages; $p++){
            $nbPages['page'] = $p;
        }

        $params['first'] = $first;
        $params['pages'] = $pages;
        $params['perPage'] = $perPage;
        $params['page'] = $page;
        $params['nbPages'] = $nbPages;

        return $params;
    }
}
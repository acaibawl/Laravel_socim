<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FavoriteService;
use Carbon\Carbon;
use Illuminate\Http\Response;

class FavoriteAction extends Controller
{
    private $favorite;

    public function __construct(FavoriteService $service)
    {
        $this->favorite = $service;
    }

    public function __invoke(Request $request)
    {
        $this->favorite->switchFavorite(
            (int)$request->get('book_id'),
            (int)$request->get('user_id', 1),
            Carbon::now()->toDateTimeString()
        );

        return response('', Response::HTTP_OK);
    }
}

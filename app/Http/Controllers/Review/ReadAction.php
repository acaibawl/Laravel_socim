<?php
declare(strict_types=1);

namespace App\Http\Controllers\Review;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\DataProvider\Elasticsearch\ReadReviewDataProvider;

class ReadAction extends Controller
{
    private $provider;
    
    public function __construct(
        ReadReviewDataProvider $provider
    ) {
        $this->provider = $provider;
    }

    public function __invoke(Request $request)
    {
        $tags = explode(",", $request->get('tags'));
        $res = $this->provider->findAllByTag($tags);
        return response($res, Response::HTTP_OK);
    }
}

<?php
declare(strict_types=1);

namespace App\Http\Controllers\Review;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\DataProvider\RegisterReviewProviderInterface;

class RegisterAction extends Controller
{
    private $provider;
    
    public function __construct(
        RegisterReviewProviderInterface $provider
    ) {
        $this->provider = $provider;
    }

    public function __invoke(Request $request)
    {
        $this->provider->registerReview(
            $request->get('title'),
            $request->get('content'),
            $request->get('user_id', 1),
            Carbon::now()->toDateString(),
            $request->get('tags')
        );
        return response('', Response::HTTP_OK);
    }


}

<?php
namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function defaultResponse(
        bool $success = true,
        ?string $message = null,
        Collection $data = null,
        int $httpCode = 200
    ) {
        return response()->json(
            [
                'success' => $success,
                'message' => $message,
                'count'   => is_null($data) ? 0 : $data->count(),
                'data'    => $data,
            ],
            $httpCode
        );
    }
}

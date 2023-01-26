<?php

namespace App\Helpers\FlashMessage;

use App\Http\Resources\CategoryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class FlashMessageParameters
{
    /**
     * @var string $status success|danger
     */
    public $status;
    public $success;
    public $message;
    public $data;

    public static function error($data = [], $code = 500): FlashMessageParameters
    {
        $params = new self();
        $params->status = $code;
        $params->success = false;
        $params->message = __('An Error Occurred');
        if ($data) {
            $params->data = $data;
        }
        return $params;
    }

    public static function success($data = [], $code = 200): FlashMessageParameters
    {
        $params = new self();
        $params->status = $code;
        $params->success = true;
        $params->message = __('Transaction Successful');
        if ($data) {
            $params->data = $data;
        }
        return $params;
    }

    public static function paginate(LengthAwarePaginator $data, $resource = null, $code = 200): FlashMessageParameters
    {
        $params = new self();
        $params->status = $code;
        $params->success = true;
        $params->message = __('Transaction Successful');
        $params->data['meta'] = [
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
        ];
        $params->data['items'] = $resource && new $resource([]) instanceof JsonResource
            ? $resource::collection($data->items())
            : $data->items();
        return $params;
    }

    /**
     * @param  array|null  $headers
     * @return JsonResponse
     */
    public function toJson(?array $headers = []): JsonResponse
    {
        return response()->json($this, $this->status, $headers);
    }
}

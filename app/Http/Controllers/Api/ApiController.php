<?php
//@formatter:off
declare(strict_types = 1);
//@formatter:on


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Symfony\Component\HttpFoundation\Response;
//use Illuminate\Http\Response;

abstract class ApiController extends Controller
{
    /** @var  User */
    protected $user;

    /** @var array  */
    private $response = [];

    public function __construct()
    {
        $this->user = Auth::guard('api')->user();
    }

    private function response(array $data = [], int $status = Response::HTTP_OK, array $options = []) : Response
    {
        $this->setData($data);
        $this->setStatusCode($status);

        return response()->json($data, $status, $options);
    }

    protected function responseSuccess(array $data = []) : Response
    {
        return $this->response($data, Response::HTTP_OK);
    }

    protected function responseNotFound(string $message) : Response
    {
        $data = [
            'message' => $message
        ];

        return $this->response($data, Response::HTTP_NOT_FOUND);
    }

    protected function responseInternalError(array $data = []) : Response
    {
        return $this->response($data, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    private function setData(array $data)
    {
        $this->response['data'] = $data;
    }

    private function setStatusCode(int $status)
    {
        $this->response['status_code'] = $status;
    }
}
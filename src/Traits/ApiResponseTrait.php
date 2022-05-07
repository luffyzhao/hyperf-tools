<?php

namespace LHyperfTools\Traits;

use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Hyperf\Utils\Context;
use Hyperf\Utils\Contracts\Arrayable;
use Hyperf\Utils\Contracts\Jsonable;
use LHyperfTools\Constants\HttpCode;
use Psr\Http\Message\ResponseInterface;


trait ApiResponseTrait
{
    private int $httpCode = HttpCode::OK;
    private array $headers = [
        'Author' => 'Colorado'
    ];

    private int $errorCode = 100000;
    private string $errorMsg = '';

    protected $response;

    /**
     * 成功响应
     * @param mixed $data
     * @return ResponseInterface
     */
    public function success($data): ResponseInterface
    {
        return $this->setHttpCode(HttpCode::OK)->respond($data);
    }

    /**
     * 错误返回
     * @param string $err_msg     错误信息
     * @param int    $err_code    错误业务码
     * @param array  $data        额外返回的数据
     * @return ResponseInterface
     */
    public function fail(string $err_msg = '', int $err_code = 200000, array $data = []): ResponseInterface
    {
        return $this->setHttpCode($this->httpCode == HttpCode::OK ? HttpCode::BAD_REQUEST : $this->httpCode)
            ->respond([
                'err_code' => $err_code ?? $this->errorCode,
                'err_msg' => $err_msg ?? $this->errorMsg,
                'data' => $data
            ]);
    }

    /**
     * 设置http返回码
     * @param int $code    http返回码
     * @return $this
     */
    final public function setHttpCode(int $code = HttpCode::OK): self
    {
        $this->httpCode = $code;
        return $this;
    }

    /**
     * 设置返回头部header值
     * @param string $key
     * @param        $value
     * @return $this
     */
    public function addHttpHeader(string $key, $value): self
    {
        $this->headers += [$key => $value];
        return $this;
    }

    /**
     * 批量设置头部返回
     * @param array $headers    header数组：[key1 => value1, key2 => value2]
     * @return $this
     */
    public function addHttpHeaders(array $headers = []): self
    {
        $this->headers += $headers;
        return $this;
    }

    /**
     * @param null|array|Arrayable|Jsonable|string $response
     * @return ResponseInterface
     */
    private function respond($response = null): ResponseInterface
    {
        if (is_string($response)) {
            return $this->response()->withStatus($this->httpCode)->withAddedHeader('content-type', 'text/plain')->withBody(new SwooleStream($response));
        }

        if (is_array($response) || $response instanceof Arrayable || $response instanceof Jsonable) {
            return $this->response()->withStatus($this->httpCode)
                ->withAddedHeader('content-type', 'application/json')
                ->withBody(new SwooleStream(Json::encode($response)));
        }

        if(is_null($response)){
            return $this->response()->withStatus($this->httpCode)
                ->withAddedHeader('content-type', 'application/json')
                ->withBody(new SwooleStream(Json::encode([
                    'message' => '成功'
                ])));
        }

        return $this->response()->withStatus($this->httpCode)->withAddedHeader('content-type', 'text/plain')->withBody(new SwooleStream((string)$response));
    }

    /**
     * @return mixed|ResponseInterface|null
     */
    protected function response(): ResponseInterface
    {
        $response = Context::get(ResponseInterface::class);
        foreach ($this->headers as $key => $value) {
            $response = $response->withHeader($key, $value);
        }
        return $response;
    }
}
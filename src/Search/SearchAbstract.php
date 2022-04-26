<?php
declare(strict_types=1);

namespace LHyperfTools\Search;

use Couchbase\SearchException;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Contracts\Arrayable;
use Hyperf\Utils\Str;
use LHyperfTools\Contracts\SearchInterface;
use Hyperf\Di\Annotation\Inject;

abstract class SearchAbstract implements SearchInterface, Arrayable
{
    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * 条件.
     *
     * @var [type]
     */
    private $operators
        = [
            '=',
            '<',
            '>',
            '<=',
            '>=',
            '<>',
            '!=',
            '<=>',
            'like',
            'like binary',
            'not like',
            'ilike',
            '&',
            '|',
            '^',
            '<<',
            '>>',
            'rlike',
            'regexp',
            'not regexp',
            '~',
            '~*',
            '!~',
            '!~*',
            'similar to',
            'not similar to',
            'not ilike',
            '~~*',
            '!~~*',
            'in',
            'null',
            'no null',
            'date',
            'month',
            'day',
            'year',
            'raw',
            'between',
            'closure',
        ];

    /**
     * 要解析的条件.
     *
     * @var [type]
     */
    private $parses
        = [
            'in',
            'null',
            'no null',
            'date',
            'month',
            'day',
            'year',
            'raw',
            'between',
        ];


    /**
     * 关系映射.
     *
     * @return array
     */
    abstract protected function relationship(): array;


    /**
     * 执行
     *
     * @method handle
     *
     * @author luffyzhao@vip.126.com
     */
    private function handle(): array
    {
        $attributes = [];
        $relationship = $this->relationship();
        if (!empty($relationship)) {
            foreach ($relationship as $column => $operator) {
                if ($this->request->has($column)) {
                    $default = $this->request->getAttribute($column);
                    $value = $this->getAttribute($column, $default);

                    if (false === $value || is_null($value) || $value === '') {
                        continue;
                    }
                    $attributes[] = $this->validate(
                        $column,
                        $operator,
                        $value
                    );
                }
            }
        }

        return $attributes;
    }


    /**
     * 验证
     * @method validate
     *
     * @param string $column     字段
     * @param string$operator   条件
     * @param string $value      值
     *
     *
     * @return array
     * @throws SearchException
     * @author luffyzhao@vip.126.com
     */
    private function validate($column, $operator, $value): array
    {
        // 条件不在可选范围
        if (!in_array($operator, $this->operators)) {
            throw new SearchException('搜索条件超出可选范围！');
        }
        // 条件是要解析的
        if (in_array($operator, $this->parses)) {
            $value = $this->parse($column, $operator, $value);
        }

        if ($value instanceof \Closure) {
            return [$value];
        } else {
            return [$column, $operator, $value];
        }
    }

    /**
     * 解析条件.
     *
     * @method parse
     *
     * @param  [type] $column   字段
     * @param  [type] $operator 条件
     * @param  [type] $value  值
     *
     * @return \Closure
     *
     * @author luffyzhao@vip.126.com
     */
    private function parse($column, $operator, $value): \Closure
    {
        if ($value instanceof \Closure) {
            return $value;
        }

        return function ($query) use ($column, $operator, $value) {
            switch ($operator) {
                case 'in':
                    $query->whereIn($column, $value);
                    break;
                case 'null':
                    $query->whereNull($column);
                    break;
                case 'no null':
                    $query->whereNotNull($column);
                    break;
                case 'date':
                    $query->whereDate($column, $value);
                    break;
                case 'month':
                    $query->whereMonth($column, $value);
                    break;
                case 'day':
                    $query->whereDay($column, $value);
                    break;
                case 'year':
                    $query->whereYear($column, $value);
                    break;
                case 'column':
                    $query->whereColumn($column, $value);
                    break;
                case 'exists':
                    $query->whereExists($value);
                    break;
                case 'raw':
                    $query->whereRaw($value);
                    break;
                case 'between':
                    if(count($value) === 2 && !empty($value[0]) && !empty($value[1])){
                        $query->whereBetween($column, $value);
                    }
                    break;
            }
        };
    }

    /**
     * @param int $key
     * @param $default
     * @return false|mixed
     */
    protected function getAttribute(int $key, $default)
    {
        $method = 'get'.Str::camel($key).'Attribute';
        if (method_exists($this, $method)) {
            $default = call_user_func_array(
                [$this, $method],
                [$default, $this->request]
            );
        }

        return $default;
    }

    /**
     * 默认数据
     * @method defaultArray
     *
     * @return array
     * @author luffyzhao@vip.126.com
     */
    protected function defaultArray(): array
    {
        return [];
    }

    /**
     * 转数组.
     *
     * @method toArray
     *
     * @return array
     *
     * @author luffyzhao@vip.126.com
     */
    public function toArray(): array
    {
        return array_merge($this->handle(), $this->defaultArray());
    }
}
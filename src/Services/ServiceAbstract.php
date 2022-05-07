<?php

namespace LHyperfTools\Services;


use Exception;
use Hyperf\Contract\LengthAwarePaginatorInterface;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;
use JetBrains\PhpStorm\Pure;
use Throwable;

abstract class ServiceAbstract
{
    /**
     * 获取 Builder
     * @return Builder
     */
    abstract protected function getNewQuery(): Builder;

    /**
     * 通过主键查找一个模型
     * @param int|string $id
     * @param array $columns
     * @return Collection|Model|array|Builder|null
     */
    public function find(int|string $id, array $columns = ['*']): Collection|Model|array|Builder|null
    {
        return $this->getNewQuery()->findOrFail($id, $columns);
    }

    /**
     * 通过主键查找一个模型
     * @param int|string $id
     * @param array $columns
     * @return Collection|Model|array|Builder
     */
    public function lock(int|string $id, array $columns = ['*']): Collection|Model|array|Builder
    {
        return $this->getNewQuery()->lockForUpdate()->findOrFail($id, $columns);
    }

    /**
     * 获取全部模型
     * @param array $columns
     * @return Collection|array
     */
    public function get(array $columns = ['*']): Collection|array
    {
        return $this->getNewQuery()->get($columns);
    }


    /**
     * 查找与属性匹配的记录并分页
     * @param array $attributes
     * @param array $with
     * @param int|null $perPage
     * @param array $columns
     * @param string $pageName
     * @param int|null $page
     * @return LengthAwarePaginatorInterface
     */
    public function paginate(array $attributes, array $with = [], int $perPage = null, array $columns = ['*'], string $pageName = 'page', int $page = null): LengthAwarePaginatorInterface
    {
        return $this->getNewQuery()->with($with)->where(
            $attributes
        )->paginate($perPage, $columns, $pageName, $page);
    }


    /**
     * 创建模型
     * @param array $attributes
     * @return Builder|Model
     */
    public function create(array $attributes = []): Model|Builder
    {
        return $this->getNewQuery()->create($attributes);
    }

    /**
     * 更新
     * @param $id
     * @param array $values
     * @return bool
     * @throws Throwable
     */
    public function update($id, array $values): bool
    {
        return $this->find($id)->fill($values)->saveOrFail();
    }

    /**
     * 删除数据模型
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function delete($id): mixed
    {
        return $this->find($id)->delete();
    }

    /**
     * 获取第一条
     * @param array $attributes
     * @param array $columns
     * @return Builder|Model
     */
    public function first(array $attributes, array $columns = ['*']): Model|Builder
    {
        return $this->getNewQuery()->where($attributes)->firstOrFail($columns);
    }
}
<?php
declare(strict_types=1);

namespace App\Service;

use Hyperf\DbConnection\Model\Model;
use Hyperf\HttpServer\Contract\RequestInterface;

class CrudService
{
    /**
     * 通用分页列表 + 关键词搜索。
     */
    public static function list(string $modelClass, RequestInterface $req, array $searchable = []): array
    {
        $page = max(1, (int) $req->input('page', 1));
        $per = min(100, max(1, (int) $req->input('limit', 20)));
        $keyword = (string) $req->input('keyword', '');

        $query = $modelClass::query()->orderByDesc('id');
        if ($keyword !== '' && $searchable) {
            $query->where(function ($w) use ($keyword, $searchable) {
                foreach ($searchable as $field) {
                    $w->orWhere($field, 'like', '%' . $keyword . '%');
                }
            });
        }
        $total = (int) $query->count();
        $list = $query->forPage($page, $per)->get();
        return ['total' => $total, 'list' => $list];
    }

    public static function single(string $modelClass, int $id): ?Model
    {
        return $modelClass::find($id);
    }

    public static function save(string $modelClass, ?int $id, array $fields, RequestInterface $req): Model
    {
        $data = [];
        foreach ($fields as $field) {
            if ($req->has($field)) {
                $data[$field] = $req->input($field);
            }
        }
        $model = $id ? (($modelClass::find($id)) ?: new $modelClass()) : new $modelClass();
        $model->fill($data)->save();
        return $model;
    }

    public static function delete(string $modelClass, int $id): bool
    {
        $model = $modelClass::find($id);
        return $model ? (bool) $model->delete() : false;
    }

    public static function deletes(string $modelClass, RequestInterface $req): int
    {
        $ids = (array) $req->input('ids', []);
        $ids = array_filter(array_map('intval', $ids));
        return $ids ? $modelClass::whereIn('id', $ids)->delete() : 0;
    }
}

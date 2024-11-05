<?php

namespace App\Repositories\AttributeOption;

use App\Repositories\BaseRepository;
use App\Models\AttributeOption;
use App\Repositories\AttributeOption\AttributeOptionRepositoryInterface;

class AttributeOptionRepository extends BaseRepository implements AttributeOptionRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * getModel
     *
     * @return string
     */
    public function getModel()
    {
        return AttributeOption::class;
    }

    /**
     * Get List With Pagination
     *
     * @param  mixed $attribute_id
     * @param  mixed $request
     * @return mixed
     */
    public function getListWithPagination($attribute_id, $request)
    {
        $query = $this->model->where('category_attribute_id', $attribute_id);

        if ($request->filled('search_value')) {
            $query->where('value', 'like', "%{$request->input('search_value')}%");
        }

        if ($request->filled('sort_created_at')) {
            $query->orderBy('created_at', $request->input('sort_created_at'));
        }

        $limit = $request->filled('limit') ? $request->input('limit') : config('core.per_page');
        $results = $query->paginate($limit);

        return $results;
    }
}

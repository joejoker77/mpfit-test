<?php

namespace App\Http\Requests\Traits;

use Illuminate\Http\Request;
use App\Models\Shop\Category;
trait QueryParams
{
    public function queryParams(Request $request, $query)
    {
        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }
        if (!empty($value = $request->get('name'))) {
            $query->where('name', 'like', '%' . $value . '%');
        }
        if (!empty($value = $request->get('category'))) {
            $query->where('category_id', $value);
        }

        if (!empty($value = $request->get('price'))) {
            $query->where('cost', '<=', $value);
        }
        if(!empty($value = $request->get('sort'))) {
            if ($value[0] == '-') {
                $value = str_replace('-', '', $value);
                $query->orderBy($value, 'DESC');
            } else {
                $query->orderBy($value);
            }
        } else {
            $query->orderBy('id');
        }
        return $query;
    }
}

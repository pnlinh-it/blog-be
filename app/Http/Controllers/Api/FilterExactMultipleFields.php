<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterExactMultipleFields implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        $fields = explode(',', $property);

        foreach ($fields as $field) {
            if (is_array($value)) {
                $query->orWhereIn($field, $value);

                continue;
            }

            $query->orWhere($field, '=', $value);
        }

        return $query;
    }
}

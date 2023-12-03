<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterLikeMultipleFields implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        $fields = explode(',', $property);

        foreach ($fields as $field) {
            if (is_array($value)) {
                $this->addQueryForArray($query, $field, $value);

                continue;
            }

            $query->orWhere($field, 'like', "%$value%");
        }

        return $query;
    }

    private function addQueryForArray(Builder $query, $field, array $values): void
    {
        foreach ($values as $value) {
            $query->orWhere($field, 'like', "%$value%");
        }
    }
}

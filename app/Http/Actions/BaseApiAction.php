<?php

namespace App\Http\Actions;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseApiAction
{
    abstract public function rules(array $data): array;

    public function validate(array $data)
    {
        return Validator::make($data, $this->rules($data))->validate();
    }

    public function nullOrValue($data, $index)
    {
        $value = Arr::get($data, $index, null);

        return is_null($value) || $value === '' ? null : $value;
    }

    public function nullOrDate($data, $index)
    {
        $value = Arr::get($data, $index, null);

        return is_null($value) || $value === '' ? null : Carbon::parse($value);
    }

    public function valueOrFalse($data, $index)
    {
        if (empty($data[$index])) {
            return false;
        }

        return $data[$index];
    }

    protected function getUpdatableField(array $data): array
    {
        return array_keys($this->rules($data));
    }

    protected function abortWithValidationMessage(string $message)
    {
        abort(Response::HTTP_UNPROCESSABLE_ENTITY, $message);
    }

    protected function user(): User
    {
        return Auth::user();
    }
}

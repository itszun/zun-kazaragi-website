<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Log;

class JSON implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value || $value != "" || $value != "{}" || $value != "[]") {
            $encoding = mb_detect_encoding($value);

            if($encoding == 'UTF-8') {
                $value = preg_replace('/[^(\x20-\x7F)]*/','', $value);
            }

            $result = json_decode($value, true);
            return $result;
        }
        return json_decode($value) ?? json_decode("{}");
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        Log::channel('daily')->info($value);
        Log::channel('daily')->info("JSON ENCODED: ".json_encode($value));
        return json_encode($value) ?? $value;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}

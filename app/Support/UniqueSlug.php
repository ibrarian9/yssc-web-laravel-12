<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UniqueSlug
{
    /**
     * Generate a unique slug for the given Eloquent model class.
     *
     * @param  class-string<Model>  $modelClass
     */
    public static function generate(string $modelClass, string $source, ?int $ignoreId = null, bool $withTrashed = false): string
    {
        $base = Str::slug($source) ?: 'item';
        $slug = $base;
        $suffix = 2;

        while (static::exists($modelClass, $slug, $ignoreId, $withTrashed)) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }

    /**
     * @param  class-string<Model>  $modelClass
     */
    private static function exists(string $modelClass, string $slug, ?int $ignoreId, bool $withTrashed): bool
    {
        $query = $modelClass::query();

        if ($withTrashed && in_array(SoftDeletes::class, class_uses_recursive($modelClass), true)) {
            $query->withTrashed();
        }

        $query->where('slug', $slug);

        if ($ignoreId !== null) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'category_name',
        'slug',
        'description',
        'image',
        'status',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function isSubcategory(): bool
    {
        return $this->parent_id !== null;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'Active');
    }

    public function scopeTopLevel(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Active top-level categories with their active children, each annotated
     * with a published-question count, for use in frontend sidebars/menus.
     */
    public static function sidebarTree()
    {
        $withPublishedCount = fn ($q) => $q->where('status', 'Published');

        return static::active()->topLevel()
            ->withCount(['questions' => $withPublishedCount])
            ->with(['children' => fn (HasMany $q) => $q->active()
                ->withCount(['questions' => $withPublishedCount])
                ->orderBy('category_name'),
            ])
            ->orderBy('category_name')
            ->get();
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $term
            ? $query->where('category_name', 'like', "%{$term}%")
            : $query;
    }

    /**
     * Generate a unique slug from the category name, appending a numeric
     * suffix only when the base slug is already taken.
     */
    public static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (
            static::withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, fn (Builder $q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}

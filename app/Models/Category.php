<?php

namespace App\Models;

use App\Filters\Filterable;
use App\Traits\ScopeChecks;
use App\Traits\SearchableTraitWithTurkish;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filterable;
    use ScopeChecks;
    use SearchableTraitWithTurkish;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
    ];

    protected $searchable = [
        'columns' => [
            'name' => 9,
        ],
    ];
}

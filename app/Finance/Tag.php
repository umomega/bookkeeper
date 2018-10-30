<?php

namespace Bookkeeper\Finance;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Nicolaslopezj\Searchable\SearchableTrait;
use Kyslik\ColumnSortable\Sortable;

class Tag extends Eloquent {

    use SearchableTrait, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Searchable columns.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'name' => 10
        ]
    ];

    /**
     * Sortable columns
     *
     * @var array
     */
    protected $sortableColumns = ['name', 'created_at'];

    /**
     * Transactions relation
     *
     * @return BelongsToMany
     */
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class);
    }

}

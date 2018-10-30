<?php

namespace Bookkeeper\Finance;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Nicolaslopezj\Searchable\SearchableTrait;
use Kyslik\ColumnSortable\Sortable;

class Account extends Eloquent {

    use SearchableTrait, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'currency', 'balance', 'notes', 'default'
    ];

    /**
     * Searchable columns.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'name' => 10,
            'currency' => 10
        ]
    ];

    /**
     * Sortable columns
     *
     * @var array
     */
    protected $sortableColumns = ['name', 'currency', 'created_at'];

    /**
     * Transaction relation
     *
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}

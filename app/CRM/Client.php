<?php


namespace Bookkeeper\CRM;


use Illuminate\Database\Eloquent\Model as Eloquent;
use Nicolaslopezj\Searchable\SearchableTrait;
use Kyslik\ColumnSortable\Sortable;
use Bookkeeper\Finance\Job;

class Client extends Eloquent {

    use SearchableTrait, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'tax_administration', 'tax_number',
        'email', 'tel', 'fax', 'address', 'notes'
    ];

    /**
     * Searchable columns.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'name' => 10,
            'email' => 10
        ]
    ];

    /**
     * The attributes that may be sorted by.
     *
     * @var array
     */
    public $sortable = ['name', 'email', 'created_at'];

    /**
     * Jobs relation
     *
     * @return HasMany
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * People relation
     *
     * @return Relation
     */
    public function people()
    {
        return $this->belongsToMany(Person::class);
    }

}

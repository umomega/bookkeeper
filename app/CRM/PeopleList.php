<?php


namespace Bookkeeper\CRM;


use Illuminate\Database\Eloquent\Model as Eloquent;
use Nicolaslopezj\Searchable\SearchableTrait;
use Kyslik\ColumnSortable\Sortable;

class PeopleList extends Eloquent {

    use SearchableTrait, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'notes'
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
     * The attributes that may be sorted by.
     *
     * @var array
     */
    public $sortable = ['name', 'created_at'];

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

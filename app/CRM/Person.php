<?php


namespace Bookkeeper\CRM;


use Illuminate\Database\Eloquent\Model as Eloquent;
use Nicolaslopezj\Searchable\SearchableTrait;
use Kyslik\ColumnSortable\Sortable;

class Person extends Eloquent {

    use SearchableTrait, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'company', 'job_title',
        'email', 'tel', 'tel_mobile', 'fax',
        'nationality', 'national_id',
        'address', 'city', 'state', 'country', 'postal_code',
        'notes'
    ];

    /**
     * Searchable columns.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'first_name' => 10,
            'last_name'  => 10,
            'email'      => 10,
            'company'    => 10
        ]
    ];

    /**
     * The attributes that may be sorted by.
     *
     * @var array
     */
    public $sortable = ['first_name', 'email', 'created_at'];

    /**
     * Getter for full name
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Lists relation
     *
     * @return BelongsToMany
     */
    public function lists()
    {
        return $this->belongsToMany(PeopleList::class);
    }

    /**
     * Assign a list to the person by id
     *
     * @param int $id
     * @return PeopleList
     */
    public function assignListById($id)
    {
        return $this->lists()->attach(
            PeopleList::findOrFail($id)
        );
    }

    /**
     * Retract a list from the person by id
     *
     * @param int $id
     * @return PeopleList
     */
    public function retractListById($id)
    {
        return $this->lists()->detach(
            PeopleList::findOrFail($id)
        );
    }

    /**
     * Clients relation
     *
     * @return BelongsToMany
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    /**
     * Assign a client to the person by id
     *
     * @param int $id
     * @return Client
     */
    public function assignClientById($id)
    {
        return $this->clients()->attach(
            Client::findOrFail($id)
        );
    }

    /**
     * Retract a client from the person by id
     *
     * @param int $id
     * @return Client
     */
    public function retractClientById($id)
    {
        return $this->clients()->detach(
            Client::findOrFail($id)
        );
    }

}

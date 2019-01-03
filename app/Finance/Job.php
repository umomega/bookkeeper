<?php


namespace Bookkeeper\Finance;


use Illuminate\Database\Eloquent\Model as Eloquent;
use Nicolaslopezj\Searchable\SearchableTrait;
use Kyslik\ColumnSortable\Sortable;

class Job extends Eloquent {

    use SearchableTrait, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'notes', 'client_id', 'offer'
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
     * Client relation
     *
     * @return BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(config('models.client', \Bookkeeper\CRM\Client::class));
    }

    /**
     * Transaction relation
     *
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Returns the download link for the offer
     *
     * @return string
     */
    public function getOfferDownloadLinkAttribute()
    {
        return route('bookkeeper.jobs.offer.download', $this->getKey());
    }

    /**
     * Returns the download link for the offer
     *
     * @return string
     */
    public function getOfferDeleteLinkAttribute()
    {
        return route('bookkeeper.jobs.offer.delete', $this->getKey());
    }

}

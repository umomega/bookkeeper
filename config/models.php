<?php

/**
 * Class paths for models are configured here
 * to enable further extensibility
 */

return [

    // CRM
    'client' => \Bookkeeper\CRM\Client::class,
    'people_list' => \Bookkeeper\CRM\PeopleList::class,
    'person' => \Bookkeeper\CRM\Person::class,

    // Finance
    'account' => \Bookkeeper\Finance\Account::class,
    'job' => \Bookkeeper\Finance\Job::class,
    'tag' => \Bookkeeper\Finance\Tag::class,
    'transaction' => \Bookkeeper\Finance\Transaction::class,

];

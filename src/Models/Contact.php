<?php

namespace TypiCMS\Modules\Contacts\Models;

use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Shells\Models\Base;
use TypiCMS\Modules\History\Shells\Traits\Historable;

class Contact extends Base
{
    use Historable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Contacts\Shells\Presenters\ModulePresenter';

    protected $fillable = [
        'title',
        'first_name',
        'last_name',
        'email',
        'language',
        'website',
        'company',
        'address',
        'postcode',
        'city',
        'country',
        'phone',
        'mobile',
        'fax',
        'message',
    ];
}

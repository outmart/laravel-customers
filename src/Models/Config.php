<?php

namespace OutMart\Models;

use OutMart\Base\ModelBase;

class Config extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'core_configs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'path',
        'value',
    ];
}
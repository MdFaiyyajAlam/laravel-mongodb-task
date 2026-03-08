<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Task extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'tasks_collection';

    protected $fillable = [
        'title',
        'description',
        'status',
        'owner_id',
        'owner_guard',
    ];

    public $timestamps = true;
}

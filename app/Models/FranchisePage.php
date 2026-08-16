<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FranchisePage extends Model
{
    protected $fillable = [

        'title',

        'training_description',

        'advantages_title',

        'advantages_description',

        'advantages_image',

        'why_join_title',

        'why_join_description',
    ];
}
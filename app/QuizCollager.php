<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizCollager extends Model
{

    protected $table = 'quiz_collagers';
    public $timestamps = true;
    protected $guarded = ['created_at', 'updated_at'];

    public function quiz()
    {
        return $this->belongsTo('App\Quiz', 'quiz_id', 'id');
    }

    public function quiz_types()
    {
        return $this->belongsTo('App\QuizType', 'quiz_category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'collager_id', 'id');
    }

    public function collager()
    {
        return $this->belongsTo('App\Collager', 'collager_id', 'id');
    }

}

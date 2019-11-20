<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\QuizCategory;
use App\QuizCollager;

class PostExport2 implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return QuizCategory::select('id', 'name')->get()->sortBy('id');
        $data = QuizCollager::where('collager_id', 1)->get();
        //return $data;
        return $data;
    }
}

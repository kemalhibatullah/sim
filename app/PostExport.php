<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\QuizCollager;
use App\User;
use DataTables;
use DB;

class PostExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return QuizCategory::select('id', 'name')->get()->sortBy('id');
        $data =  DB::table('quiz_collagers')
                    ->join('collagers', 'collagers.id', '=', 'quiz_collagers.collager_id')
                    ->join('users', 'users.id', '=', 'quiz_collagers.collager_id')
                    ->join('quizs', 'quizs.id', '=', 'quiz_collagers.quiz_id')
                    ->join('quiz_types', 'quiz_types.id', '=', 'quizs.quiz_type_id')
                    ->join('quiz_categorys', 'quiz_categorys.id', '=', 'quiz_types.quiz_category_id')
                    ->select('users.name', 'quizs.title', 'quiz_collagers.total_score')
                    // ->where('users.id', 1)
                    ->get();
        return $data;
            // ->addColumn('name', function ($row) {
            //     return $row->user->name;
            // })
            // ->addColumn('category', function ($row) {
            //     return $row->quiz->quizType->quizCategory->name;
            // })
            // ->addColumn('type', function ($row) {
            //     return $row->quiz->quizType->name;
            // })
            // ->addColumn('title', function ($row) {
            //     return $row->quiz->title;
            // })
            // ->addColumn('date', function ($row) {
            //     return $row->created_at->format('j F Y');;
            // })
            // ->addColumn('score', function ($row) {
            //     return $row->total_score;
            // })
            // ->make(true);
    }
}

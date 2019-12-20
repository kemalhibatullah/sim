<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\QuizCollager;
use App\QuizCategory;
use App\Quiz;
use App\QuizType;
use DataTables;
use DB;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::role('user')->get()->sortBy('name');
        // dd($data);
        $data2 = Quiz::select('id', 'quiz_type_id', 'title')->get()->sortBy('quiz_type_id');
        // dd($data);
        
        return view('history.index',compact('data', 'data2'));
    }

    public function getData()
    {
        $data = User::role('user')->get()->sortBy('name');
        return datatables()->of($data)
        ->addColumn('action', function ($row) 
        {
            $btn = '<a id="btn-detail" href="' . route('history.show', $row->id) . '" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-eye"></i></a>';
            return $btn;
        })
        ->addColumn('check', function ($row) 
        {
            $check = '<input type="checkbox" name="' . ($row->id) . '" class="kemi">';
            return $check;
        })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getDataHistoryUser($id)
    {
        $data = QuizCollager::where('collager_id', $id)->get();
        //return $data;
        return datatables()->of($data)->addColumn('action', function ($row) {
            $btn = '<a id="btn-detail" href="#" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-eye"></i></a>';
            return $btn;
        })
            ->rawColumns(['action'])
            ->addColumn('name', function ($row) {
                return $row->user->name;
            })
            ->addColumn('category', function ($row) {
                return $row->quiz->quizType->quizCategory->name;
            })
            ->addColumn('type', function ($row) {
                return $row->quiz->quizType->name;
            })
            ->addColumn('title', function ($row) {
                return $row->quiz->title;
            })
            ->addColumn('date', function ($row) {
                return $row->created_at->format('j F Y');;
            })
            ->addColumn('score', function ($row) {
                return $row->total_score;
            })
            ->make(true);
    }

    public function getDataHistoryUsers()
    {
        $data = QuizCollager::where('collager_id', 1)->get();
        //return $data;
        return datatables()->of($data)
            ->addColumn('name', function ($row) {
                return $row->user['name'];
            })
            ->addColumn('category', function ($row) {
                return $row->quiz->quizType->quizCategory->name;
            })
            ->addColumn('type', function ($row) {
                return $row->quiz->quizType->name;
            })
            ->addColumn('title', function ($row) {
                return $row->quiz->title;
            })
            ->addColumn('date', function ($row) {
                return $row->created_at->format('j F Y');;
            })
            ->addColumn('score', function ($row) {
                return $row->total_score;
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datak = Quiz::select('id', 'quiz_type_id', 'title')->get()->sortBy('quiz_type_id');
        $dataj = QuizCategory::select('id', 'name')->get()->sortBy('id');
        $datah = QuizType::select('id', 'quiz_category_id', 'name')->get()->sortBy('quiz_category_id');


        $datas = QuizCategory::select('id', 'name')->get()->sortBy('id');

        
        // $datal =  DB::table('quiz_collagers')
        //             ->join('collagers', 'collagers.id', '=', 'quiz_collagers.collager_id')
        //             ->join('users', 'users.id', '=', 'quiz_collagers.collager_id')
        //             ->join('quizs', 'quizs.id', '=', 'quiz_collagers.quiz_id')
        //             ->join('quiz_types', 'quiz_types.id', '=', 'quizs.quiz_type_id')
        //             ->join('quiz_categorys', 'quiz_categorys.id', '=', 'quiz_types.quiz_category_id')
        //             ->select('users.name', 'quizs.title', 'quiz_collagers.total_score')
        //             ->where('users.id', $id)
        //             ->get();
                    // dd($datal);

        $data = User::find($id);
        return view('history.history-user', compact('data', 'datas', 'datak', 'dataj', 'datah'));
        // return $respons;
        // return $data;
        // return $datas;
    }

    public function getDataChartUser($id)
    {

        $chart = QuizCollager::with('quiz')->where('collager_id', $id)->get();
        $chart = $chart->groupBy('quiz.title');
        $result = [];

        foreach ($chart as $key => $value) {
            $result[$key][] = $key;
            foreach ($value as $key1 => $value1) {
                $result[$key][] = $value1->total_score;
            }
        }
        $result = array_values($result);

        foreach ($result as $key => $value) {
            foreach ($value as $key1 => $value1) {
                if ($key1 == 0) {
                    $number[] = "x";
                } else {
                    $number[] = "" . $key1 . "";
                }
            }
        }
        $number = array_combine($number, $number);
        $number = array_values($number);
        //array_unshift($result , $number);

        //dd(json_encode($result));
        return response()->json($result);
    }

    public function getDataChartUserId($id, $id2)
    {


        $chart = QuizCollager::with('quiz')->where([
            ['collager_id', $id],
            ['quiz_id', $id2]
        ])->get();
        $chart = $chart->groupBy('quiz.title');
        $result = [];

        foreach ($chart as $key => $value) {
            $result[$key][] = $key;
            foreach ($value as $key1 => $value1) {
                $result[$key][] = $value1->total_score;
            }
        }
        $result = array_values($result);

        foreach ($result as $key => $value) {
            foreach ($value as $key1 => $value1) {
                if ($key1 == 0) {
                    $number[] = "x";
                } else {
                    $number[] = "" . $key1 . "";
                }
            }
        }
        $number = array_combine($number, $number);
        $number = array_values($number);
        //array_unshift($result , $number);

        //dd(json_encode($result));
        return response()->json($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

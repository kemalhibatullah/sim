<?php

namespace App\Http\Controllers;

use App\Col;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\PostExport;
use App\Quiz;
use App\QuizCategory;

class PostsController extends Controller
{
    // public function index()
	// {
	// 	$col = QuizCategory::select('id', 'name')->get()->sortBy('id');
	// 	return view('history.history-user');
	// }
	

	public function export_excel()
	{
		return Excel::download(new PostExport, 'col.xlsx');
	}
   
}

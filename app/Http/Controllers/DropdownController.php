<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\QuizCollager;
use DataTables;

class DropdownController extends Controller
{
    public function getIndex() 
  	{
  		# Ambil semua isi tabel tujuan dari model
  		$quiz_categorys = QuizCategory::all();
  		# Inisialisasi variabel daftar dengan array
  		$daftar = array('' => '');
  		# lakukan perulangan untuk provinsi
  		foreach($quiz_categorys as $temp)
  			# Isi daftar dengan nama (provinsi) berdasarkan id
  			$daftar[$temp->id] = $temp->name;
  		# Tampilkan halaman index beserta variabel daftar
  		return View::make('index', compact('daftar'));
  	}

  	public function postDropdown() 
  	{	
  		# Tarik ID inputan
  		$set = Input::get('id');

  		# Inisialisasi variabel berdasarkan masing-masing tabel dari model
  		# dimana ID target sama dengan ID inputan
  		$quiz_types = QuizType::where('quiz_category_id', $set)->get();
  		$quizs = Kecamatan::where('quiz_type_id', $set)->get();

  		# Buat pilihan "Switch Case" berdasarkan variabel "type" dari form
  		switch(Input::get('type')):
  			# untuk kasus "kabupaten"
  			case 'quiz_types':
  				# buat nilai default
  				$return = '<option value="">Pilih Type...</option>';
  				# lakukan perulangan untuk tabel kabupaten lalu kirim
  				foreach($quiz_types as $temp) 
  					# isi nilai return
  					$return .= "<option value='$temp->id'>$temp->name</option>";
  				# kirim
  				return $return;
  			break;
  			# untuk kasus "kecamatan"
  			case 'quizs':
  				$return = '<option value="">Pilih Quiz...</option>';
  				foreach($quizs as $temp) 
  					$return .= "<option value='$temp->id'>$temp->name</option>";
  				return $return;
  			break;
  		# pilihan berakhir
  		endswitch;    
  	}

}
<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$data['user'] = "Langlang Purwasasmita";
		$data['title'] = "Home | " . $data['user'];

		echo view('templates/header', $data);
		echo view('home/index', $data);
		echo view('templates/header');
	}

	//--------------------------------------------------------------------

}
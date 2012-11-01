<?php 

class Experimentsubjects_Controller extends Base_Controller
{
	public $restful = true;

	public function get_index()
	{
		$experimentsubjects = Experimentsubject::all();
		$experimentsubjectsArray = array();

		foreach ($experimentsubjects as $experimentsubject)
		{
			$experimentsubjectsArray[] = $experimentsubject->to_array();
		}

		return Response::json($experimentsubjectsArray);
	}
}
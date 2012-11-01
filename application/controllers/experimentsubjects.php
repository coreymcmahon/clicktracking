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

	public function get_experimentsubject($id)
	{
		$experimentsubject = Experimentsubject::find((int)$id);

		if($experimentsubject)
		{
			return Response::json($experimentsubject->to_array());
		} else {
			return Response::error('404');
		}
	}

	public function post_index()
	{
		$input = Input::json();
		
		$experimentsubject = new Experimentsubject(array(
			'selector' => $input->selector,
			'experiment_id' => $input->experiment_id,
		));
		$experimentsubject->save();

		return $this->get_experimentsubject($experimentsubject->id);
	}
}
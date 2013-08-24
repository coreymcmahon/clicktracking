<?php 

class Experiments_Controller extends Base_Controller
{
	public $restful = true;

	public function get_index()
	{
		$experiments = Experiment::all();
		$experimentsArray = array();

		foreach ($experiments as $experiment)
		{
			$experimentsArray[] = $experiment->to_array();
		}

		return Response::json($experimentsArray);
	}

	public function get_experiment($id)
	{
		$experiment = Experiment::find((int)$id);

		if ($experiment) 
		{
			return Response::json($experiment->to_array());
		} else {
			return Response::error('404');
		}
	}

	public function post_index()
	{
		$input = Input::json();
		
		$experiment = new Experiment(array(
			'name' => $input->name,
			'url' => $input->url,
		));
		$experiment->save();

		return $this->get_experiment($experiment->id);
	}
}
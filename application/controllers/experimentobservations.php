<?php 

class Experimentobservations_Controller extends Base_Controller
{
	public $restful = true;

	public function get_index()
	{
		$experimentobservations = Experimentobservation::all();
		$experimentobservationsArray = array();

		foreach ($experimentobservations as $experimentobservation)
		{
			$experimentobservationsArray[] = $experimentobservation->to_array();
		}

		return Response::json($experimentobservationsArray);
	}

	public function get_experimentobservation($id)
	{
		$experimentobservation = Experimentobservation::find((int)$id);

		if ($experimentobservation) 
		{
			return Response::json($experimentobservation->to_array());
		} else {
			return Response::error(404);
		}
	}

	public function post_index()
	{
		$input = Input::json();
		
		$experimentobservation = new Experimentobservation(array(
			'experiment_id' => $input->experiment_id,
			'experiment_subject_id' => $input->experiment_subject_id,
			'clicks' => $input->clicks,
			'store_id' => $input->store_id,
			'username' => $input->username,
			'session' => $input->session,
			'session_start' => $input->session_start,
			'session_updated_at' => $input->session_updated_at
		));
		$experimentobservation->save();

		return $this->get_experimentobservation($experimentobservation->id);
	}
}
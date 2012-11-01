<?php 

class Experiment extends Eloquent
{
	public function experimentsubjects()
	{
		return $this->has_many('Experimentsubject');
	}

	public static function allAsArray()
	{
		$experiments = self::all();
		$result = array();

		foreach ($experiments as $experiment)
		{
			$result[] = $experiment->to_array();
		}

		return $result;
	}
}
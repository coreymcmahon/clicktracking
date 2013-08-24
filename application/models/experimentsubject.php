<?php 

class Experimentsubject extends Eloquent
{
	public static function allAsArray()
	{
		$experimentsubjects = self::all();
		$result = array();

		foreach ($experimentsubjects as $experimentsubject)
		{
			$result[] = $experimentsubject->to_array();
		}

		return $result;
	}
}
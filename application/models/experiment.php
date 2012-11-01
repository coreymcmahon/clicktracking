<?php 

class Experiment extends Eloquent
{
	public function experimentsubjects()
	{
		return $this->has_many('Experimentsubject');
	}
}
<?php 

class Clicktracking_Task {

	public function run($arguments)
	{
		// @TODO: display helpdocs in here
	}

	public function purge($arguments)
	{
		if (count($arguments) === 0) {
			$arguments = array('experiments', 'experimentobservations', 'experimentsubjects');
		}

    	foreach ($arguments as $arg)
    	{
			if ($arg === 'experiments') 
			{
				foreach (Experiment::all() as $experiment) 
				{
					$experiment->delete();
				}
				print('Purged ' . $arg . ' table.');
			}
			elseif ($arg === 'experimentobservations') 
			{
    			foreach (Experimentobservation::all() as $experimentobservation) 
    			{
    				$experimentobservation->delete();
    			}
    			print('Purged ' . $arg . ' table.');
    		}
    		elseif ($arg === 'experimentsubjects') 
    		{
    			foreach (Experimentsubject::all() as $experimentsubject) 
    			{
    				$experimentsubject->delete();
    			}
    			print('Purged ' . $arg . ' table.');
    		}
    		else {
    			print('Sorry, I don\'t know how to purge the data source ' . $arg . '.');
    		}
    	}
    }

}
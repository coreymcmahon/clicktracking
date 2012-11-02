<?php 

class Experimentobservation extends Eloquent
{

	public static function get_store_ids()
	{
		return DB::query('SELECT DISTINCT(store_id) AS store_id FROM experimentobservations;');
	}

	/**
	 * Usage per session
	 *	The number of user sessions involving 
	 */
	public static function usage_per_session($experimentId, $storeId = null)
	{
		$sql = '
			SELECT 
			 COUNT(experiment_subject_id) AS num_sessions,
			 experiment_subject_id, 
			 experiment_id
			FROM
			 experimentobservations
			WHERE
			 experiment_id = ? 
			 ' . self::get_store_and_where_clause($storeId) . ' 
			GROUP BY experiment_subject_id
		';
		$allQuery = DB::query($sql, array((int)$experimentId));

		$sql = '
			SELECT 
			 COUNT(experiment_subject_id) AS num_sessions,
			 experiment_subject_id, 
			 experiment_id
			FROM
			 experimentobservations
			WHERE
			 experiment_id = ? 
			 AND clicks > 0 
			 ' . self::get_store_and_where_clause($storeId) . ' 
			GROUP BY experiment_subject_id
		';
		$hasClicksQuery = DB::query($sql, array((int)$experimentId));

		$result = array();
		foreach ($allQuery as $row)
		{
			$result[$row->experiment_subject_id] = array(
				'num_sessions' => $row->num_sessions,
				'experiment_subject_id' => $row->experiment_subject_id,
				'experiment_id' => $row->experiment_id,
			);
		}

		foreach ($hasClicksQuery as $row)
		{
			$result[$row->experiment_subject_id]['num_used_sessions'] = $row->num_sessions;
		}

		return $result;
	}

	/**
	 * Element ranking
	 * 	Rank all the elements in this experiment, based on the number of clicks.
	 */
	public static function element_ranking($experimentId, $storeId = null)
	{
		$sql = '
			SELECT 
				SUM(clicks) AS sum_clicks, experiment_subject_id, experiment_id 
			FROM 
				experimentobservations 
			WHERE 
				experiment_id = ? 
			 ' . self::get_store_and_where_clause($storeId) . ' 
			
			GROUP BY experiment_subject_id 
			ORDER BY sum_clicks DESC
		';

		// for each experiment, take the summation of the number of 'clicks' for each experiment subject
		return DB::query($sql, array((int)$experimentId));
	}

	/**
	 * Time to first click
	 *	
	 */
	public static function time_to_first_click($experimentId, $storeId = null)
	{
		return array('not yet implemented :(');
		// @TODO: implement
	}

	/**
	 * Number of average clicks
	 *	The average number of clicks 
	 */
	public static function number_of_average_clicks($experimentId, $storeId = null)
	{
		$sql = '
			SELECT 
				AVG(clicks) AS avg_clicks, experiment_subject_id, experiment_id
			FROM 
				experimentobservations 
			WHERE 
				experiment_id = ? 
			 ' . self::get_store_and_where_clause($storeId) . ' 

			GROUP BY experiment_subject_id 
		';

		return DB::query($sql, array((int)$experimentId));
	}

	/**
	 * Element grouping
	 *	
	 */
	// public function elementGrouping($experimentId, $storeId = null)
	// {}

	/**
	 * Time between repeat usage
	 * 
	 */
	// public function timeBetweenRepeatUsages($experimentId, $storeId = null)
	// {}

	/**
	 * Usage trend
	 *	
	 */
	// public function usageTrend($experimentId, $storeId = null)
	// {}


	private static function get_store_and_where_clause($storeId = null)
	{
		return (($storeId !== null) ? ' AND store_id = ' . (int) $storeId . ' ' : '' );
	}

	private static function get_store_where_clause($storeId = null)
	{
		return (($storeId !== null) ? ' store_id = ' . (int) $storeId . ' ' : '' );
	}
}
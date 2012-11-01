<?php 

class Experimentobservation extends Eloquent
{
	/**
	 * Usage per session
	 *	The number of user sessions involving 
	 */
	public function usage_per_session($experimentId, $storeId = null)
	{
		// @TODO: implement
	}

	/**
	 * Element ranking
	 * 	Rank all the elements in this experiment, based on the number of clicks.
	 */
	public function element_ranking($experimentId, $storeId = null)
	{
		$sql = '
			SELECT 
				SUM(clicks) AS sum_clicks, experiment_subject_id, experiment_id 
			FROM 
				experimentobservations 
			WHERE 
				experiment_id = ? '
			. self::get_store_and_where_clause($storeId) . ' 
			
			GROUP BY experiment_subject_id 
			ORDER BY sum_clicks ASC
		';

		// for each experiment, take the summation of the number of 'clicks' for each experiment subject
		return DB::query($sql, array((int)$experimentId));
	}

	/**
	 * Time to first click
	 *	
	 */
	public function time_to_first_click($experimentId, $storeId = null)
	{
		// @TODO: implement
	}

	/**
	 * Number of average clicks
	 *	The average number of clicks 
	 */
	public function number_of_average_clicks($experimentId, $storeId = null)
	{
		// @TODO: implement
		$sql = '
			SELECT 
				AVG(clicks) AS avg_clicks, experiment_subject_id, experiment_id
			FROM 
				experimentobservations 
			WHERE 
				experiment_id = ? '
			. self::get_store_and_where_clause($storeId) . '
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
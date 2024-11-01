<?php

namespace Snack\MissedSchedule\Controllers;

/**
 * 
 */
class wpController
{

	/**
	 * [$model description]
	 * @var [type]
	 */
	protected $model;

	/**
	 * [__construct description]
	 * @param \Snack\MissedSchedule\Models\wpModel $model [description]
	 */
	public function __construct( \Snack\MissedSchedule\Models\wpModel $model )
	{
		$this->model 	= $model;
	}

	/**
	 * [scheduleCronEvent description]
	 * @return [type] [description]
	 */
	public function scheduleCronEvent()
	{
		if ( ! wp_next_scheduled( $this->model::RECCURING_EVENT_NAME ) ) 
		{
    		wp_schedule_event( time(), 'sms_five_minutes', $this->model::RECCURING_EVENT_NAME );
		}
	}

	/**
     * [checkMissedSchedules description]
     * @return [type] [description]
     */
    public function checkMissedSchedules()
    {
        $missedIds = $this->model->getMissedSchedules();

        if ( ! $missedIds )
            return;

        foreach( $missedIds as $missedPostId )
        {
            wp_publish_post( $missedPostId );
            $this->model->notifyAdmin( $missedPostId );
        }
    }

	/**
	 * Action executed on plugin deactivation
	 * @return [type] [description]
	 */
	public function deactivate()
	{
		do_action( 'snack_missed_plugin_deactivate' );
	}

	/**
	 * [removeCronEvents description]
	 * @return [type] [description]
	 */
	public function removeCronEvents()
	{
		$timestamp = wp_next_scheduled( $this->model::RECCURING_EVENT_NAME );
		wp_unschedule_event( $timestamp, $this->model::RECCURING_EVENT_NAME );
	}

}
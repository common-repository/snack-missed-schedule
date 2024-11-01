<?php

namespace Snack\MissedSchedule\Models;

/**
 * 
 */
class wpModel
{	
	/**
	 * Define name of cron recurring event
	 */
	const RECCURING_EVENT_NAME 	= 'snack_missed_check';

    /**
     * Default list of post types we want to check missed schedules for
     */
    const DEFAULT_POST_TYPES = [ 'post', 'page' ];

	/**
     * [$wpdb description]
     * @var [type]
     */
    protected $wpdb;

    /**
     * [__construct description]
     */
    public function __construct()
    {
    	global $wpdb;

    	$this->wpdb = $wpdb;
    }

	/**
     * [addCronSchedules description]
     * @param [type] $schedules [description]
     */
    public function addCronSchedules( $schedules )
    {
        $schedules['sms_five_minutes'] = [
                'interval'  => 300,
                'display'   => 'Once in 5 minutes'
        ];

        return $schedules;
    }

    /**
     * [getMissedSchedules description]
     * @return [type] [description]
     */
    public function getMissedSchedules()
    {
        $allPostTypesCsv    = implode( '\',\'', self::DEFAULT_POST_TYPES );
        
        $postTypes          = $this->getPublicPostTypes();

        if ( is_array( $postTypes ) && count( $postTypes) > 0 )
        {
            $allPostTypes       = array_merge( self::DEFAULT_POST_TYPES, array_keys( $postTypes ) );
            $allPostTypesCsv    = implode( '\',\'', $allPostTypes );
        }

        return $this->wpdb->get_col(
		            $this->wpdb->prepare(
		                "SELECT ID FROM " .  $this->wpdb->prefix . "posts WHERE post_type IN ('$allPostTypesCsv') AND post_date <= %s AND post_status = 'future' LIMIT 10",
		                current_time( 'mysql', 0 )
		            )
		        );
    }

    /**
     * [notifyAdmin description]
     * @return [type] [description]
     */
    public function notifyAdmin( $postId )
    {
        $notifyEnabled = defined( 'SNACK_MS_NOTIFY_ADMIN' ) ? SNACK_MS_NOTIFY_ADMIN : false;

        if ( ! $notifyEnabled )
        	return;

        @wp_mail(
            get_option( 'admin_email' ),
            'Missed schedule post published (' . $postId . ')',
            'Post with ID ' . $postId . ' has been published.'
        );
    }

    /**
     * [getPublicPostTypes description]
     * @return [type] [description]
     */
    private function getPublicPostTypes()
    {
        return get_post_types([ 
            'public'    => true,
            '_builtin'  => false 
        ]);
    }

}
<?php 
//////////////////////////////////////////////////////////////////
// ZANOX WP CRON
//////////////////////////////////////////////////////////////////

//path zanox class
include('zanox/classXml.php');

add_filter( 'cron_schedules', 'add_cron_intervals' );

function add_cron_intervals( $schedules ) {

   $schedules['3600seconds'] = array( // Provide the programmatic name to be used in code
      'interval' => 3600, // Intervals are listed in seconds
      'display' => __('Every 3600 Seconds') // Easy to read display name
   );
   return $schedules; // Do not forget to give back the list of schedules!
}

add_action( 'cron_hook', 'cron_exec' );

if( !wp_next_scheduled( 'bl_cron_hook' ) ) {
   wp_schedule_event( time(), '3600seconds', 'cron_hook' );
}

function cron_exec() {
    // do something every hour    
    $zanox = new xmlParser();
    echo $zanox->initXmlToHtml();
}
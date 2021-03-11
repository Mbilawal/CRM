<?php 
 
class Push {
    //notification title
    private $title;
 
    //notification message 
    private $message;
 
    
 
    //initializing values in this constructor
    function __construct($title, $message) {
         $this->title = $title;
         $this->message = $message;
    }
    
    //getting the push notification
    public function getPush() {
        $res = array();
        $res['custom']['title'] = $this->title;
	$res['custom']['type'] = "";
	$res['custom']['custom_message'] = $this->message;
        $res['notification']['title'] = $this->title;
	$res['notification']['type'] = "";
	$res['notification']['custom_message'] = $this->message;
        return $res;
    }
 
}
?>
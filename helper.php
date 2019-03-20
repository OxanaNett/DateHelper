<?php
class Service {

	 public $id;
	 public $user_id;
	 public $codename;
	 private $status;
	 public $create_at;
	 public $ending_at;
	 
	 function __construct($id,$user_id,$codename,$status,$create_at,$ending_at)
	 {
		$this->id=$id;
		$this->user_id=$user_id;
		$this->codename=$codename;
		$this->status=$status;
		$this->create_at=$create_at;
		$date = new DateTime($ending_at);
		$date->setTime(23,59,59);  
		$this->ending_at= $date->format('Y-m-d H:i:s');
	 }
//the rest of days from creation---------1	 
	 function ServiceValidDays($ending_at)
	 {
	 	$begin = DateTime::createFromFormat("Y-m-d H:i:s", $this->create_at); 
		$end = DateTime::createFromFormat("Y-m-d H:i:s", $ending_at); 
		if ($begin<$end)
		return $begin->diff($end)->format("%a");
		else return 'Begin cant be bigger than end';
	 }
// the rest of days from now 
	 function ServiceRestDays($ending_at)
	 {
	 	$now = new DateTime(); 
		$end = DateTime::createFromFormat("Y-m-d H:i:s", $ending_at); 
		if ($now<$end)
		return $now->diff($end)->format("%a");
		else return 'No days left';
	 }
//2
	 function IsServiceActive($ending_at)
	 {
	 	$now = new DateTime();
		$date = DateTime::createFromFormat("Y-m-d H:i:s",$ending_at); 
		return ($now<$date);
	 }
	 function IsServiceExpiring($ending_at)
	 {
	    $now = new DateTime();
		$end = DateTime::createFromFormat("Y-m-d H:i:s",$ending_at);
		if ($now < $end) 
			 if ($now->diff($end)->days <10) return 'Expiring';
			 else return 'Not Expiring';
		else return 'Expired';	 
	 }
	 function DaysOfExpiration($ending_at)
	 {
	 	$now = new DateTime(); 
		$end = DateTime::createFromFormat("Y-m-d H:i:s", $ending_at); 
		if ($now>$end) 
		 if ($now->diff($end)->format("%a")<=10) return $now->diff($end)->format("%a");
		 else return 'the service was deleted more than 10 days ago';
		else return 'The service is not expired';
	 }
	  function StatusOnEnding()
	  {
	  
	  }
	 
	 
}
$Ending_at='2019-03-09 02:25:11';
$Created_at='2019-03-01 08:29:24';

$ServiceExample= new Service(1,1,2,'busy',$Created_at,$Ending_at);
echo "incoming info:</br>";
echo "Created_at:",$ServiceExample->create_at, '</br>';
echo "Ending_at:",$ServiceExample->ending_at, '</br>';
echo '</br>';
//1
echo 'ServiceValidDays:  ';
echo $ServiceExample->ServiceValidDays($Ending_at);
echo '</br>ServiceRestDays:  ';
echo $ServiceExample->ServiceRestDays($Ending_at);
echo '</br>IsServiceActive:   ';
//2
if ($ServiceExample->IsServiceActive($Ending_at)) echo 'Service is active';
else echo 'Service no active';
//3
echo '</br>IsServiceExpiring:   ';
echo $ServiceExample->IsServiceExpiring($Ending_at);

echo '</br>DaysOfExpiration:   ';
echo $ServiceExample->DaysOfExpiration($Ending_at);




?>



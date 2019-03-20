<?php
class Service {

	 private $id;
	 private $user_id;
	 private $codename;
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
		$date_end = new DateTime($ending_at);
		$date_end->setTime(23,59,59);
		if ($create_at < $date_end)
		$this->ending_at= $date_end->format('Y-m-d H:i:s');
		else $this->ending_at =$create_at;
	 }
// function to identify the last day of calculation	 
	 function LastServiceDay($current)
	 {
	   if (($this->ending_at > $current) and ($this->create_at < $current))
	   	return $current;
	   elseif ($this->ending_at < $current) 
	   	return $this->ending_at;
	   elseif ($this->create_at > $current)
	  	 return $this->create_at; 
	 }
	 
//the rest of days from creation---------1	 
	 function ServiceValidDays($ending_at)
	 {
		$begin = DateTime::createFromFormat("Y-m-d H:i:s", $this->create_at); 
	 	$end = $this->LastServiceDay($ending_at);
		if ($begin<$end)
		 return $begin->diff($end)->format("%a");
		else return 0;
	 }
// the rest of days from now 
	 function ServiceRestDays($ending_at)
	 {
	 	$now = new DateTime(); 
	 	$end = DateTime::createFromFormat("Y-m-d H:i:s", $this->LastServiceDay($ending_at));
		if (($end < $now  ) and ($this->create_at < $now))
			return $now->diff($end)->format("%a");
		else return 0;
	 }
	 function ServiceAllDays()
	 {
	 	return DateTime::createFromFormat("Y-m-d H:i:s", $this->LastServiceDay($ending_at))->diff(DateTime::createFromFormat("Y-m-d H:i:s", $this->LastServiceDay($create_at)))->format("%a");
	 	
	 }
//2
	 function IsServiceActive($ending_at)
	 {
	 	$begin = DateTime::createFromFormat("Y-m-d H:i:s", $this->create_at); 
		$now = new DateTime();
	 	$end = DateTime::createFromFormat("Y-m-d H:i:s", $this->LastServiceDay($ending_at));
		if (($end > $now) and ($begin < $now))
		 return 1;
		else 
		 return 0; 
	 }
//3
	 function IsServiceExpiring($ending_at)
	 {
	    $now = new DateTime();
	 	$end = DateTime::createFromFormat("Y-m-d H:i:s", $this->LastServiceDay($ending_at));
		if ($now < $end) 
			 if ($now->diff($end)->days <10) return 'Expiring';
			 else return 'Not Expiring';
		else return 'Expired';	 
	 }
//4	 
	 function DaysOfExpiration($ending_at)
	 {
	 	$now = new DateTime(); 
	 	$end = DateTime::createFromFormat("Y-m-d H:i:s", $this->LastServiceDay($ending_at));
		if ($now>$end) 
		 if ($now->diff($end)->format("%a")<=10) return $now->diff($end)->format("%a");
		 else return 'the service was deleted more than 10 days ago';
		else return 'The service is not expired';
	 }
//5	 
	 
	  function StatusOnEnding()
	  {
	  
	  }
	 
	 
}
$Ending_at='2019-03-09 02:25:11';
$Created_at='2019-03-01 03:25:11';

$ServiceExample= new Service(1,1,2,'busy',$Created_at,$Ending_at);
echo "incoming info:</br>";
echo "Created_at:",$ServiceExample->create_at, '</br>';
//
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



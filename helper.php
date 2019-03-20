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
		$this->id =$id;
		$this->user_id =$user_id;
		$this->codename =$codename;
		$this->status =$status;
		$this->create_at =$create_at;
		$this->ending_at = new DateTime($ending_at);
		$this->ending_at->setTime(23,59,59);
		$this->create_at =new DateTime($create_at);
		if ($this->create_at > $this->ending_at)
		   $this->ending_at= $this->create_at;//$date_end->format('Y-m-d H:i:s');
		
	 }
// function to identify the last day of calculation	 
	 function LastServiceDay($current)
	 {
	   $curr = new DateTime($current);
	   if (($this->ending_at > $curr) and ($this->create_at < $curr))
	   	return $curr;
	   elseif ($this->ending_at < $curr) 
	   	return $this->ending_at;
	   elseif ($this->create_at > $current)
	  	 return $this->create_at; 
	 }
	 
//1	 
	 function ServiceValidDays($ending_at)
	 {
	 	$end = $this->LastServiceDay($ending_at);
		if ($this->create_at<$end)
		 return $this->create_at->diff($end)->format("%a");
		else return 0;
	 }

//2
	 function IsActive($ending_at)
	 {
		$now = new DateTime();
	 	$end = $this->LastServiceDay($ending_at);
		if (($end < $now) and ($this->create_at < $now))
		 return 1;
		else 
		 return 0; 
	 }
//3
	 function IsSExpiring($ending_at)
	 {
	    $now = new DateTime();
	 	$end = $this->LastServiceDay($ending_at);
		if ($now < $end) 
			 if ($now->diff($end)->days <10) return 'Expiring';
			 else return 'Not Expiring';
		else return 'Expired';	 
	 }
//4	 
	 function DaysOfExpiration($ending_at)
	 {
	 	$now = new DateTime(); 
	 	$end = $this->LastServiceDay($ending_at);
		if ($now>$end) 
		 if ($now->diff($end)->format("%a")<=10) return $now->diff($end)->format("%a");
		 else return 'the service is expired';
		else return 'The service is not expired';
	 }
//5	 
	  function IsOnDelete($ending_at)
	  {
	  	$now = new DateTime(); 
		$end = $this->LastServiceDay($ending_at);
        if (($now>$end) and ($now->diff($end)->format("%a")<=10)) return 1;
		else return 0;
	  }
//6	  
	  function FinalExpirationDate($ending_at)
	  {
		$end = $this->LastServiceDay($ending_at);
		return $end+10;
	  }
//7	  
      function  IsFinallyExpired()
	  {
	    $now = new DateTime(); 
		$end = $this->LastServiceDay($ending_at);
        if (($now>$end) and ($now->diff($end)->format("%a")>10)) return 1;
		else return 0;
	   
	  }  
	 
	 
}
$Created_at='2019-03-01 03:25:11';
$Ending_at='2019-03-09 02:25:11';
$Ending_input='2019-03-08 08:25:11';

$ServiceExample= new Service(1,1,2,'busy',$Created_at,$Ending_at);
echo "incoming info:</br>";
echo "Created_at:",$ServiceExample->create_at->format('Y-m-d H:i:s'), '</br>';
echo "Ending_at:",$ServiceExample->ending_at->format('Y-m-d H:i:s'), '</br>';
echo "Ending_input:",$Ending_input, '</br>';
echo '</br>';
//1
echo 'ServiceValidDays:  ';
echo $ServiceExample->ServiceValidDays($Ending_input);
/*//2
if ($ServiceExample->IsServiceActive($Ending_at)) echo 'Service is active';
else echo 'Service no active';
//3
echo '</br>IsServiceExpiring:   ';
echo $ServiceExample->IsServiceExpiring($Ending_at);

echo '</br>DaysOfExpiration:   ';
echo $ServiceExample->DaysOfExpiration($Ending_at);*/




?>



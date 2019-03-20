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
	 function LastDay($current)
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
	 function ValidDays($ending_at)
	 {
	 	$end = $this->LastDay($ending_at);
		if ($this->create_at<$end)
		 return $this->create_at->diff($end)->format("%a");
		else return 0;
	 }

//2
	 function IsActive($ending_at)
	 {
		$now = new DateTime();
	 	$end = $this->LastDay($ending_at);
		if (($end < $now) and ($this->create_at < $now))
		 return 0;
		else 
		 return 1; 
	 }
//3
	 function IsExpiring($ending_at)
	 {
	    $now = new DateTime();
	 	$end = $this->LastDay($ending_at);
		if ($now < $end) 
			 if ($end->diff($now)->days <=10) return 1;
			 else return 0;
		else return 0;	//the service is expired 
	 }
//4	 
	 function DaysOfExpiration($ending_at)
	 {
	 	$now = new DateTime(); 
	 	$end = $this->LastDay($ending_at);
		if ($now>$end) 
		 if ($now->diff($end)->format("%a")<=10) return $now->diff($end)->format("%a");
		 else return 0; //'the service is expired'
		else return 0; //'The service is not expired'
	 }
//5	 
	  function IsOnDelete($ending_at)
	  {
	  	$now = new DateTime(); 
		$end = $this->LastDay($ending_at);
        if (($now>$end) and ($now->diff($end)->format("%a")<=10)) return 1;
		else return 0;
	  }
//6	  
	  function FinalExpirationDate($ending_at)
	  {
		$end = $this->LastDay($ending_at);
		return $end->modify('+10 day');
	  }
//7	  
      function  IsFinallyExpired($ending_at)
	  {
	    $now = new DateTime(); 
		$end = $this->LastDay($ending_at);
        if (($now>$end) and ($now->diff($end)->format("%a")>10)) return 1;
		else return 0;
	   
	  }  
	 
	 
}
$Created_at='2019-03-01 03:25:11';
$Ending_at='2019-03-20 22:25:11';
$Ending_input='2019-03-20 22:25:11';

$ServiceExample= new Service(1,1,2,'busy',$Created_at,$Ending_at);
echo "incoming info:</br>";
echo "Created_at:",$ServiceExample->create_at->format('Y-m-d H:i:s'), '</br>';
echo "Ending_at:",$ServiceExample->ending_at->format('Y-m-d H:i:s'), '</br>';
echo "Ending_input:",$Ending_input, '</br>';
echo '</br>';
//1
echo 'ServiceValidDays:  ';
echo $ServiceExample->ValidDays($Ending_input);
echo '</br>';
//2
if ($ServiceExample->IsActive($Ending_input)) echo 'Service is active';
else echo 'Service no active';
//3
echo '</br>IsExpiring:   ';
echo $ServiceExample->IsExpiring($Ending_input);
//4
echo '</br>DaysOfExpiration:   ';
echo $ServiceExample->DaysOfExpiration($Ending_input);
//5
echo '</br>IsOnDelete:   ';
echo $ServiceExample->IsOnDelete($Ending_input);
//6
echo '</br>FinalExpirationDate:   ';
echo $ServiceExample->FinalExpirationDate($Ending_input)->format('Y-m-d H:i:s');
//7
echo '</br>IsFinallyExpired:   ';
echo $ServiceExample->IsFinallyExpired($Ending_input);



?>



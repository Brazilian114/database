<?php

     
date_default_timezone_set('Asia/Bangkok');
//print_r ( localtime ( time(), true ) );

$Dt = new \DateTime();
$hour = $Dt->format('H');
$minute = $Dt->format('i');
$second = $Dt->format('s');
$endHour = '23';


?>



<?php
if($second > 0 || $minute > 0)
{
   $Dt->setTime($hour, '0', '0');
   $Dt->add(new \DateInterval('PT1H'));
 }
?>


<select name="time">
 <option value="">---เลือกเวลา----</option>
<option>
<?php
 for ($i= $Dt->format('H'); $i <= $endHour; $i++)
 {
   echo $Dt->format('H:i:s') . '<option>' . PHP_EOL;
   $Dt->add(new \DateInterval('PT1H'));

 }

?>
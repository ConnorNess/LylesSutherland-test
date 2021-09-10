<!DOCTYPE html>
<html>
<body>

<?php
//Began implementation at 12:50pm on 10/09 after work, only work done previously was
//the readme pseudocode done during breaks at work


/*  Managers
*   A manager must be available to be at a appointment, location is 
*   tracked as if more than 3 appointments are scheduled for the same time
*   this would not matter if a manager is at all 3 active locations
*/
class manager{
  public $available;
  public $time;
  public $location;

  function set_available($available){
    $this->available = $available;
  }
  function get_available(){
    return $this->available;
  }

  function set_time($time){
    $this->time = $time;
  }
  function get_time(){
    return $this->time;
  }

  function set_location($location){
    $this->location = $location;
  }
  function get_location(){
    return $this->location;
  }
}

$manager_1 = new manager();
$manager_1->set_available('true');
$manager_1->set_time(null);
$manager_1->set_location(null);

$manager_2 = new manager();
$manager_2->set_available('true');
$manager_2->set_time(null);
$manager_2->set_location(null);

$manager_3 = new manager();
$manager_3->set_available('true');
$manager_3->set_time(null);
$manager_3->set_location(null);


//Tenants
$tenantarray = array(); //Array to be filled with CSV
$file = fopen('tenants.csv', 'r'); //Open and close the CSV, fill each entry to the array
while (($line = fgetcsv($file)) !== FALSE) {
  array_push($tenantarray, $line);
}
fclose($file);
array_shift($tenantarray); //Remove the variable headers, takes the first line out

/*  Sort the array by time, will do on appointment date+time but I 
*   believe a greater implementation should sort the same times
*   by time placed, giving priority to earlier created appointments
*
*
*   Planned to implement quicksort as done before but will spend a small amount seeing if
*   PHP sort or usort are easy to pickup
*
*   Seems usort can have a custom comparison like datetime, will see if its easy to merge
*   date and time to make datetime so we are still in scope of the doc, they weren't said
*   to be the same variable so lets keep them seperate
*/


/*
foreach($tenantarray as $appointment){ //Lets check each appointment
  print_r($appointment);
}
*/

print_r($tenantarray[0][5]);


?>

</body>
</html>
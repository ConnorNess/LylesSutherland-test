<!DOCTYPE html>
<html>
<body>

<?php
//Connor Ness
//connor.ness@outlook.com


//Began implementation at 12:50pm on 10/09 after work, only work done previously was
//the readme pseudocode done during breaks at work - consider this 1 extremely broken
//up hour of design before implementation


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

/*  Indexs for tenant variables
*   0 TenantID
*   1 First Name
*   2 Surname
*   3 Email
*   4 Phone
*   5 Move Date
*   6 Move Time
*   7 Property ID
*/  

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

function sort_tenant($a, $b){
  $a_date = $a[5];
  $a_time = $a[6]; 
  $a_datetime = date('Y-m-d H:i:s', strtotime("$a_date $a_time")); //https://stackoverflow.com/questions/19375184/merge-date-time was useful here

  $b_date = $b[5];
  $b_time = $b[6];
  $b_datetime = date('Y-m-d H:i:s', strtotime("$b_date $b_time"));
  
  if ($a_datetime == $b_datetime){ //https://stackoverflow.com/questions/8121241/sort-array-based-on-the-datetime-in-php was used for reference here
    return 0;
  }

  return $a_datetime < $b_datetime ? -1 : 1;
}

/*echo "<pre>";
print_r($tenantarray);
echo "</pre>";*/

usort($tenantarray, "sort_tenant"); 
/*  Hey it works, neat - think that was easier to implement than a quicksort, unsure about efficiency however
*   would have to actually test both to find out but seems to be efficient even if not *more* efficient
*/



/*  Ok, array is sorted in date/time - as said before I think an appointment book time would 
*   be a fairer system but out of scope, we assume that if an appointment is later in the day,
*   it was booked later. By this, if no managers can travel to a destination then its rearranged.
*
*   Basing this off of the pseudocode but I feel if there are any inefficiencies in the script, it'll
*   be here but I'm pretty confident its designed well.
*/

function newdate($manager_1, $manager_2, $manager_3){
  //A new day means everyone's schedule is free and they aren't at a property
  $manager_1->set_available('true');
  $manager_1->set_time(null);
  $manager_1->set_location(null);

  $manager_2->set_available('true');
  $manager_2->set_time(null);
  $manager_2->set_location(null);

  $manager_3->set_available('true');
  $manager_3->set_time(null);
  $manager_3->set_location(null);
}

function rearrange($appointment){
  echo "<pre>";
  echo "Appointment for tenant: $appointment[0]($appointment[1] $appointment[2]) will be rescheduled";
  echo "</br>";
  echo "Sending email to $appointment[3]....";
  echo "</pre>";
}

function appointment_valid($appointment){
  echo "<pre>";
  echo "Appointment for tenant: $appointment[0]($appointment[1] $appointment[2]) has been completed!";
  echo "</pre>";
}

$app_date = $tenantarray[0][5]; //Date of earliest appointment, use this to track new days
foreach($tenantarray as $appointment){ //Lets check each appointment
  if($appointment[5] != $app_date){ //If the appointment date isn't the last date used
    newdate($manager_1, $manager_2, $manager_3); //Clean schedules
    $app_date = $appointment[5]; //Swap the date
  }

  //Ok, time to find out if PHP has a way to easily get the last days of a month
  //https://www.php.net/manual/en/function.date.php "t" seems to return the last date of the month - nice
  $end_of_month = date("Y-m-t", strtotime($appointment[6]));
  if($appointment[6] == $end_of_month){
    rearrange($appointment);
    continue;
  }

  //Check what managers are free
  //If the appointment is later than the current time of the manager + travel distance (30 mins), then they can make it
  if($appointment[6] > date("H:i:s", (strtotime("+30 minutes", strtotime($manager_1->get_time()))) || $manager_1->get_time() == null)){
    $manager_1->set_available = true;
  }
  if($appointment[6] > date("H:i:s", (strtotime("+30 minutes", strtotime($manager_2->get_time()))) || $manager_2->get_time() == null)){
    $manager_2->set_available = true;
  }
  if($appointment[6] > date("H:i:s", (strtotime("+30 minutes", strtotime($manager_3->get_time()))) || $manager_3->get_time() == null)){
    $manager_3->set_available = true;
  }

  //Lets send whos available
  if($manager_1->get_available() || $manager_1->get_location = $appointment[7]){
    $manager_1->set_available = false;
    $manager_1->set_time = $appointment[6];
    $manager_1->set_location = $appointment[7];
    appointment_valid($appointment);
  }
  elseif($manager_2->get_available() || $manager_2->get_location = $appointment[7]){
    $manager_2->set_available = false;
    $manager_2->set_time = $appointment[6];
    $manager_2->set_location = $appointment[7];
    appointment_valid($appointment);
  }
  elseif($manager_3->get_available() || $manager_3->get_location = $appointment[7]){
    $manager_3->set_available = false;
    $manager_3->set_time = $appointment[6];
    $manager_3->set_location = $appointment[7];
    appointment_valid($appointment);
  }
  else{
    rearrange($appointment);
  }
}

?>

</body>
</html>
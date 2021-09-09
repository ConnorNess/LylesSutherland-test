# LylesSutherland-test
coding assessment

To Run
____________
Simply place the CSV and propertyvisit.php in the same directory, I used apache so they were placed in htdocs but WAMP should work just as easily
Initialise the server and head to the localhost directory


Rules
_____________
Recieve a CSV of a list of tenants with relevant information
30 check ins
Move in time is on the hour or half hour
properties may have one or many tenants moving in
3 potential managers but on priority of 1->2->3, more needed require a reschedule
30 mins travel time between each location
if move in date is last day of month, notify tenant of rearrange


Plan
_____________
Create CSV in excel to quick make all needed info
Follow design to create a php app to grab info from csv and process
Ensure app is robust and functional
Upload all to a repo 
Submit
Get hired

CSV
_____________
Say 30 tenants to 20 properties? sounds realistic
Have most occur in the same days to allow all rules to be met (overlaps, not enough managers etc.) but also end of month days and the like


Cases planned
4 move in dates but one is at same property, therefor can go forward with no reschedule
    tenantIDs 1 2 3 21
4 move in dates at seperate property, reschedule needed
    tenant IDs 11 12 13 14
Move in date on last of differing months (i.e. one month ends 30, one 31)
    tenant IDs 29 30

Design
_____________
recieve CSV file on api call REQUIREMENT
create managers (can be simple representations bool "manager1/2/3")
read in CSV fgetcsv to array
sort array by time of appointment
check each appointment if valid
check for overlaps in move in time
    if overlap, assign other manager IF not same property
    if another, assign another IF not same property
    if more than 3 appointments at once AND no overlaps notify reschedule

Pseudocode
_____________
CLASS manager
    available
    time
    location

    FUNCTION GET/SET available
    FUNCTION GET/SET time
    FUNCTION GET/SET location

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


ARR tenants SET (GET tenants CSV)
SORT tenants ARR //Quicksort? done it before and its pretty scalable iirc


FUNCTION newdate() //New day, everyone is free
$manager_1->set_available('true');
$manager_1->set_time(null);
$manager_1->set_location(null);

$manager_2->set_available('true');
$manager_2->set_time(null);
$manager_2->set_location(null);

$manager_3->set_available('true');
$manager_3->set_time(null);
$manager_3->set_location(null);

'date' = tenants[0][5] //Date of earliest appointment
LOOP FOR length (ARR tenants AS tenant)
    //New day, everyone is free
    thisdate = tenant[5]
    IF thisdate != date:
        newdate()
        date = thisdate
    
    //No work done on last day
    IF thisdate = end of month:
        rearrange
        continue

    //Who is free?
    IF(tenant[6] > manager_1->get_time + 30min || manager_1->get_time = null):
        manager_1->set_available = true
    IF(tenant[6] > manager_2->get_time + 30min || manager_2->get_time = null):
        manager_2->set_available = true
    IF(tenant[6] > manager_3->get_time + 30min || manager_3->get_time = null):
        manager_3->set_available = true

    //Send out available
    IF(manager_1->get_available || manager_1->get_location = tenant[7]):
        manager_1->set_available = false;
        manager_1->set_time = tenant[6];
        manager_1->set_location = tenant[7];

    ELSEIF(manager_2->getavailable || manager_2->get_location = tenant[7]):
        manager_2->set_available = false;
        manager_2->set_time = tenant[6];
        manager_2->set_location = tenant[7];

    ELSEIF(manager_3->getavailable || manager_3->get_location = tenant[7]):
        manager_3->set_available = false;
        manager_3->set_time = tenant[6];
        manager_3->set_location = tenant[7];

    ELSE:
        rearrange


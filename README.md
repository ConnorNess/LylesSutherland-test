# peoplebank-test
coding assessment


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
create managers (can be simple representations str "manager1/2/3")
read in CSV fgetcsv
check for overlaps in move in time
    if overlap, assign other manager IF not same property
    if another, assign another IF not same property
    if more than 3 appointments at once AND no overlaps notify reschedule


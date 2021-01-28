<?php

//setOpeningHours-----------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------

$week[]=new  OpeningHours('SUNDAY',"08:00", "20:00", null, null);
$week[]=new OpeningHours('MONDAY', "08:00", "20:00", null, null);
$week[]=new OpeningHours('TUESDAY', "08:00", "20:00", null, null);
$week[]=new OpeningHours('WEDNESDAY', "08:00", "20:00", null, null);
$week[]=new OpeningHours('THURSDAY', "08:00", "20:00", null, null);
$week[]=new OpeningHours('FRIDAY', "07:00", "14:00", null, null);
$week[]=new OpeningHours('SATURDAY', null, null, null, null);

var_dump(managerActions::setOpeningHours($week));

//------------------------------------------------------------------------------------------










?>

<?php

require_once __DIR__.'/Constants.php';
require_once __DIR__.'/actions/customerActions.php';
require_once __DIR__.'/actions/managerActions.php';
require_once __DIR__.'/actions/commonActions.php';

require_once __DIR__.'/beans/Appointment.php';
require_once __DIR__.'/beans/Customer.php';
require_once __DIR__.'/beans/Employee.php';
require_once __DIR__.'/beans/EmployeeAbsence.php';
require_once __DIR__.'/beans/WorkHours.php';
require_once __DIR__.'/beans/FullyBookedDate.php';
require_once __DIR__.'/beans/OpeningHours.php';
require_once __DIR__.'/beans/ContactUs.php';
require_once __DIR__ . '/beans/BlockedAppointment.php';
require_once __DIR__ . '/beans/ServiceType.php';



require_once __DIR__.'/managers/AppointmentDBDAO.php';
require_once __DIR__.'/managers/CustomerDBDAO.php';
require_once __DIR__.'/managers/EmployeeAbsenceDBDAO.php';
require_once __DIR__.'/managers/EmployeeDBDAO.php';
require_once __DIR__.'/managers/SQLConnection.php';
require_once __DIR__.'/managers/WorkHoursDBDAO.php';
require_once __DIR__.'/managers/OpeningHoursDBDAO.php';
require_once __DIR__.'/managers/FullyBookedDateDBDAO.php';
require_once __DIR__.'/managers/ContactUsDBDAO.php';
require_once __DIR__.'/managers/BlockedAppointmentDBDAO.php';
require_once __DIR__.'/managers/ServiceTypeDBDAO.php';



require_once __DIR__.'/exceptions/IdDoesNotExistsException.php';
require_once __DIR__.'/exceptions/ContactUsIsEmptyException.php';



require_once 'exceptions/IdDoesNotExistsException.php';
require_once 'exceptions/ContactUsIsEmptyException.php';


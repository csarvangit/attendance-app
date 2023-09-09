<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class AttendanceExport implements FromCollection, WithHeadings
{


    protected $id;

    function __construct($id) {
            $this->id = $id;
    }

    /**
    * @return \Illuminate\Support\Collection
    * @query AttendanceController::userlog
    */
    public function collection()
    {
        $attendancelogs =  DB::table('attendance as a1')
        ->where('a1.userId', '=', $this->id)	
        ->select( 
            'u.userId',
            'u.firstName', 
            'u.lastName',
            'u.email',
            'u.mobile', 
            's.shiftName', 
            'a1.startTime', 
            'a1.endTime', 
            'a1.startDate', 
            'a1.endDate',  
            DB::raw("TIME_FORMAT(SEC_TO_TIME((TIME_TO_SEC(CASE WHEN SUBTIME(IFNULL(TIME(a1.endTime),0),IFNULL(TIME(a1.startTime),0)) > '00:00:00' THEN SUBTIME(IFNULL(TIME(a1.endTime),0),IFNULL(TIME(a1.startTime),0)) ELSE '00:00:00' END))), '%H:%i:%s' )as total_hours ") 
            )
        ->leftJoin('users as u', 'u.userId', '=', 'a1.userId')		
        ->leftJoin('shifttime as s', 's.shiftId', '=', 'a1.shiftId') 									
        ->groupBy('a1.userId')	
        ->groupBy('a1.attandanceId')
        ->orderBy('a1.attandanceId', 'desc')
        ->get();

        if( $attendancelogs->count() > 0 ){	
            return $attendancelogs;
        } else{
            return null;
        }                
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["ID", "First Name", "Last Name", "Email", "Mobile", "Shift Name", "Punch In Time", "Punch Out Time", "Punch In Date", "Punch Out Date", "Total Hours", "Permission", "Leave", "Late", "OverTime"];
    }
}

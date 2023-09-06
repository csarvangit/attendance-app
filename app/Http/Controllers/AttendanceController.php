<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\QueryException;
use File;

use App\Http\Controllers\ShiftTimeController;

class AttendanceController extends Controller
{
    
    public $successStatus = 200;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {      
       //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function isPunchInLate(string $userId){

        $diffInHours = 0;  
        $isPast = false;   
        $success['lateBy'] = $diffInHours;  

        /* To find Time Difference */                
        $ShiftTime = (new ShiftTimeController)->getUserShiftTime($userId); 
        $ShiftTime = $ShiftTime->getData();        
        if( $ShiftTime->success == true ){   
            $options = [
                'join' => ': ',
                'parts' => 1,
                'syntax' => CarbonInterface::DIFF_ABSOLUTE,
            ];
            $currentTime = Carbon::now();
            $startTime = Carbon::parse($ShiftTime->data->startTime);              
             //$startTime = Carbon::parse('01:26:00');  
            $diffInHours = $startTime->diffForHumans($currentTime, $options); 
            $isPast = $startTime->isPast();  
            if($isPast){
                $success['lateBy'] = $diffInHours;
            }        
            return $success;
        }  
    }

    public function islogin(string $userId)
    {
        try {
            if($userId != NULL || $userId != ''){
                $currentTime = Carbon::now();
                $hasAttendance = Attendance::where('userId', $userId)
                ->where('startDate', $currentTime->toDateString())
                ->get();  
                if( $hasAttendance->count() > 0 ){	
                    $loginData['currentTime'] = $currentTime->format('Y-m-d h:i:s');
                    $loginData['punchInTime'] = $hasAttendance[0]['startTime'];
                    $loginData['punchOutTime'] = $hasAttendance[0]['endTime'];

                    $result = $this->isPunchInLate($userId);
                    $loginData['lateBy'] = $result['lateBy'];                                    

                    return response()->json(['success'=> true, 'data' => $loginData], $this->successStatus);
                }else{ 
                    return response()->json(['success'=> false], $this->successStatus);
                }
            }else{
                return response()->json(['success'=> false, 'message' => 'Invalid User Id'], $this->successStatus);     
            } 
        }
        catch (\Throwable $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        } catch (\PDOException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
            } catch (\Exception $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        }      
    }

    public function createDirectory()
    {
        $path = public_path('uploads/staffs');

        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);        
        }   
    }

    public function in(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [ 
               'userId' => 'required',
               'shiftId' => 'required', 
               'associatedId' => 'required', 
               'imageUrl' => 'required',
           ]);
           if ($validator->fails()) { 
               return response()->json(['error'=>$validator->errors()], 401);            
           }
           //dd($request->all()); 
           $input = $request->all(); 
           //DB::enableQueryLog();
          
            $userId = $input['userId'];
            $currentTime = Carbon::now();
                         
            $islogin = $this->islogin($userId);
            $islogin = $islogin->getData();               

            $result = $this->isPunchInLate($userId);
            $success['currentTime'] = $currentTime->format('Y-m-d h:i:s');
            $success['punchInTime'] = $currentTime->format('Y-m-d h:i:s');
            $success['lateBy'] = $result['lateBy'];  

            if( $islogin->success == true ){	
                $success['message'] = 'Already Punch In';
                return response()->json(['success'=> true, 'data' => $success], $this->successStatus);
            }else{  
                $this->createDirectory();
                $fileName = time().'.'.$request->imageUrl->extension();      
                $request->imageUrl->move(public_path('uploads/staffs'), $fileName);
                $input['imageUrl'] = $fileName;

                $input['startTime'] =  $currentTime;
                $input['startDate'] =  $currentTime;
                $input['status']    =  'A'; 
                $input['createdBy'] =  '0'; 
                $input['createdOn'] =  $currentTime;                     
                
                $attendance = Attendance::create($input);                                 
               
                $success['message'] = 'Punch In Success'; 
                

                return response()->json(['success'=> true, 'data' => $success], $this->successStatus);
            } 
        }
        catch (\Throwable $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        } catch (\Illuminate\Database\QueryException $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        } catch (\PDOException $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
         } catch (\Exception $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        }   
    }

    public function out(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [ 
               'userId' => 'required',                        
           ]);
           if ($validator->fails()) { 
               return response()->json(['error'=>$validator->errors()], 401);            
           }
           $input = $request->all(); 
           
           $input['endTime'] =  Carbon::now();
           $input['endDate'] =  Carbon::now();          
           $input['modifiedBy'] =  $input['userId'];
           $input['modifiedOn'] =  Carbon::now(); 
          
            $currentTime = Carbon::now();
            $islogin = $this->islogin($input['userId']);
            $islogin = $islogin->getData();

            if( $islogin->success == true ){  

                if( is_null ($islogin->data->endTime) ){
                    $hasAttendance = Attendance::where('userId', $input['userId'])
                    ->where('startDate', $currentTime->toDateString())
                    ->update($input); 
                }               

                return response()->json(['success'=> true, 'message' => 'Out Success'], $this->successStatus);
            }else{
                return response()->json(['success'=> false, 'message' => 'You are not punch in today'], $this->successStatus);     
            }
        }
        catch (\Throwable $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        } catch (\Illuminate\Database\QueryException $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        } catch (\PDOException $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
         } catch (\Exception $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        }   
    }

    /**
     * get a listing of the resource.
     */
    public function logs(string $id)
    {
        try {
            if (!empty($id)){  
                $attendanceLogs = Attendance::select(['attandanceId', 'userId', 'startTime', 'endTime', 'startDate', 'endDate'])                  
                        ->orderBy('attandanceId', 'desc')        
                        ->where('userId', '=', $id)  
                         ->paginate(10);
               
                if( $attendanceLogs->total() > 0 ){
                    return response()->json(['success'=> true, 'message' => 'Has Log Entries', 'logs' => $attendanceLogs ], $this->successStatus);
                }else{
                    return response()->json(['success'=> false, 'message' => 'No records found for this user', 'logs' => NULL ], $this->successStatus);    
                }               

            } else {
                return response()->json(['success'=> false, 'message' => 'User Id required'], $this->successStatus);     
            }    
        }
        catch (\Throwable $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        } catch (\Illuminate\Database\QueryException $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        } catch (\PDOException $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
         } catch (\Exception $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        }  
    }

    
    /* Get all user logs */
    public function allLogs()
    {
        try {  
            $attendancelogs =  Attendance::join('users', 'users.userId', '=', 'attendance.userId') 
                    ->select(['users.userId', 'users.firstName', 'users.lastName', 'attendance.attandanceId', 'attendance.userId', 'attendance.startTime', 'attendance.endTime', 'attendance.startDate', 'attendance.endDate'])
                    ->orderBy('attendance.attandanceId', 'desc')
                    ->paginate(10);
            
            return view('admin.user-logs', compact('attendancelogs'));
        }
        catch (\Throwable $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        } catch (\Illuminate\Database\QueryException $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        } catch (\PDOException $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
         } catch (\Exception $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        }  
    }

    /* Get user log by its ID */
    public function userlog(string $id)
    {
        try {
                $attendancelogs =  Attendance::join('users', 'users.userId', '=', 'attendance.userId') 
                ->select(['users.userId', 'users.firstName', 'users.lastName', 'attendance.attandanceId', 'attendance.userId', 'attendance.startTime', 'attendance.endTime', 'attendance.startDate', 'attendance.endDate'])
                ->where('attendance.userId', '=', $id)  
                ->orderBy('attendance.attandanceId', 'desc')
                ->paginate(10);
               
                return view('admin.user-logs', compact('attendancelogs'));    
        }
        catch (\Throwable $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        } catch (\Illuminate\Database\QueryException $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        } catch (\PDOException $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
         } catch (\Exception $exception) {
           return response()->json(['error'=> json_encode($exception->getMessage(), true)], 400 );
        }  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
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
        $attendance = User::all();
        return view('attendance', compact('attendance'));
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

    public function islogin(string $userId)
    {
        try {
            if($userId != NULL || $userId != ''){
                $currentTime = Carbon::now();
                $hasAttendance = Attendance::where('userId', $userId)
                ->where('startDate', $currentTime->toDateString())
                ->get();  
                if( $hasAttendance->count() > 0 ){	
                    $loginData['startTime'] = $hasAttendance[0]['startTime'];
                    $loginData['endTime'] = $hasAttendance[0]['endTime'];

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

            if( $islogin->success == true ){	
                return response()->json(['success'=> true, 'message' => 'Already Login'], $this->successStatus);
            }else{                
                /* To find Time Difference */
               /* $ShiftTime = (new ShiftTimeController)->getUserShiftTime($userId); 
                $ShiftTime = $ShiftTime->getData();        
                if( $ShiftTime->success == true ){   
                    $options = [
                        'join' => ': ',
                        'parts' => 2,
                        'syntax' => CarbonInterface::DIFF_ABSOLUTE,
                      ];
                    
                    $startTime = Carbon::parse($ShiftTime->data->startTime);              
                    //$startTime = Carbon::parse('00:55:00');  
                    $diffInHours = $startTime->diffForHumans($currentTime, $options);          
                    dd($diffInHours);
                }  */

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

                return response()->json(['success'=> true, 'message' => 'Login Success'], $this->successStatus);
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

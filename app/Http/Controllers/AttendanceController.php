<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use DB;
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

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
           //dd($request->all()); exit;
           $input = $request->all(); 
           DB::enableQueryLog();
           $dt = Carbon::now();
          /* */ $hasAttendance = Attendance::where('userId', $input['userId'])
                ->where('startDate', $dt->toDateString())
                ->get();                

                /**/ 
               // dd($hasAttendance->toArray());
			// Query	
			//dd(DB::getQueryLog()); exit; 

                if( $hasAttendance->count() > 0 ){	
                    return response()->json(['success'=> true, 'message' => 'Already Login'], $this->successStatus);
                }else{
                    //$fileName = time().'.'.$request->imageUrl->extension();      
                    // $request->imageUrl->move(public_path('public/uploads/staff_attendance'), $fileName);
                    //$input['imageUrl'] = $fileName;

                    $input['startTime'] =  Carbon::now();
                    $input['startDate'] =  Carbon::now();
                    $input['status'] =  'A'; 
                    $input['createdBy'] =  '0'; 
                    $input['createdOn'] =  Carbon::now();                     
                    
                    $attendance = Attendance::create($input);                     

                    return response()->json(['success'=> true, 'message' => 'Login Success'], $this->successStatus);
                } 
          // dd($hasAttendance);             
           
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
        
           /* $find['attandanceId'] =  $id;
           $find['status'] =  'A';
           $find['startDate '] =  Carbon::now(); 

           $attendance = Attendance::find($id)->update($input);  
           */ 
           $dt = Carbon::now();
           $hasAttendance = Attendance::where('userId', $input['userId'])
                ->where('startDate', $dt->toDateString())
                ->get(); 

            if( $hasAttendance->count() > 0 ){	
                $hasAttendance = Attendance::where('userId', $input['userId'])
                ->where('startDate', $dt->toDateString())
                ->update($input); 

                return response()->json(['success'=> true, 'message' => 'Out Success'], $this->successStatus);
            }else{
                return response()->json(['success'=> false, 'message' => 'No record for you today'], $this->successStatus);     
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

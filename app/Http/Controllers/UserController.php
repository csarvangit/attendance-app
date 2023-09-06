<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ShiftTimeWithUsers;
use App\Models\ShiftTime;

use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

use App\Http\Controllers\ShiftTimeController;
use Config;

class UserController extends Controller
{
    public $successStatus = 200;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        try {         
            if(Auth::attempt(['mobile' => request('mobile'), 'password' => request('password')])){ 
                $user = Auth::user(); 
                $userId = $user->userId; 
                $name = $user->firstName . ' ' .$user->lastName;

                $success['userId'] = $userId;
                $success['username'] = $name;

                $punch_in_button_enable_time = Config::get('app.punch_in_button_enable_time'); 
                $punch_out_button_enable_time = Config::get('app.punch_out_button_enable_time');                 
               
                $ShiftTime = (new ShiftTimeController)->getUserShiftTime($userId); 
                $ShiftTime = $ShiftTime->getData();
               
                if( $ShiftTime->success == true ){                 
                    $success['shiftname']       = $ShiftTime->data->shiftName;
                    $success['startTime']       = $ShiftTime->data->startTime;
                    $success['endTime']         = $ShiftTime->data->endTime; 
                    $success['punchInBtnTime']  = $ShiftTime->data->punchInBtnTime; 
                    $success['punchOutBtnTime'] = $ShiftTime->data->punchOutBtnTime;  
                }else{
                    $success['shiftname'] = 'Shift Not Yet Allocated';  
                }
                
                $success['token'] =  $user->createToken('MyApp')->accessToken; 
                return response()->json(['success' => $success], $this->successStatus); 
            } 
            else{ 
                return response()->json(['error'=>'Invalid UserName or Password'], 401); 
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
    

    /* Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        try {
             $validator = Validator::make($request->all(), [ 
                'firstName' => 'required',
                'lastName' => 'required', 
                'email' => 'required|email', 
                'password' => 'required', 
                'mobile' => 'required', 
                'gender' => 'required', 
                'DOB' => 'required', 
                'role' => 'required', 
                //'c_password' => 'required|same:password', 
            ]);
            if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }
            $input = $request->all(); 
            $input['password'] = bcrypt($input['password']); 

            $input['status'] =  'A'; 
            $input['role'] =  $input['role'] ? $input['role'] : 2;
            $input['effectiveFrom'] =  Carbon::now();
            $input['effectiveTo'] =  '9999-12-31';
            $input['createdBy'] =  '0'; 
            $input['createdOn'] =  Carbon::now();                     
            
            $user = User::create($input); 

            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['name'] =  $user->firstName.' '.$user->lastName;

            return response()->json(['success'=> true], $this->successStatus); 
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

    /* Setup shift time for user 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function addUserShift(Request $request) 
    { 
        try {
             $validator = Validator::make($request->all(), [ 
                'userId' => 'required',
                'shiftId' => 'required', 
            ]);
            if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }
            $input = $request->all(); 
            $input['status'] =  'A'; 
            $input['effectiveFrom'] =  Carbon::now();
            $input['effectiveTo'] =  '9999-12-31';
            $input['createdBy'] =  '0'; 
            $input['createdOn'] =  Carbon::now();                     
            
            $shifttimewithusers = ShiftTimeWithUsers::create($input);            

            return response()->json(['success'=> true], $this->successStatus); 
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

    /* Logout api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function logout(Request $request)
    {       
        Auth::logout();

        $success['message'] = 'logged out success'; 
        return response()->json(['success'=> $success], $this->successStatus); 
    }
    public function index()
    {
        $users = User::all();
        return view('users', compact('users'));
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Roles;
use App\Models\ShiftTimeWithUsers;
use App\Models\ShiftTime;

use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

use App\Http\Controllers\ShiftTimeController;
use Config;
use DB;
use Illuminate\Support\Facades\File;
use Session;
use URL;

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
                $currentTime = Carbon::now();
                $ShiftTime = (new ShiftTimeController)->getUserShiftTime($userId); 
                $ShiftTime = $ShiftTime->getData();
               
                if( $ShiftTime->success == true ){                 
                    $success['shiftname']       = $ShiftTime->data->shiftName;
                    $success['startTime']       = $ShiftTime->data->startTime;
                    $success['endTime']         = $ShiftTime->data->endTime; 
                    $success['currentTime']     = $currentTime->format('Y-m-d h:i:s');
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

            $input['status'] =  $input['status'] ? $input['status'] : 'A'; 
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
            
            $hasshifttimewithusers = ShiftTimeWithUsers::where('userId', $input['userId'])
                ->where('shiftId', $input['shiftId'])
                ->get();

            if( $hasshifttimewithusers->count() > 0 ){	
                $shiftData['message'] = 'Shift Already Associated to this user';
                return response()->json(['success'=> false, 'data' => $shiftData], $this->successStatus); 
            }else{
                $shifttimewithusers = ShiftTimeWithUsers::create($input);
                $shiftData['message'] = 'Shift Associated Successfully to this user';
                return response()->json(['success'=> true, 'data' => $shiftData], $this->successStatus);  
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

    /* 
    * Web View 
    * Get All Users List
    */
    public function index()
    {
        $currentTime = Carbon::now();  

        $attendance = DB::table('attendance')
        ->select(            
            'userId',  
            'attandanceId',
            'startDate',
            'startTime',
            'endTime',
            'imageUrl'           
        )        
        ->where('startDate', '=',  $currentTime->toDateString())
        ->orderBy('userId', 'asc')
        ->get(); 
           
       $users = DB::table('users as u')
        ->select(
            'u.*',
            'a.userId as uid',  
            'a.attandanceId',
            'a.startDate',
            'a.startTime',
            'a.endTime',
            'a.imageUrl',
            's.shiftId as shid',
            'su.shiftId as suid',
            's.shiftName', 
        )
        ->leftJoin('attendance as a', 'a.userId', '=', 'u.userId') 
        ->leftJoin('shifttimewithusers as su', 'su.userId', '=', 'u.userId') 
        ->leftJoin('shifttime as s', 's.shiftId', '=', 'su.shiftId') 
        ->groupBy('u.userId') 
        ->groupBy('a.userId') 
         ->orderBy('u.userId', 'asc')
        ->paginate(20); 
        return view('admin.users', compact('users', 'attendance'));
    }

    public function getFullNameAttribute($firstname, $lastname, $format='capital' )
    {
        if( $format == 'capital' ){
            $fullname = ucfirst($firstname) . ' ' . ucfirst($lastname);
        }
        else if( $format == 'upper' ){
            $fullname = strtoupper($firstname) . ' ' . strtoupper($lastname);
        }
        else if( $format == 'lower' ){
            $fullname = strtolower($firstname) . ' ' . strtolower($lastname);
        }
        else if( $format == 'slug' ){
            $fullname = strtolower($firstname).'-' .strtolower($lastname);
            $fullname = str_replace(' ', '-', $fullname);
        }else{
            $fullname = $firstname .' ' .$lastname;
        }
        return trim($fullname);
    }

    public function getUserById(string $userId)
    {    
        try {
            if($userId != NULL || $userId != ''){           
                $users = User::where('userId', $userId)->first();
                return response()->json(['success'=> true, 'data' => $users ], $this->successStatus);
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $roles = Roles::all();  
        return view('admin.create-user', compact('roles'));
    }

    public function store(Request $request)
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
                return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
            }
            $input = $request->all(); 
            $input['password'] = bcrypt($input['password']); 

            $input['status'] =  $input['status'] ? $input['status'] : 'A'; 
            $input['role'] =  $input['role'] ? $input['role'] : 2;
            $input['effectiveFrom'] =  Carbon::now();
            $input['effectiveTo'] =  '9999-12-31';
            $input['createdBy'] =  '0'; 
            $input['createdOn'] =  Carbon::now();                     
            
            $user = User::create($input); 

            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['name'] =  $user->firstName.' '.$user->lastName; 
            
            return redirect()->back()->with('success', 'User '. $success['name'] .' created successfully'); 
        }
        catch (\Throwable $exception) {
            return redirect()->back()->withErrors( json_encode($exception->getMessage(), true) )->withInput($request->input());
        } catch (\Illuminate\Database\QueryException $exception) {
            return redirect()->back()->withErrors( json_encode($exception->getMessage(), true) )->withInput($request->input());
        } catch (\PDOException $exception) {
            return redirect()->back()->withErrors( json_encode($exception->getMessage(), true) )->withInput($request->input());
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors( json_encode($exception->getMessage(), true) )->withInput($request->input());
        }      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createUserShift(string $userId)
    {
        $shifts = ShiftTime::all();
        $user = User::where('userId', $userId)->get(['userId', 'firstName', 'lastName']);
        return view('admin.create-user-shift', compact('shifts', 'user'));
    }

    public function storeUserShift(Request $request)
    {   
        try {
            
            $validator = Validator::make($request->all(), [ 
                'userId' => 'required',
                'shiftId' => 'required', 
            ]);
            if ($validator->fails()) {   
                return redirect()->back()->withErrors($validator->errors())->withInput($request->input());       
            }
            $input = $request->all(); 
            $input['status'] =  'A'; 
            $input['effectiveFrom'] =  Carbon::now();
            $input['effectiveTo'] =  '9999-12-31';
            $input['createdBy'] =  '0'; 
            $input['createdOn'] =  Carbon::now();  

            $hasshifttimewithusers = ShiftTimeWithUsers::where('userId', $input['userId'])                
                ->get();

            if( $hasshifttimewithusers->count() > 0 ){	
                return redirect()->back()->with('success', 'Shift Already Associated to this user'); 
            }else{
                $shifttimewithusers = ShiftTimeWithUsers::create($input);
                return redirect()->back()->with('success', 'Shift Associated Successfully to this user');  
            }              
        }
        catch (\Throwable $exception) {
            return redirect()->back()->withErrors( json_encode($exception->getMessage(), true) )->withInput($request->input());
        } catch (\Illuminate\Database\QueryException $exception) {
            return redirect()->back()->withErrors( json_encode($exception->getMessage(), true) )->withInput($request->input());
        } catch (\PDOException $exception) {
            return redirect()->back()->withErrors( json_encode($exception->getMessage(), true) )->withInput($request->input());
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors( json_encode($exception->getMessage(), true) )->withInput($request->input());
        }      
    }  



    /**
     * @return User Profile data
     */
    public function profile(string $userId)
    {
        try {
            if($userId != NULL || $userId != ''){
                
                $userData = DB::table('users as u')
                    ->select(
                        'u.userId',
                        'u.firstName',
                        'u.lastName', 
                        'u.email',
                        //'password',
                        'u.mobile',
                        'u.gender',
                        'u.DOB',
                        'u.role as roleId',
                        'r.name as roleName',
                        'r.description as roleDescription'
                    ) 
                    ->leftJoin('roles as r', 'r.roleId', '=', 'u.role') 
                    ->where('u.userId', $userId)->first();   
                    
                if($userData){
                    return response()->json(['success'=> true, 'data' => $userData], $this->successStatus);
                } else{
                    return response()->json(['success'=> false, 'message' => 'No Records Found'], $this->successStatus);     
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

    /**
     * @return User Profile data
     */
    public function editProfile(Request $request, $userId)
    {
        try {
            if (!empty($userId)){ 
                $validator = Validator::make($request->all(), [ 
                    //'userId'  => 'required', // hidden type
                    'firstName' => 'required',
                    'lastName' => 'required', 
                    'email' => 'required|email', 
                    'password' => 'required|confirmed|min:4', 
                    'password_confirmation' => 'required|min:4', 
                    'mobile' => 'required', 
                    'gender' => 'required', 
                    'DOB' => 'required'                            
                ]);
                if ($validator->fails()) { 
                    return response()->json(['error'=>$validator->errors()], 401);   
                }
                $input = $request->all(); 
                 // $userId = $input['userId'];           

                // reqired    
                $updatedata['firstName'] = $input['firstName']; 
                $updatedata['lastName'] = $input['lastName']; 
                $updatedata['email'] = $input['email']; 
                $updatedata['mobile'] = $input['mobile']; 
                $updatedata['gender'] = $input['gender'];             
                $updatedata['DOB'] = $input['DOB']; 
                $updatedata['password'] = bcrypt($input['password']); 

                // recommended
                if( isset($input['role']) ){
                    $updatedata['role'] = $input['role']; 
                } 
                if( isset($input['roleDescription']) ){
                    $updatedata['roleDescription'] = $input['roleDescription']; 
                }           
                    
                $updateUser = User::where('userId', $userId)->update($updatedata);   
                        
                if($updateUser){
                    return response()->json(['success'=> true, 'message' => 'Profile Updated Successfully'], $this->successStatus);
                } else{
                    return response()->json(['success'=> false, 'message' => 'Profile not Updated'], $this->successStatus);     
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

}

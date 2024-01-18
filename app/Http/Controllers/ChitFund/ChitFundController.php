<?php

namespace App\Http\Controllers\ChitFund;
use App\Http\Controllers\Controller;

use App\Models\ChitFund\ChitFund_Scheme; 
use App\Models\ChitFund\ChitFund_Users;
use App\Models\ChitFund\ChitFund_Dues;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth; 
use Validator;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Config;
use DB;
use Illuminate\Support\Facades\File;
use Session;
use URL;

class ChitFundController extends Controller
{
    public $successStatus = 200;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function chitfundIndex()
    {       
        $schemes = ChitFund_Scheme::all();
        return view('admin.chitfund.index', compact('schemes'));
    }

    public function chitfundCreatePlan(Request $request)
    { 
       // return redirect()->back()->withErrors('Eror');
       // return redirect()->back()->with('success', 'Plan is created successfully'); 
        try {
            $validator = Validator::make($request->all(), [ 
                'plan_name' => 'required',
                'plan_amount' => 'required', 
                'start_date' => 'required', 
                'end_date' => 'required',
                'start_date_submit' => 'required',
                'end_date_submit' => 'required'               
            ]);
            if ($validator->fails()) { 
                return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
            }
            $input = $request->all(); 
            $input['start_date'] = Carbon::parse( $input['start_date_submit'] );
            $input['end_date'] = Carbon::parse( $input['end_date_submit'] );
            $input['createdOn'] =  Carbon::now(); 

            unset($input['start_date_submit']);
            unset($input['end_date_submit']);           
            
            $scheme = ChitFund_Scheme::create($input); 
            
            return redirect()->back()->with('success', 'Plan '.$input['plan_name'].' created successfully'); 
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

    public function chitfundShowPlan(Request $request, string $id)
    { 
        DB::enableQueryLog();
        $currentTime = Carbon::now();
        $users = DB::table('chitfund_scheme as s')
            ->where('s.plan_id', '=', $id)	
            //->whereMonth('d.due_date_paid', '=', $currentTime->month)	
            ->select( 'u.user_id', 'u.user_name', 'u.mobile_no', 'u.address', 'u.plan_id as uplan_id', 's.plan_id', 's.plan_name', 's.start_date', 's.end_date')          	
            ->leftJoin('chitfund_users as u', 'u.plan_id', '=', 's.plan_id') 
            //->leftJoin('chitfund_dues as d', 'd.user_id', '=', 'u.user_id') 
            //->orderBy('d.due_id', 'DESC')									
            //->groupBy('d.due_id')	
            
            ->get();     

            //dd(DB::getQueryLog());

            //dd($users);
        return view('admin.chitfund.users', compact('users'));    
    }


    public function chitfundCreateUser(Request $request)
    {     
        try {
            $validator = Validator::make($request->all(), [ 
                'user_name' => 'required',
                'mobile_no' => 'required', 
                'address' => 'required', 
                'plan_id' => 'required',                 
            ]);
            if ($validator->fails()) { 
                return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
            }
            $input = $request->all();             
            $input['createdOn'] =  Carbon::now();                     
            
            $scheme = ChitFund_Users::create($input); 
            
            return redirect()->back()->with('success', 'User '.$input['user_name'].' added successfully'); 
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

    public function isDuePaid(string $id)
    {
        try {
            if($id != NULL || $id != ''){
                $currentTime = Carbon::now();

                $dues = ChitFund_Dues::where('user_id', $id)
                ->whereMonth('due_date_paid', '=', $currentTime->month)
                ->whereYear('due_date_paid', '=', $currentTime->year)
                ->get();

                if( $dues->count() > 0 ){
                    return response()->json(['success'=> true], $this->successStatus);
                } else{
                    return response()->json(['success'=> false], $this->successStatus);
                }
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

    public function chitfundAddDue(Request $request, string $planid, string $id)
    {
        try {
           
            if ( empty($planid) && empty($id) ){   
                return redirect()->back()->withErrors('Invalid UserId or PlanId');
            }
                       
            $currentTime = Carbon::now();                
            
            $isDuePaid = $this->isDuePaid($id);
            $isDuePaid = $isDuePaid->getData(); 

            if( $isDuePaid->success == true ){	           
                return redirect()->back()->with('success', 'User #'.$id.' already paid due for this month '.$currentTime->format('M-Y')); 
            }
            
            $input['user_id'] =  $id;  
            $input['plan_id'] =  $planid;  
            $input['due_status'] = 1;
            $input['due_date_paid'] =  $currentTime;
            $input['createdOn'] =  $currentTime;
            
            $dues = ChitFund_Dues::create($input); 
            
            return redirect()->back()->with('success', 'User #'.$id.' due paid success'); 
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
    
    public function chitfundUserDetails(Request $request, string $id)
    { 
        $user = DB::table('chitfund_dues as d')
            ->where('d.user_id', '=', $id)	
            ->select( 'u.user_name', 'd.user_id', 'd.plan_id', 'd.due_status', 'd.due_date_paid' )          	
            ->Join('chitfund_users as u', 'u.user_id', '=', 'd.user_id')  
            ->orderBy('d.due_id', 'DESC')	         
            ->get();

           // dd($users);
        return view('admin.chitfund.user-details', compact('user'));    
    }
   
    public static function getDueStatus($id, $key)
    { 
        $status = array( 0 => 'Un-Paid', 1 => 'Paid', 2 => 'Closed' );

        if( $key == 'array' ) { 
            $due_status = $status;
        }
        else if( ($id != '' || $id != NULL) && $key == 'string' ) {            
            $due_status = $status[$id];
        } else {
            $due_status = $status[0];
        }
        
        return $due_status;
    }

    public static function getUserDueStatus(string $id)
    {
        $result = array('success'=> false);

        if($id != NULL || $id != ''){
            $currentTime = Carbon::now();

            $dues = ChitFund_Dues::where('user_id', $id)
            ->whereMonth('due_date_paid', '=', $currentTime->month)
            ->whereYear('due_date_paid', '=', $currentTime->year)
            ->get();

            if( $dues->count() > 0 ){
                $result = array('success'=> true);
            } 
        }  
        return $result;
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

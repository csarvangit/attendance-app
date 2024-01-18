<?php

namespace App\Http\Controllers\ChitFund;
use App\Http\Controllers\Controller;

use App\Models\ChitFund\ChitFund_Scheme; 
use App\Models\ChitFund\ChitFund_Users;
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
            ]);
            if ($validator->fails()) { 
                return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
            }
            $input = $request->all(); 
            $input['start_date'] = Carbon::parse( $input['start_date'] );
            $input['end_date'] = Carbon::parse( $input['end_date'] );
            $input['createdOn'] =  Carbon::now();                     
            
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
        $users = DB::table('chitfund_scheme as s')
            ->where('s.plan_id', '=', $id)	
            ->select( 'u.user_id', 'u.user_name', 'u.mobile_no', 'u.address', 'u.plan_id as uplan_id', 's.plan_id', 's.plan_name', 's.start_date', 's.end_date' )          	
            ->leftJoin('chitfund_users as u', 'u.plan_id', '=', 's.plan_id') 									
            //->groupBy('u.plan_id')	
            ->paginate(10);

           // dd($users);
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

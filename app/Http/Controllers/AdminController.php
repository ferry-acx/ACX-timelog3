<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Breaklog;
use App\Models\Config;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard(){

        $core = Attendance::whereNull('time_out')
            ->whereHas('user', function ($query) {
                $query->where('division','core');
            })->count();
        $relevate = Attendance::whereNull('time_out')
            ->whereHas('user', function ($query) {
                $query->where('division','relevate');
            })->count();
        $publishing = Attendance::whereNull('time_out')
            ->whereHas('user', function ($query) {
                $query->where('division','publishing');
            })->count();
        //Work from Home (WFH) On-site
        $onsite = Attendance::whereNull('time_out')
            ->where('location','On-site')
            ->count();
        $wfh = Attendance::whereNull('time_out')
            ->where('location','Work from Home (WFH)')
            ->count();
        $online = Attendance::whereNull('time_out')
            ->where('status','online')
            ->count();
        $onbreak = Attendance::whereNull('time_out')
            ->where('status','break')
            ->count();

        $attendances = Attendance::whereNull('time_out')->orderBy('time_in','desc')->take(10)->get();

        return view('admin.dashboard' , compact('attendances', 'core','relevate','publishing','onsite','wfh','online','onbreak'));
    }

    public function realtimeDashboard(){
         $core = Attendance::whereNull('time_out')
            ->whereHas('user', function ($query) {
                $query->where('division','core');
            })->count();
        $relevate = Attendance::whereNull('time_out')
            ->whereHas('user', function ($query) {
                $query->where('division','relevate');
            })->count();
        $publishing = Attendance::whereNull('time_out')
            ->whereHas('user', function ($query) {
                $query->where('division','publishing');
            })->count();
        //Work from Home (WFH) On-site
        $onsite = Attendance::whereNull('time_out')
            ->where('location','On-site')
            ->count();
        $wfh = Attendance::whereNull('time_out')
            ->where('location','Work from Home (WFH)')
            ->count();
        $online = Attendance::whereNull('time_out')
            ->where('status','online')
            ->count();
        $onbreak = Attendance::whereNull('time_out')
            ->where('status','break')
            ->count();

        return response()->json([
            'core' => $core,
            'relevate' => $relevate,
            'publishing' => $publishing,
            'onsite' => $onsite,
            'wfh' => $wfh,
            'online' => $online,
            'onbreak' => $onbreak,
        ]);
    }

    public function timelogs(){

        $current_attendances = Attendance::whereNull('time_out')->get();
        $previous_timelogs = Attendance::whereNotNull('time_out')->get();

        return view('admin.timelogs', compact('current_attendances','previous_timelogs'));
    }

    public function eod(){

        $attendances = Attendance::all();

        return view('admin.eod', compact('attendances'));
    }

    public function daterange(Request $request){
        // $attendances = Attendance::whereNotNull('time_out')->whereBetween('time_in', [$request->startdate, $request->enddate])->get();

        $attendances = Attendance::whereBetween('attendances.time_in', [$request->input('startdate'), $request->input('enddate')])
            ->orderBy('id', 'desc')
            ->get();


        $range = [
            'start' => $request->input('startdate'),
            'end' => $request->input('enddate')
        ];
        // return response()->json($responseData);

        if(isset($request)){

            return view ('admin.eod', compact('attendances', 'range'));
        } else {
            return route('admin.eod');
        }

    }

    public function breaklogs(Request $request, $id){
        $attendance = Attendance::find($id);
        $user_info = $attendance->user;
        $breaklogs = $attendance->breaklogs;

        $responseData = [
            'user_info' => $user_info,
            'attendance' => $attendance,
            'breaklogs' => $breaklogs
        ];

        return response()->json($responseData);
    }

    public function tasklogs(Request $request, $id){
        $attendance = Attendance::find($id);
        $user_info = $attendance->user;
        $tasklogs = $attendance->tasklogs;

        $responseData = [
            'user_info' => $user_info,
            'attendance' => $attendance,
            'tasklogs' => $tasklogs
        ];

        return response()->json($responseData);
    }

    public function updateAssessment( Request $request ){

        $data = $request->all();

        $attendance = Attendance::findOrFail($data['id']);
        $attendance->assessment = $data['assessment'];
        $attendance->save();

        return response()->json(['message' => 'Assessment saved successfully']);

    }

    public function hoursRendered(){


        $users = User::all();
        $attendances = Attendance::whereNotNull('time_out')->get();
        //$attendances = DB::select("SELECT attendances.id,concat(users.first_name,' ',users.last_name) as name, attendances.time_in, attendances.time_out, SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(break_logs.break_end,break_logs.break_start)))) as total_break FROM `attendances` Left join break_logs on break_logs.attendance_id=attendances.id join users on attendances.user_id=users.id GROUP BY attendances.id,name,time_in,time_out order by total_break desc");

        return view('admin.reports', compact('attendances','users'));

    }

    public function reportsDateRange( Request $request ){

        $result = DB::select("SELECT attendances.id,concat(users.first_name,' ',users.last_name) as name, attendances.time_in, attendances.time_out, TIMEDIFF(attendances.time_out,attendances.time_in) as rendered, SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(break_logs.break_end,break_logs.break_start)))) as total_break,TIMEDIFF(TIMEDIFF(attendances.time_out,attendances.time_in),SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(break_logs.break_end,break_logs.break_start))))) as net_time FROM `attendances` Left join break_logs on break_logs.attendance_id=attendances.id join users on attendances.user_id=users.id where attendances.time_in between ? and ? and attendances.time_out is not null group by attendances.id, users.first_name, users.last_name, attendances.time_in, attendances.time_out", [$request->startdate, $request->enddate]);


        $responseData = [
            'attendances' => $result
        ];
        return response()->json($responseData);
    }

    public function hoursByEmployee(Request $request){

        $attendances = DB::table('attendances')
            ->select('attendances.time_in', 'attendances.time_out')
            ->whereBetween('attendances.time_in', [$request->startdate, $request->enddate])
            ->whereNotNull('attendances.time_out')
            ->where('user_id',$request->user_id)
            ->get();

        $breaks = DB::table('break_logs')
            ->select('attendances.user_id','break_logs.break_start', 'break_logs.break_end')
            ->join('attendances','attendances.id','break_logs.attendance_id')
            ->whereBetween('attendances.time_in', [$request->startdate, $request->enddate])
            ->whereNotNull('attendances.time_out')
            ->where('attendances.user_id',$request->user_id)
            ->get();

        $responseData = [
            'attendances' => $attendances,
            'breaks' => $breaks
        ];
        return response()->json($responseData);

    }

    public function employees(){

        $users = User::all();
        $positions = User::distinct()->get(['position']);

        return view('admin.employees', compact('users','positions'));
    }

    public function getEmployee(Request $request){

        $user = User::find($request->user_id);

        $responseData = [
            'user' => $user
        ];
        return response()->json($responseData);
    }

    public function editEmployee( Request $request){

        
        $user = User::findOrFail($request->input('user_id'));
        $oldEmpID = $user->employee_id;
        $user->employee_id = $request->input('emp_id');
        $user->first_name = $request->input('emp_fname');
        $user->last_name = $request->input('emp_lname');
        $user->division = $request->input('emp_department');
        $user->position = $request->input('emp_position');
        $user->role = $request->input('emp_role');
        
        $isExistEmpID = User::where('employee_id',$request->input('emp_id'))
            ->whereNot('employee_id', $oldEmpID)
            ->count(); 
        
        if($isExistEmpID){
            
            return redirect()->route('admin.employees')->with('not_updated', 'Employee not updated');
        } else{
            
            $user->save();
            return redirect()->route('admin.employees')->with('updated', 'Employee updated');
        }
    }

    public function addEmployee( Request $request){
        
        $isExistEmpID = User::where('employee_id',$request->input('emp_id'))
            ->count(); 
        
        if($isExistEmpID){
            
            return redirect()->route('admin.employees')->with('not_added', 'Employee not added!');
        } else{
            
            
            $user =  User::create([
                'employee_id' => $request->input('emp_id'),
                'username' => $request->input('emp_id'),
                'first_name' => $request->input('emp_fname'),
                'last_name' => $request->input('emp_lname'),
                'position' => $request->input('emp_position'),
                'role' => $request->input('emp_role'),
                'division' => $request->input('emp_department'),
                'password' => Hash::make($request->input('emp_id')),
            ]);
    
            return redirect()->route('admin.employees')->with('added', 'Employee Has Been Added Successfully');
        }


    }

    public function deleteEmployee(Request $request){

        $employee = User::where('id', $request->user_id )->delete();
        if($employee){

            return response()->json([
                'message' => 'deleted'
            ]);
        } else {
            return response()->json([
                'message' => 'not deleted'
            ]);
        }

    }

    public function resetLogin(Request $request){

        $user = User::findOrFail($request->user_id);
        // $user->username = $user->employee_id;
        $user->password = Hash::make($user->employee_id);

        if($user->save()){

            return response()->json([
                'message' => 'success'
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function profile(){

        $positions = User::distinct()->get(['position']);
        return view('admin.profile', compact('positions') );
    }

    public function saveProfile(Request $request){

        $user = User::findOrFail($request->input('user_id'));
        $user->employee_id = $request->input('emp_id');
        $user->first_name = $request->input('fname');
        $user->last_name = $request->input('lname');
        $user->division = $request->input('department');
        $user->position = $request->input('position');
        // $user->role = $request->input('role');
        $user->username = $request->input('username');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        
        $isExistEmpID = User::where('employee_id',$request->input('emp_id'))
            ->whereNot('employee_id', Auth::user()->employee_id)
            ->count(); 
        
        $isExist = User::where('username',$request->input('username'))
            ->whereNot('username', Auth::user()->username)
            ->count();
        
        if($isExist || $isExistEmpID){
            return redirect()->route('admin.profile')->with('not_updated', 'Profile not updated');
        } else{
            
            $user->save();
            return redirect()->route('admin.profile')->with('updated', 'Profile updated');
        }

    }

    public function config(){

        $configs = Config::all();

        return view('admin.config', compact('configs'));
    }

    public function saveConfig(Request $request){
        $config = Config::where('name',$request->name)->first();

        if($config){
            $config->value = $request->value;

            $config->save();
            return response()->json([
                'message' => 'success'
            ]);
        } else {

            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function tasks(){

        $users = User::all();
        $attendances = Attendance::all();

        return view('admin.tasks', compact('attendances','users'));
    }

}


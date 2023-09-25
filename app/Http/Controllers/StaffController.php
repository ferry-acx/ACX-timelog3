<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Tasklog;
use App\Models\Breaklog;
use App\Models\Config;
use App\Models\Pod;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function dashboard(){
        $attendance = Attendance::where('user_id',Auth::user()->id)
            ->orderBy('id','desc')
            ->first();
        $prevlogs = Attendance::where('user_id',Auth::user()->id)
            ->whereNotNull('time_out')
            ->orderBy('id','desc')
            ->limit(5)
            ->get();
        $projects = Tasklog::distinct()->get(['project']);

        return view('staff.dashboard', compact('attendance','prevlogs','projects'));
    }

    public function setStatus(Request $request){
        $attendance = Attendance::findOrFail($request->attendance_id);
        $attendance->status = $request->status;
        $break_count = Breaklog::where('attendance_id',$request->attendance_id)->count();
        $break = Breaklog::where('attendance_id',$request->attendance_id)
            ->orderBy('id','desc')
            ->limit(1)
            ->get();

        if($break_count){
            if($break[0]->break_end==null){
                $break_end = Breaklog::findOrFail($break[0]->id);
                $break_end->break_end = now();
                $break_end->save();
            } else{
                $break_start =  Breaklog::create([
                    'attendance_id' => $request->attendance_id,
                    'break_start' => now()
                ]);
            }
        } else{
            $break_start =  Breaklog::create([
                'attendance_id' => $request->attendance_id,
                'break_start' => now()
            ]);
        }

        $breaklogs = Breaklog::where('attendance_id',$request->attendance_id)
            ->whereNotNull('break_end')
            ->get();

        if($attendance->save()){

            return response()->json([
                'message' => 'success',
                'breaklogs' => $breaklogs
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function timeIn(Request $request){

        $name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $discord_message =" ▬▬▬▬▬▬▬▬▬▬ \n📌 **".strtoupper($name)."** has `logged in`\n\n**Goals Set for the Day**\n";

        $attendance =  Attendance::create([
            'user_id' => Auth::user()->id,
            'time_in' => now(),
            'goal_tasks' => json_encode($request->input('goals')),
            'location' => $request->input('location')
        ]);

        $tasks = $request->input('goals');

        foreach ($tasks as $item) {
            $discord_message .= "- $item \n";
        }

        // DISCORD

        try{

            $discord_url = Config::where('name','discord_timein')->first();

             // Discord webhook URL
            $webhookUrl = $discord_url->value;

            // Create message
            $message = $discord_message;

            // Prepare data
            $data = array(
                "content" => $message
            );

            // Send POST request to Discord webhook
            $options = array(
                "http" => array(
                    "header" => "Content-Type: application/json",
                    "method" => "POST",
                    "content" => json_encode($data)
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents($webhookUrl, false, $context);
        } catch (Exception $e){

        }

        return redirect()->route('staff.dashboard')->with('timein', 'You successfully timed in');
    }

    public function timeOut(Request $request){

        $name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $discord_message =" ▬▬▬▬▬▬▬▬▬▬ \n📌 **".strtoupper($name)."** has `logged out`\n\n";

        $i = 0;
        foreach($request->input('projects')as $project){

            $discord_message .= "**$project** \n" ;
            $tasks = $request->input('tasks_'.$i);

            foreach ($tasks as $item) {
                $discord_message .= "- $item \n";
            }

            $tasklog = Tasklog::create([
                'attendance_id' => $request->input('attendance_id'),
                'project' => $project,
                'tasks' => json_encode($request->input('tasks_'.$i))
            ]);
            $discord_message .="\n";
            $i++;
        }

         //Log::info('DATA: '.json_encode($request->all()));

        $attendance = Attendance::findOrFail($request->input('attendance_id'));
        $attendance->time_out = now();
        $attendance->status = 'out';
        $attendance->save();

        // DISCORD

        try{

            $discord_url = Config::where('name','discord_timeout')->first();

             // Discord webhook URL
            $webhookUrl = $discord_url->value;

            // Create message
            $message = $discord_message;

            // Prepare data
            $data = array(
                "content" => $message
            );

            // Send POST request to Discord webhook
            $options = array(
                "http" => array(
                    "header" => "Content-Type: application/json",
                    "method" => "POST",
                    "content" => json_encode($data)
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents($webhookUrl, false, $context);
        } catch (Exception $e){

        }
        
        try{
            
          $last_attendance = Attendance::where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($last_attendance) {
                $last_break = $last_attendance->breaklogs->last();
            
                if ($last_break && $last_break->break_end === null) {
                    $last_break->break_end = now();
                    $last_break->save();
                }
            }
            
        }catch (Exception $e){}


        return redirect()->route('staff.dashboard')->with('timeout', 'You successfully timed out');
    }

    public function tracker(){

        $attendances = Attendance::where('user_id', Auth::user()->id)
            ->whereNotNull('time_out')
            ->get();

        return view('staff.tracker',compact('attendances'));
    }

    public function trackerDateRange( Request $request ){

        $result = DB::select("SELECT attendances.id, attendances.time_in, attendances.time_out, TIMEDIFF(attendances.time_out,attendances.time_in) as rendered, SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(break_logs.break_end,break_logs.break_start)))) as total_break,TIMEDIFF(TIMEDIFF(attendances.time_out,attendances.time_in),SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(break_logs.break_end,break_logs.break_start))))) as net_time FROM `attendances` Left join break_logs on break_logs.attendance_id=attendances.id where user_id = ? and attendances.time_in between ? and ? and attendances.time_out is not null group by attendances.id, attendances.time_in, attendances.time_out", [Auth::user()->id, $request->startdate, $request->enddate]);


        $responseData = [
            'attendances' => $result
        ];
        return response()->json($responseData);
    }

    public function profile(){

        return view('staff.profile' );
    }

    public function saveProfile(Request $request) {

        $user = User::findOrFail(Auth::user()->id);
        $user->username = $request->input('username');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

         $isExist = User::where('username',$request->input('username'))
            ->whereNot('username', Auth::user()->username)
            ->count();

        if($isExist){
            return redirect()->route('staff.profile')->with('not_updated', 'Profile not updated');
        } else{

            $user->save();
            return redirect()->route('staff.profile')->with('updated', 'Profile updated');
        }

    }

    public function getInfo(Request $request){

        $attendances = Attendance::find($request->attendance_id);
        $breaklogs = Breaklog::where('attendance_id',$request->attendance_id)->get();
        $tasklogs = Tasklog::where('attendance_id',$request->attendance_id)->get();

        $responseData = [
            'attendances' => $attendances,
            'breaklogs' => $breaklogs,
            'tasklogs' => $tasklogs

        ];
        return response()->json($responseData);
    }

    public function addToPod(Request $request){

        $pod =  Pod::create([
            'pc_id' => Auth::user()->id,
            'member_id' => $request->input('member_id')
        ]);

        return redirect()->route('staff.mypod')->with('added','Employee added to pod');
    }

   
    public function mypod(){

        $member_ids = Pod::where('pc_id', Auth::user()->id)->pluck('member_id')->toArray();

        $employees = User::whereIn('division',['core','relevate','publishing'])
            ->whereNotIn('id',$member_ids)
            ->where('role','2')
            ->get();

        $members = User::whereIn('division',['core','relevate','publishing'])
            ->whereIn('id',$member_ids)
            ->where('role','2')
            ->get();

        $memberlogs = Attendance::whereIn('user_id',$member_ids)
                ->whereIn('id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
                ->from('attendances')
                ->groupBy('user_id');
        })->get();

        //Log::info('DATA: '.json_encode( $memberlogs ));

        return view('staff.mypod' , compact('employees', 'members', 'memberlogs'));
    }

    public function removeFromPod(Request $request){

        $member = Pod::where('pc_id', Auth::user()->id)
            ->where('member_id',$request->input('member_id'))
            ->delete();

        return redirect()->route('staff.mypod')->with('removed','Member was removed from pod!');


    }

    public function getLogs(Request $request){
        $attendances = Attendance::where('user_id', $request->id)->with('tasklogs')->get();
        $member = User::findOrFail($request->id);
        $responseData = [
            "attendances" => $attendances,
            "name" => $member->first_name
        ];

        return response()->json($responseData);
    }
    
    public function mypodRealtime(){

        $member_ids = Pod::where('pc_id', Auth::user()->id)->pluck('member_id')->toArray();

        $memberlogs = User::whereIn('id',$member_ids)->get();

        $responseData = [];

        foreach ($memberlogs as $user) {
            $userAttendance = [
                'id' => $user->id
                // Add other user properties as needed
            ];

            if ($user->attendances->isNotEmpty()) {
                $lastAttendance = $user->attendances->last();
                $userAttendance['status'] = $lastAttendance->status;
            } else {
                $userAttendance['status'] = null;
            }

            $responseData[] = $userAttendance;
        }

        return response()->json($responseData);
    }

}

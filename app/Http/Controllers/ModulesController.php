<?php
namespace App\Http\Controllers;
ini_set('memory_limit', '-1');

use Illuminate\Http\Request;
use DB;
use Mail;
use Carbon\Carbon;


class modulesController extends Controller
{
    
    public function getProgress(Request $request, $module) {
        $progress = DB::table('progress')
            ->join('users','progress.student_id', '=', 'users.id')
            ->join('modules','progress.module_id', '=', 'modules.id' )
            ->select('progress.id','progress.progress', 'users.email', 'modules.name')
            ->where('module_id','=', $module)
            ->get();
            return json_encode($progress);
    }

    public function getLagging(Request $request, $module) {
        $progress = DB::table('progress')
            ->join('users','progress.student_id', '=', 'users.id')
            ->join('modules','progress.module_id', '=', 'modules.id' )
            ->select('progress.id','progress.progress', 'users.email', 'modules.name')
            ->where('module_id','=', $module)
            ->where('progress','<', 45)
            ->get();

            return json_encode($progress);
    }

    public function contactLagging(Request $request, $module) {
        $progress = DB::table('progress')
            ->join('users','progress.student_id', '=', 'users.id')
            ->join('modules','progress.module_id', '=', 'modules.id' )
            ->select('progress.id','progress.progress', 'users.email', 'modules.name')
            ->where('module_id','=', $module)
            ->where('progress','<', 45)
            ->get();

            foreach ($progress as $row)
            {
                $data['email'] = $row->email;
                $data['name'] = $row->name;

                try {

                 Mail::send('mail', $data, function($message) use ($data) {
                        $message->to($data['email'], 'Where does this one go?')
                        ->subject
                        ('Low progress notification');
                        $message->from('mailmukundi@gmail.com','Admin Learning Management System');
                    });

                    $status["status"] = "successful";
                    $status["message"] = "Email sent successfully";
                    return json_encode($status);
                    }
                    catch (\Exception $e) {

                    return $e->getMessage();
                     }
                 }
             }

     public function contactAllLagging(Request $request, $module) {
        $progress = DB::table('progress')
            ->join('users','progress.student_id', '=', 'users.id')
            ->join('modules','progress.module_id', '=', 'modules.id' )
            ->select('progress.id','progress.progress', 'users.email', 'modules.name')
            ->where('progress','<', 45)
            ->where('end_date','>', Carbon::now())
            ->get();

            foreach ($progress as $row)
            {
                $data['email'] = $row->email;
                $data['name'] = $row->name;
                 try {
                     Mail::send('mail', $data, function($message) use ($data) {
                            $message->to($data['email'], 'Where does this one go?')
                            ->subject
                            ('Low progress notification');
                            $message->from('mailmukundi@gmail.com','Admin Learning Management System');
                        });

                $status["status"] = "successful";
                $status["message"] = "Email sent successfully";
                return json_encode($status);
            } catch (\Exception $e) { return $e->getMessage();}
        }
    }
}

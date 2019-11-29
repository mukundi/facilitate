<?php
namespace App\Http\Controllers;
ini_set('memory_limit', '-1');

use Illuminate\Http\Request;
use DB;
use Mail;


class modulesController extends Controller
{
    public function get(Request $request) {
    return response()->json([
        'modules' => [
             'id' => 1,
             'tile' => 'Introduction to data science'
    ], 200]);
    }
    
    
    public function getLagging(Request $request, $module) {
        //$progress = DB::select('select * from progress where progress < 45 and module_id = '.$module);
        $progress = DB::table('progress')
            ->join('users','progress.student_id', '=', 'users.id')
            ->join('modules','progress.module_id', '=', 'modules.id' )
            ->select('progress.id','progress.progress', 'users.email', 'modules.name')
            ->where('progress','<', 45)
            ->get();
        
        $data['email'] = $progress[0]->email;
        $data['name'] = $progress[0]->name;
        
        Mail::send(['text'=>'mail','name'=> $data['name']], $data, function($message) use ($data) {
         $message->to($data['email'], 'Where does this one go?')
             ->subject
            ('Low progress notification');
         $message->from('mailmukundi@gmail.com','Admin Learning Management System');   
        });
    }
    
}
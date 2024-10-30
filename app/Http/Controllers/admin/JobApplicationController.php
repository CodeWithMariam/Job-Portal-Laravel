<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplications;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(){
        $applications = JobApplications::orderBy('created_at','desc')
                        ->with('user','job','employer')
                        ->paginate(10);

           return view('admin.job-applications.list',[
                    'applications'=> $applications
           ]);
    }

    public function destroy(Request $request){

        $id = $request->id;
        $jobApplications = JobApplications::find($id);

        if($jobApplications == null){
            session()->flash('error','Either job application deleted or not found');
          return response()->json([
            'status'=> false
        ]);
        }

        $jobApplications->delete();

        session()->flash('success','Job application deleted successfully');

        return response()->json([
            'status'=> true
        ]);

    }
}

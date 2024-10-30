<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationEmail;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplications;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class JobsController extends Controller
{
    // this method will show jobs page
    public function index(Request $request){

     $categories = Category::where('status',1)->get();
     $jobTypes = JobType::where('status',1)->get();

     $jobs = Job::where('status',1);

     // search jobs using keyword
        if(!empty($request->keyword)){
            $jobs = $jobs->where(function($query) use($request){
                $query->orWhere('title','like','%'.$request->keyword.'%');
                $query->orWhere('keywords','like','%'.$request->keyword.'%');
            });
        }

         // search jobs using location
         if(!empty($request->location)){
            $jobs = $jobs->where('location',$request->location);
        }

        // search jobs using category
        if(!empty($request->category)){
            $jobs = $jobs->where('category_id',$request->category);
        }

        $jobTypeArray =[];
        // search jobs using job Type
        if(!empty($request->jobType)){
            // 1,2,3
            $jobTypeArray = explode(',', $request->jobType);
            $jobs = $jobs->whereIn('job_type_id',$jobTypeArray);
        }

         // search jobs using experience
         if(!empty($request->experience)){
            $jobs = $jobs->where('experience',$request->experience);
        }

     $jobs = $jobs->with('jobType');

        if($request->sort == '0'){
            $jobs = $jobs->orderBy('created_at', 'ASC');
        }else{
            $jobs = $jobs->orderBy('created_at', 'DESC');
        }

      $jobs = $jobs->paginate(9);

        return view('front.jobs',[
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs,
            'jobTypeArray' => $jobTypeArray
        ]);
    }

    public function detail($id){

        $job = Job::where(['id' => $id, 'status' => 1])->with('jobType', 'category')->first();

        if($job == null){
            abort(404);
        }

         // check if user already saved the job
         $countJob = 0;
         if(Auth::user()){
            $countJob = SavedJob::where([
                'job_id'=> $id,
                'user_id'=> Auth::user()->id
             ])->count();
         }

         // fetch applicants

         $applications = JobApplications::where('job_id', $id)->with('user')->get();
        //  dd($applicantions);


        return view('front.jobDetail',[
            'job' => $job,
            'countJob' => $countJob,
            'applications'=> $applications
        ]);
    }
    public function applyJob(Request $request){
         $id = $request->id;

         $job = Job::where('id', $id)->first();

         if($job == null){
            session()->flash('error','Job does not exist.');
            return response()->json([
                'status'=> false,
                'message'=> 'Job not found.'
            ]);
         };

         // you can not apply your own job
         $employer_id = $job->user_id;

         if($employer_id == Auth::user()->id){
            session()->flash('error','You can not apply your own job');
            return response()->json([
                'status'=> false,
                'message'=> 'You can not apply your own job'
            ]);
         };

         // you can not apply one job tewice
         $applicationCount = JobApplications::where([
            'job_id'=> $id,
            'user_id'=> Auth::user()->id
            ])->count();

         if($applicationCount > 0){
            session()->flash('error','You have already applied for this job.');
            return response()->json([
                'status'=> false,
                'message'=> 'You have already applied for this job.'
            ]);
         };


         // apply the job
         $application = new JobApplications();
         $application->job_id = $id;
         $application->user_id = Auth::user()->id;
         $application->employer_id = $employer_id;
         $application->applied_date = now();
         $application->save();


         // send notification email to employer
         $employer = User::where('id', $employer_id)->first();

         $mailData = [
             'employer' => $employer,
             'user' => Auth::user(),
             'job' => $job
         ];

         Mail::to($employer->email)->send(new JobNotificationEmail($mailData));

         session()->flash('success','Application submitted successfully.');
         return response()->json([
             'status'=> true,
             'message'=> 'Application submitted successfully.'
         ]);


    }

    public function savedJob(Request $request){

         $id = $request->id;

         $job = Job::find($id);

         if($job == null){
            session()->flash('error','Job not Found.');
            return response()->json([
             'status'=> false,
         ]);
         }

         // check if user already saved the job
         $countJob = SavedJob::where([
            'job_id'=> $id,
            'user_id'=> Auth::user()->id
         ])->count();

         if($countJob > 0){
            session()->flash('error','You have already saved this job.');
            return response()->json([
             'status'=> false,
         ]);
         }
         // save the job}
         $savedJob = new SavedJob;
         $savedJob->job_id = $id;
         $savedJob->user_id = Auth::user()->id;
         $savedJob->save();

         session()->flash('success','You have successfully saved this job.');
         return response()->json([
          'status'=> true,
      ]);
}
}

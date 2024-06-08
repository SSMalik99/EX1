<?php

namespace App\Http\Controllers;

use App\Mail\JobPosted;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $jobs = Job::all(); without eager loading
        // $jobs = Job::with('employer')->get(); // without pagination
        // $jobs = Job::with('employer')->paginate(); // with pagination
        // $jobs = Job::with('employer')->simplePaginate(); // with simple pagination   
        // $jobs = Job::with('employer')->cursorPaginate(10); // with cursonr pagination

        $jobs = Job::with('employer')->latest()->simplePaginate(); // with simple pagination   

        return view("jobs.index", [
            "jobs" => $jobs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("jobs.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:3'],
            'salary' => [ 'required',  ]
        ]);

        $job = Job::create([
            "title" => request("title"),
            "salary" => request("salary"),
            "employer_id" => random_int(1,10)
        ]);

        Mail::to($job->employer->user)->send(
            new JobPosted($job)
        );
    
        return redirect('/jobs');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        return view("jobs.show", ['job' => $job]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        // Moved to APP Service Provider
        // Gate::define('edit-job', function(User $user, Job $job){
        //     return $job->employer->user->is($user);
        // }); 


        if(Auth::guest()) {
            return redirect("/login");
        }
        
        // if ($job->employer->user->isNot(Auth::user())){
        //     abort(403);
        // }

        Gate::authorize('edit-job', $job);

        // Auth::user()->can('edit-job', $job);


        return view("jobs.edit", ['job' => $job]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        $request->validate([
            'title' => ['required', 'min:3'],
            'salary' => [ 'required',  ]
        ]);
    
        // authorize (on Hold...)
    
        // update the job
        // $job = Job::find($id);
        // $job = Job::findOrFail($id);
        
        // $job->title = request("title");
        // $job->salary = request("salary");
        // $job->save();
    
        $job->update([
            'title' => request("title"),
            "salary" => request('salary')
        ]);
        // and persist
        // redirect to job page
        return redirect("/jobs/".$job->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        // Authorize on hold
        // $job = Job::findOrFail($id)->delete();
        $job->delete();

        return redirect("/jobs");
    }
}

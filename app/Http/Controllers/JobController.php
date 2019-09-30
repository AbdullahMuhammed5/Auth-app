<?php


namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Job;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;


class JobController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Job::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Job::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'dashboard.jobs.ActionButtons')
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.jobs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('dashboard.jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param jobRequest $request
     * @return Response
     */
    public function store(jobRequest $request)
    {
        job::create($request->all());

        return redirect()->route('jobs.index')
            ->with('success', 'job created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param job $job
     * @return Response
     */
    public function show(Job $job)
    {
        return view('dashboard.jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param job $job
     * @return Response
     */
    public function edit(Job $job)
    {
        return view('dashboard.jobs.edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param jobRequest $request job $job
     * @param Job $job
     * @return Response
     */
    public function update(jobRequest $request, Job $job)
    {
        $job->update($request->all());
        return redirect()->route('jobs.index')
            ->with('success', 'Job updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param job $job
     * @return  Response
     * @throws Exception
     */
    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('jobs.index')
            ->with('error', 'Job deleted successfully');
    }
}

<?php


namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Job;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;


class JobController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Job::class);

        if ($request->ajax()) {
            $data = Job::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row){
                    return view('dashboard.jobs.ActionButtons', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.jobs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Job::class);
        return view('dashboard.jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param jobRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(jobRequest $request)
    {
        $this->authorize('create', Job::class);
        job::create($request->all());

        return redirect()->route('jobs.index')
            ->with('success', 'job created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param job $job
     * @return Response
     * @throws AuthorizationException
     */
    public function show(Job $job)
    {
        $this->authorize('view', $job);
        return view('dashboard.jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param job $job
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Job $job)
    {
        $this->authorize('update', $job);
        return view('dashboard.jobs.edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param jobRequest $request job $job
     * @param Job $job
     * @return Response
     * @throws AuthorizationException
     */
    public function update(jobRequest $request, Job $job)
    {
        $this->authorize('update', $job);
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
        $this->authorize('delete', $job);
        $job->delete();
        return redirect()->route('jobs.index')
            ->with('error', 'Job deleted successfully');
    }
}

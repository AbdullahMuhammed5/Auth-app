<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\EventRequest;
use App\Invited;
use App\Traits\UploadFile;
use App\Visitor;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class EventController extends Controller
{
    use UploadFile;

    public function __construct()
    {
        $this->authorizeResource(Event::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $columns = json_encode($this->getColumns());
        if ($request->ajax()) {
            $data = Event::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'dashboard.events.ActionButtons')
                ->addColumn('published', function($row){
                    return view('dashboard.events.toggleButton', compact('row'));
                })
                ->rawColumns(['action', 'published'])
                ->make(true);
        }
        return view('dashboard.events.index', compact('columns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('dashboard.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EventRequest $request
     * @return Response
     */
    public function store(EventRequest $request)
    {

        $inserted = Event::create($request->all());

        if ($visitors = $request['visitors']){
            $inserted->invitedVisitors()->createMany($this->getInputs($visitors, 'invited_id'));
        }
        if ($images = $request['images']){
            $inserted->images()->createMany($this->getInputs($images, 'path'));
        }
        if ($files = $request['files']){
            $inserted->files()->createMany($this->getInputs($files, 'path'));
        }
        return redirect()->route('events.index')
            ->with('success', 'Event created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param event $event
     * @return Response
     */
    public function show(Event $event)
    {
        return view('dashboard.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param event $event
     * @return Response
     */
    public function edit(Event $event)
    {
        $allVisitors = Visitor::active()
            ->with('user:id,first_name,last_name')->get()
            ->pluck('user.full_name', 'id');
        $invited = Invited::where('event_id', $event->id)->pluck('invited_id')->all();
        return view('dashboard.events.edit', compact('event', 'invited', 'allVisitors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EventRequest $request
     * @param event $event
     * @return Response
     */
    public function update(EventRequest $request, Event $event)
    {
        $event->update($request->all());

        if ($visitors = $request->visitors){
            $event->invitedVisitors()->delete(); // delete old invitedVisitors event
            $event->invitedVisitors()->createMany($this->getInputs($visitors, 'invited_id'));
        }
        if ($images = $request['images']){
            $event->images()->createMany($this->getInputs($images, 'path'));
        }
        if ($files = $request['files']){
            $event->files()->createMany($this->getInputs($files, 'path'));
        }
        return redirect()->route('events.index')
            ->with('success', 'event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     * @return  Response
     * @throws \Exception
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')
            ->with('error', 'Event deleted successfully');
    }

    // get columns for datatable.
    public function getColumns()
    {
        return [
            ['data' => 'id', 'name' => 'id'],
            ['data' => 'main_title', 'name' => 'main_title'],
            ['data' => 'secondary_title', 'name' => 'secondary_title'],
            ['data' => 'location', 'name' => 'location'],
            ['data' => 'content', 'name' => 'content'],
            ['data' => 'published', 'name' => 'published'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]
        ];
    }

    // get array of rows to be inserted for many relations (images, files, related event).
    public function getInputs($values, $fillableColumn){
        $inputs = [];
        foreach ($values as $value){
            array_push($inputs, [$fillableColumn => $value]);
        }
        return $inputs;
    }

    // publish event or un publish it
    public function togglePublishing(Event $event){
        $event->update(['published' => !$event->published ]);
    }

    // get related event based on search
    public function getInvited(Request $request){
        $term = trim($request['search']);

        if (empty($term)) {
            return \Response::json([]);
        }
//        $result = DB::table('visitors')
//            ->join('users', 'users.id', '=', 'visitors.user_id')
//            ->select(DB::raw("CONCAT(users.first_name,' ',users.last_name) as full_name"), 'visitors.id')
//            ->where('users.first_name', 'like', "%$term%")
//            ->orWhere('users.last_name', 'like', "%$term%")
//            ->get();

        $result = Visitor::whereHas('user' , function ($q) use ($term){
            $q->where('first_name', 'like', "%$term%")
                ->orWhere('last_name', 'like', "%$term%")
                ->select(DB::raw("CONCAT(first_name,' ',last_name) as full_name"));
        })->get();
        $result = $result->pluck("user.full_name", "id");

//        dd($result);

        $formatted_events = [];

        foreach ($result as $id => $name) {
            $formatted_events[] = ['id' => $id, 'text' => $name];
        }

        return \Response::json($formatted_events);
    }
}

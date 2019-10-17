<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\EventRequest;
use App\Traits\UploadFile;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
                ->addColumn('action', 'dashboard.event.ActionButtons')
                ->addColumn('published', function($row){
                    return view('dashboard.event.toggleButton', compact('row'));
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
        dd($request->all());

        $inserted = Event::create($request->all());

        if ($visitors = $request['visitors']){
            $inserted->related()->createMany($this->getInputs($visitors, 'visitor_id'));
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
        $allEvent = Event::where('published', 1)->pluck('main_title', 'id')->all();
        $relatedEvent = Related::where('event_id', $event->id)->pluck( 'related_id')->all();
        return view('dashboard.event.edit', compact('event', 'authors', 'relatedEvent', 'allEvent'));
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
        dd($request->all());
        $event->update($request->all());

        if ($request->related){
            $event->invitedVisitors()->delete(); // delete old invitedVisitors event
            $event->invitedVisitors()->createMany($this->getInputs($request->invitedVisitors, 'related_id'));
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
//    public function getInvited(Request $request){
//        $term = trim($request['search']);
//
//        if (empty($term)) {
//            return \Response::json([]);
//        }
//        $result = Event::where('main_title', 'like', "%$term%")->select('main_title', 'id')->get();
//        $formatted_event = [];
//
//        foreach ($result as $event) {
//            $formatted_event[] = ['id' => $event->id, 'text' => $event->main_title];
//        }
//
//        return \Response::json($formatted_event);
//    }
}

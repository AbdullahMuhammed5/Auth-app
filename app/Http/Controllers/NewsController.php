<?php


namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\News;
use App\Related;
use App\Traits\HelperMethods;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class NewsController extends Controller
{
    use HelperMethods;

    public function __construct()
    {
        $this->authorizeResource(News::class);
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
        $columns = json_encode($this->getColumns());
        if ($request->ajax()) {
            $data = News::latest()->with('staff.user');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'dashboard.news.ActionButtons')
                ->addColumn('published', function($row){
                    return view('dashboard.news.toggleButton', compact('row'));
                })
                ->rawColumns(['action', 'published'])
                ->make(true);
        }
        return view('dashboard.news.index', compact('columns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $relatedNews = News::where('published', 1)->pluck('main_title','id')->all();
        return view('dashboard.news.create', compact('relatedNews'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewsRequest $request
     * @return Response
     */
    public function store(NewsRequest $request)
    {
        $inserted = News::create($request->all());

        if ($related = $request['related']){
            $inserted->related()->createMany($this->getInputs($related, 'related_id'));
        }
        if ($images = $request['images']){
            $inserted->images()->createMany($this->getInputs($images, 'path'));
        }
        if ($files = $request['files']){
            $inserted->files()->createMany($this->getInputs($files, 'path'));
        }
        return redirect()->route('news.index')
            ->with('success', 'news created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param news $news
     * @return Response
     */
    public function show(News $news)
    {
        return view('dashboard.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param news $news
     * @return Response
     */
    public function edit(News $news)
    {
        $allNews = News::where('published', 1)->pluck('main_title', 'id')->all();
        $relatedNews = Related::where('news_id', $news->id)->pluck( 'related_id')->all();
        $authors = app('App\Http\Controllers\StaffController')->getAuthorsByJob($news->type);
        return view('dashboard.news.edit', compact('news', 'authors', 'relatedNews', 'allNews'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NewsRequest $request
     * @param news $news
     * @return Response
     */
    public function update(NewsRequest $request, News $news)
    {
        $news->update($request->all());

        if ($request->related){
            $news->related()->delete(); // delete old related news
            $news->related()->createMany($this->getInputs($request->related, 'related_id'));
        }
        if ($images = $request['images']){
            $news->images()->createMany($this->getInputs($images, 'path'));
        }
        if ($files = $request['files']){
            $news->files()->createMany($this->getInputs($files, 'path'));
        }
        return redirect()->route('news.index')
            ->with('success', 'news updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param News $news
     * @return  Response
     * @throws Exception
     */
    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('news.index')
            ->with('error', 'News deleted successfully');
    }

    // get columns for datatable.
    public function getColumns()
    {
        return [
            ['data' => 'id', 'name' => 'id'],
            ['data' => 'staff.user.first_name', 'name' => 'image'],
            ['data' => 'main_title', 'name' => 'main_title'],
            ['data' => 'secondary_title', 'name' => 'secondary_title'],
            ['data' => 'type', 'name' => 'type'],
            ['data' => 'content', 'name' => 'content'],
            ['data' => 'published', 'name' => 'published'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]
        ];
    }

    // get array of rows to be inserted for many relations (images, files, related news).
    public function getInputs($values, $fillableColumn){
        $inputs = [];
        foreach ($values as $value){
            array_push($inputs, [$fillableColumn => $value]);
        }
        return $inputs;
    }

    // publish news or un publish it
    public function togglePublishing(News $news){
        $news->update(['published' => !$news->published ]);
    }

    // get related news based on search
    public function getRelated(Request $request){
        $term = trim($request['search']);

        if (empty($term)) {
            return \Response::json([]);
        }
        $result = News::where('main_title', 'like', "%$term%")->select('main_title', 'id')->get();
        $formatted_news = [];

        foreach ($result as $news) {
            $formatted_news[] = ['id' => $news->id, 'text' => $news->main_title];
        }

        return \Response::json($formatted_news);
    }

}

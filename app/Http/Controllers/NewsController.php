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

class newsController extends Controller
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
        $columns = $this->getColumns('news');
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
        $relatedNews = News::where('published', 1)->get()
            ->pluck('main_title', 'id');
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
//        dd($request->all());
        $inserted = News::create($request->all());
        if ($request['related']){
            foreach ($request['related'] as $relatedId){
                $inserted->related()->create(['news_id' => $inserted->id, 'related_id' => $relatedId]);
            }
        }
        if ($request->hasFile('images')){
            $this->createRelation($inserted, $request['images'], 'images');
        }
        if ($request->hasFile('files')){
            $this->createRelation($inserted, $request['files'], 'files');
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
        $type = $news->type == "News" ? 2 : 1;
        $allNews = News::where('published', 1)->get()
            ->pluck('main_title', 'id');
        $relatedNews = Related::where('news_id', $news->id)->get()
            ->pluck( 'related_id')->all();
        $authors = app('App\Http\Controllers\StaffController')->getAuthorsByJob($type);
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

        if ($request->related){ // has related news
            if ($request->related != $news->related){ // related news has changed (not the same)
                $news->related()->delete(); // delete old related news
                foreach ($request->related as $relatedId){ // store new related
                    $news->related()->create(['news_id' => $news->id, 'related_id' => $relatedId]);
                }
            }
        }
        if ($request->hasFile('images')){
            $news->images()->delete();
            $this->createRelation($news, $request['images'], 'images');
        }
        if ($request->hasFile('files')){
            $news->files()->delete();
            $this->createRelation($news, $request['files'], 'files');
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

    public function togglePublishing(News $news){
        $news->update(['published' => !$news->published ]);
        return "success";
    }

    public function createRelation(News $news, $items, $relation){
        foreach ($items as $item){
            $news->$relation()->create(['path' => time().$item->getClientOriginalName()]);
        }
    }

    public function uploadToServer(Request $request){
        foreach ($request['files'] as $file){
            $this->uploadImage($file);
        }
        return "success";
    }

}

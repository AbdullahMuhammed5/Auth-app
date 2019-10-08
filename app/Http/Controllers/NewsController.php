<?php


namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\News;
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
        return view('dashboard.news.create');
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

        if ($request->hasFile('images')){
            foreach ($request['images'] as $image){
                $imgPath = $this->uploadImage($image);
                $inserted->images()->create(['path' => $imgPath]);
            }
        }
        if ($request->hasFile('files')){
            foreach ($request['files'] as $file){
                $filePath = $this->uploadImage($file);
                $inserted->files()->create(['path' => $filePath]);
            }
        }
//        dd($request->all());
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
        $authors = app('App\Http\Controllers\StaffController')->getAuthorsByJob($type);
        return view('dashboard.news.edit', compact('news', 'authors'));
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
            ->with('error', 'news deleted successfully');
    }

    public function togglePublishing(News $news){
        $status = $news->published ? 0 : 1;
        $news->update(['published' => $status]);
        return "success";
    }

    public function upload(Request $request){
        $this->uploadImage($request['upload']);
        return "Uploaded successfully!";
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    private $formRules = [
        'name' => 'required|max:255',
        'description' => 'required|max:255',
        'status' => 'required',
        'type' => 'required',
    ];

    /**
     * Data filtering.
     *
     * @return array
     */
    private function formatData(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ];

        if ($request->has('category_id')) {
            $data['category_id'] = $request->input('category_id');
        }

        if ($request->hasFile('logo')) {
            $logoUrl = \Helper::qiniuUpload($request->file('logo'));
            if ($logoUrl) {
                $data['logo'] = $logoUrl;
            }
        }
        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.category.index', ['categories' => Category::paginate('20')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        return view('admin.category.index', ['categories' => Category::search($keyword)->paginate('20')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $this->formatData($request);
        Category::create($data);
        \Session::flash('message', trans('categories.insert_message'));
        return redirect('/admin/category');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        return view('admin.category.edit', ['category' => Category::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->formatData($request);
        $category = Category::find($id);
        $category->update($data);
        \Session::flash('message', trans('categories.update_message'));

        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
    }
}

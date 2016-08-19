<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;


class SpecificationController extends Controller
{
    /**
     * Data filtering.
     *
     * @return array
     */
    private function formatData(Request $request)
    {
        $data = [
            'specification_name' => $request->input('specification_name'),
            'specification_price' => $request->input('specification_price'),
        ];
        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.specification.index', ['specifications' => ProductSpecification::paginate('20')]);
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
        return view('admin.specification.edit', [
            'specification' => ProductSpecification::find($id)
        ]);
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
        $spec = ProductSpecification::find($id);
        $data = $this->formatData($request);
        $spec->update($data);
        return redirect()->route('admin.specification.index');
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
        $spec = ProductSpecification::find($id);
        $spec->delete();
    }
}

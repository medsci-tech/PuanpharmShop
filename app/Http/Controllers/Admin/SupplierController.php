<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private $formRules = [
        'supplier_name' => 'required|max:255',
        'supplier_desc' => 'required|max:255',
    ];

    /**
     * Data filtering.
     *
     * @return array
     */
    private function formatData(Request $request)
    {
        $data = [
            'supplier_name' => $request->input('supplier_name'),
            'supplier_desc' => $request->input('supplier_desc')
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
        return view('admin.supplier.index', ['suppliers' => Supplier::paginate('5')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //$this->validate($request, $this->formRules);
        $data = $this->formatData($request);
        Supplier::create($data);
        \Session::flash('message', trans('suppliers.insert_message'));
        return redirect('/admin/supplier');
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
        return view('admin.supplier.edit', ['supplier' => Supplier::find($id)]);
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
        //$this->validate($request, $this->formRules);
        $data = $this->formatData($request);
        $supplier = Supplier::find($id);
        $supplier->update($data);
        \Session::flash('message', trans('suppliers.update_message'));

        return redirect()->route('admin.supplier.index');
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
        $supplier = Supplier::find($id);
        $supplier->delete();
    }
}

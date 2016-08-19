<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    private $formRules = [
        'activity_name' => 'required|max:255'
    ];

    /**
     * Data filtering.
     *
     * @return array
     */
    private function formatData(Request $request)
    {
        $data = [
            'activity_name' => $request->input('activity_name')
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
        return view('admin.activity.index', ['activities' => Activity::paginate('5')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.activity.create');
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
        Activity::create($data);
        \Session::flash('message', trans('activities.insert_message'));
        return redirect('/admin/activity');
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
        return view('admin.activity.edit', ['activity' => Activity::find($id)]);
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
        $activity = Activity::find($id);
        $activity->update($data);
        \Session::flash('message', trans('activities.update_message'));

        return redirect()->route('admin.activity.index');
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
        $activity = Activity::find($id);
        $activity->delete();
    }
}

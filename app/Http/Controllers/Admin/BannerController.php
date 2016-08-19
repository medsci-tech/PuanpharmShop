<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    /**
     * Data filtering.
     *
     * @return array
     */
    private function formatData(Request $request)
    {
        $data = [
            'weight' => $request->input('weight'),
            'href_url' => $request->input('href_url'),
        ];

        $bannerUrl = $this->uploadBanners($request);
        if ($bannerUrl) {
            $data['image_url'] = $bannerUrl;
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
        return view('admin.banner.index', ['banners' => Banner::paginate('30')]);
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
        return view('admin.banner.edit', [
            'banner' => Banner::find($id)
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
        $banner = Banner::find($id);
        $data = $this->formatData($request);
        $banner->update($data);
        return redirect()->route('admin.banner.index');
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
        $spec = Banner::find($id);
        $spec->delete();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $data = $this->formatData($request);
        Banner::create($data);
        return redirect('/admin/banner');
    }


    public function uploadBanners(Request $request)
    {
        if (!$request->hasFile('banner')) {
            return false;
        }
        $banner = $request->file('banner');
        if ($banner->isValid()) {
            return $imageUrl = \Helper::qiniuUpload($banner);
        }

        return false;
    }
}

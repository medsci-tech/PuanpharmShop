<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductBanner;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductBannerController extends Controller
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
        ];

        $bannerUrl = $this->upload($request);
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
        return view('admin.product_banner.index', ['banners' => ProductBanner::paginate('30')]);
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
        return view('admin.product_banner.edit', [
            'banner' => ProductBanner::find($id)
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
        $spec = ProductBanner::find($id);
        $data = $this->formatData($request);
        $spec->update($data);
        return redirect()->route('admin.product-banner.index');
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
        $spec = ProductBanner::find($id);
        $spec->delete();
    }

    /**
     *    upload image file.
     *
     * @param Resquest    file to upload
     *
     * @return string
     */
    public function upload(Request $request)
    {
        if (!$request->hasFile('banner')) {
            return false;
        }
        $file = $request->file('banner');
        if ($file->isValid()) {
            $clientName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $newName = md5(date('ymdhis') . $clientName) . "." . $extension;
            Image::make($request->file('banner'))->resize(640, 320)->save('uploads/productImages/' . $newName);
            return '/uploads/productImages/' . $newName;
        } else {
            return false;
        }
    }
}

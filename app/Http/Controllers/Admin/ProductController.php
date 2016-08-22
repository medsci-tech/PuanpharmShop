<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Excel;

class ProductController extends Controller
{
    private $formRules = [
        'name' => 'required|max:100',
        'product_id' => 'required',
        'description' => 'required',
        'price' => 'required',
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
            'description' => $request->input('description'),
            'detail' => $request->input('detail'),
            'category_id' => $request->input('category_id'),
            'supplier_id' => $request->input('supplier_id'),
            'price' => $request->input('price'),
            'beans' => $request->input('beans'),
            'tags' => $request->input('tags'),
            'is_on_sale' => $request->input('is_on_sale'),
            'default_spec' => $request->input('default_spec'),
            'weight' => $request->input('weight'),
            'puan_id' => $request->input('puan_id')
        ];

        if ($request->has('activity_id') && $request->input('activity_id')) {
            $data['activity_id'] = $request->input('activity_id');
        }

        if ($request->hasFile('logo')) {
            $logoUrl = \Helper::qiniuUpload($request->file('logo'));
            if ($logoUrl) {
                $data['logo'] = $logoUrl;
            }
        }

        $bannerUrl = $this->uploadBanners($request);
        if ($bannerUrl) {
            $data['banners'] = $bannerUrl;
        }
        return $data;
    }

    /**
     * Data filtering.
     *
     * @return array
     */
    private function updateFormatData(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'detail' => $request->input('detail'),
            'category_id' => $request->input('category_id'),
            'supplier_id' => $request->input('supplier_id'),
            'price' => $request->input('price'),
            'beans' => $request->input('beans'),
            'tags' => $request->input('tags'),
            'is_on_sale' => $request->input('is_on_sale'),
            'default_spec' => $request->input('default_spec'),
            'weight' => $request->input('weight'),
            'puan_id' => $request->input('puan_id')
        ];

        if (!$request->input('activity_id')) {
            $data['activity_id'] = null;
        } else {
            $data['activity_id'] = $request->input('activity_id');
        }

        $logoUrl = $this->upload($request);
        if ($logoUrl) {
            $data['logo'] = $logoUrl;
        }
        return $data;
    }


    public function index(Request $request)
    {
        $sort = $request->input('sort', 'id');
        $data = [
            'sort' => $sort,
        ];
        if ($request->has('category_id')) {
            $data['products'] = Product::orderBy($sort, 'desc')->where('category_id', $request->input('category_id'))->paginate('20');
            $data['category_id'] = $request->input('category_id');
        } else {
            $data['products'] = Product::orderBy($sort, 'desc')->paginate('20');
        }


        return view('admin.product.index', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function search(Request $request)
    {
        $sort = $request->input('sort', 'id');
        $keyword = $request->input('keyword');
        return view('admin.product.index', [
            'products' => Product::search($keyword)->orderBy($sort, 'desc')->paginate('20'),
            'sort' => $sort
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.product.create', [
            'categories' => Category::all(),
            'suppliers' => Supplier::all(),
            'activities' => Activity::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $specName = $request->input('spec_name');
        $specPrice = $request->input('spec_price');
        $specDetails = [];
        for ($i = 0; $i < sizeof($specName); $i++) {
            $specDetails[$i] = [
                'specification_name' => $specName[$i],
                'specification_price' => $specPrice[$i],
            ];
        }
        $data = $this->formatData($request);
        $data['specDetails'] = $specDetails;
        Product::create($data);
        return redirect('/admin/product');
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
        return view('admin.product.edit', [
            'product' => Product::find($id),
            'categories' => Category::all(),
            'suppliers' => Supplier::all(),
            'activities' => Activity::all(),
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
        $data = $this->updateFormatData($request);
        $product = Product::find($id);
        $product->update($data);

        if ($request->has('spec_name') && $request->has('spec_price')) {
            $specName = $request->input('spec_name');
            $specPrice = $request->input('spec_price');
            $specDetails = [];
            for ($i = 0; $i < sizeof($specName); $i++) {
                $specDetails[$i] = [
                    'specification_name' => $specName[$i],
                    'specification_price' => $specPrice[$i],
                ];
            }
            $product->addSpecs($specDetails);
        }

        $bannerUrl = $this->uploadBanners($request);
        if ($bannerUrl) {
            $product->addBanners($bannerUrl);
        }
        return redirect()->route('admin.product.index');
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
        $product = Product::find($id);
        $product->delete();
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
        if (!$request->hasFile('logo')) {
            return false;
        }
        $file = $request->file('logo');
        if ($file->isValid()) {
            $clientName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $newName = md5(date('ymdhis') . $clientName) . "." . $extension;
            //Image::make($request->file('logo'))->resize(200, 200)->save('uploads/productImages/' . $newName);
            Image::make($request->file('logo'))->save('uploads/productImages/' . $newName);
            return '/uploads/productImages/' . $newName;
        } else {
            return false;
        }
    }


    public function uploadBanners(Request $request)
    {
        if (!$request->hasFile('banner')) {
            return false;
        }
        $banners = $request->file('banner');
        $bannerArray = [];
        foreach ($banners as $banner) {
            $file = $banner;
            if ($file->isValid()) {
                $imageUrl = \Helper::qiniuUpload($file);
                array_push($bannerArray, ['image_url' => $imageUrl]);
            }
        }
        return $bannerArray;
    }


    public function createProductByJson()
    {
        $filename = "data/ohmate-picinfo.json";
        $handle = fopen($filename, "r");//读取二进制文件时，需要将第二个参数设置成'rb'

        //通过filesize获得文件大小，将整个文件一下子读到一个字符串中
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        //dd(json_decode($contents));
        $categories = Category::all();
        $catArray = [];
        foreach ($categories as $category) {
            $catArray[$category->name] = $category->id;
        }
        $QiniuUrl = 'http://o93nlp231.bkt.clouddn.com';
        $jsonData = json_decode($contents);
        $productArray = [];
        foreach ($jsonData as &$data) {
            foreach ($data->head_image as &$image) {
                $image = ['image_url' => $QiniuUrl . $image];
            }
            foreach ($data->content_image as &$image) {
                $image = $QiniuUrl . $image;
            }
            // detail
            $content = '<p>';
            foreach ($data->content_image as $image) {
                $content = $content . '<img src="' . $image . '"/>';
            }
            $productData = [
                'name' => $data->name,
                'detail' => $content . '</p>',
                'logo' => reset($data->head_image)['image_url'],
                'banners' => $data->head_image,
                'puan_id' => intval($data->product_id),
                'tags' => implode(',', $data->tags),
                'supplier_id' => 2,
                'is_on_sale' => 0,
                'category_id' => array_key_exists($data->type, $catArray) ? $catArray[$data->type] : 99
            ];
            array_push($productArray, $productData);
        }
        //dd($productArray);
        foreach ($productArray as $productData) {
            Product::create($productData);
        }
    }

    public function excel(Request $request)
    {
        $this->createProductByJson();
        $excel = $request->file('excel');
        Excel::load($excel, function ($reader) use ($excel) {
            $excelData = Excel::load($excel)->get()->toArray();
            //dd($excelData);
            foreach ($excelData as $data) {
                $update = [
                    'name' => $data['name'],
                    'default_spec' => $data['default_spec'],
                    'price' => $data['price'],
                    'beans' => $data['price'] * 10,
                    'is_show' => 1,
                ];
                Product::where('puan_id', intval($data['puan_id']))->update($update);
            }
        });
        dd(Product::all());
    }


    public function updatePuanId(Request $request)
    {
        $excel = $request->file('excel');
        Excel::load($excel, function ($reader) use ($excel) {
            $excelData = Excel::load($excel)->get()->toArray();
            //dd($excelData);
            foreach ($excelData as $data) {
                $updateData = [
                    'puan_id' => $data['puan_id']
                ];
                Product::where('name', $data['name'])->update($updateData);
            }
        });
        dd(Product::all());
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Attachment;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;

class AttachmentController extends Controller
{
	private $model, $section, $components;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->section = new \stdClass();
        $this->section->title = 'Attachments';
        $this->section->heading = 'Attachments';
        $this->section->slug = 'attachments';
        $this->section->folder = 'attachments';

    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

	}

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function destroy(Category $category)
   {

   }

   public function addNewAttachment(Request $request)
   {
       if($request->has('product_photo')){
           $lastAddedPath = [];
//           dd('1');
           foreach ($request->product_photo as $key => $attachment){
              $data =   Attachment::create([
                    'name' => time().'_'.$attachment->getClientOriginalName(),
                    'type' => $attachment->getMimeType()
                ]);
                $lastAddedPath[$key] = env('ASSET_URL').'/attachments/'.$data->name;
                $attachment->move(public_path('attachments'),$data->name);
            }
            return $lastAddedPath;
       }
       if($request->has('serial_number_label')){
           $lastAddedPath = [];
           dd('2');
           foreach ($request->serial_number_label as $key => $attachment){
               $data =   Attachment::create([
                   'name' => time().'_'.$attachment->getClientOriginalName(),
                   'type' => $attachment->getMimeType()
               ]);
               $lastAddedPath[$key] = env('ASSET_URL').'/attachments/'.$data->name;
               $attachment->move(public_path('attachments'),$data->name);
           }
           return $lastAddedPath;
       }
       if($request->has('reserve_listing_photos')){
           $lastAddedPath = [];
           dd('3');
           foreach ($request->reserve_listing_photos as $key => $attachment){
               $data =   Attachment::create([
                   'name' => time().'_'.$attachment->getClientOriginalName(),
                   'type' => $attachment->getMimeType()
               ]);
               $lastAddedPath[$key] = env('ASSET_URL').'/attachments/'.$data->name;
               $attachment->move(public_path('attachments'),$data->name);
           }
           return $lastAddedPath;
       }
       return null;
   }



    public function fileStore(Request $request)
    {
//        return $request->toArray();
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('attachments'),$imageName);

        //create small thumbnail
//        $thumbnailImage = Image::make(file_get_contents('public/attachments/'.$imageName))->resize(100, 100);
//        $thumbnailImage->save('public/attachments/thumbnail_'.$imageName);

//        dd($imageName, $smallthumbnailpath, $thumbnailImage, $image->getRealPath());
        $imageUpload = new Attachment();
        $imageUpload->name = env('ASSET_URL').'/attachments/'.$imageName;
        $imageUpload->type = $image->getClientMimeType();
//        $imageUpload->thumbnail = env('ASSET_URL').'/attachments/thumbnail_'.$imageName;
        $imageUpload->save();
        return response()->json(['success'=>$imageUpload->name]);
    }

    function generateThumbnail($img, $width, $height, $quality = 90)
    {
        if (is_file($img)) {
            $imagick = new Imagick(realpath($img));
            $imagick->setImageFormat('jpeg');
            $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
            $imagick->setImageCompressionQuality($quality);
            $imagick->thumbnailImage($width, $height, false, false);
            $filename_no_ext = reset(explode('.', $img));
            if (file_put_contents($filename_no_ext . '_thumb' . '.jpg', $imagick) === false) {
                throw new Exception("Could not put contents.");
            }
            return true;
        }
        else {
            throw new Exception("No valid image provided with {$img}.");
        }
    }

    public function fileDestroy(Request $request)
    {
        $filename =  $request->input('filename');
        $image = Attachment::where('name',$filename)->first();
        // delete image from attachment table
        Attachment::where('name',$filename)->delete();
        $path=public_path().'/attachments/'.$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $image->name;
    }

    public function scanBarcode(Request $request) {
        return view('scan', compact('request'));
    }

    public function createThumbnail(Request $request) {

        $lgReturns = LgReturn::limit(100)->orderBy('id', "DESC")->get();
//        dd($lgReturns->toArray());
        foreach ($lgReturns as $lgReturn){
//            dump('ID: ' .$lgReturn->id);
            if($lgReturn->product_photo != null){
                $product_photos = explode(',', $lgReturn->product_photo);
                dump($product_photos);
                $productImages = array();
                foreach ($product_photos as $product_photo){
                    $imageName = last(explode('/', $product_photo));
                    dump(explode('/', $product_photo), $imageName);
                    //create small thumbnail
                    $thumbnailImage = Image::make(file_get_contents($product_photo))->resize(100, 100);
                    $thumbnailImage->save('public/attachments/thumbnail_'.$imageName);
                    array_push($productImages, env('APP_URL').'public/attachments/thumbnail_'.$imageName);
//                dump($imageThumbnail);
                }
//            $lgReturn->product_photo_thumbnail =  implode(',', $productImages);
//            $lgReturn->save();
                dd($productImages, 'createThumbnail');
            }
        }

        return view('scan', compact('request'));
    }

}

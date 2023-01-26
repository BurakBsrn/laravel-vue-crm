<?php

namespace App\Http\Controllers\api\profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class indexController extends Controller
{
    public $path;
    public function __construct()
    {
        $this->path = "profile/";
    }

    public function update(Request $request,User $item){
        $data = $request->except("_token","_method","password_confirmation");

        $validateData = [
            "name"=> "required|string|max:255",
        ];

        // EMAIL KOONTROLU YAPTIRALIM
        if ($data['email'] != $item->email){
            $kontrol = User::where(array(
                "email" => $data['email']
            ))->first();

            if ($kontrol){
                $validateData['email'] = "required|string|email|unique:users|max:255";
            }else{
                $validateData['email'] = "required|string|email|max:255";
            }
        }

        // ŞİFRE KONTROLUNU YAPTIRALIM
        if (!empty($data['password'])){
            $validateData['password'] = "required|string|min:8|max:16|confirmed";
        }

        $request->validate($validateData);

        // RESIM GELDI MI ANALIZ YAPALIM
        $userImage = $item->images;  // GELMEMIS VE SARTLAR SAĞLANMIYORSA BU AKTIF OLARAK DURACAK
        if (!empty($data['images']) && count($data['images'])==1){
            if ($item->images != "" && File::exists("storage/".$item->images)){
                File::delete("storage/".$item->images);
            }

            foreach ($data['images'] as $image) {
                $base64_image = $image; // your base64 encoded
                @list($type, $file_data) = explode(';', $base64_image);
                @list(, $file_data) = explode(',', $file_data);
                $imageName = $this->path . Str::slug($data['name']) . "-" . uniqid();
                Image::make(base64_decode($file_data))->encode("webp", 90)->resize(37, 37)->save(public_path("storage/" . $imageName . ".webp"));

                $userImage = $imageName . ".webp";
            }
        }

        // AYARLAMALARI YAPALIM
        $data['password'] = (!empty($data['password'])) ? Hash::make($data['password']) : $item->password;
        $data['images'] = $userImage;

        $item->update($data);
    }
}

<?php

namespace App\Http\Controllers;

use BackblazeB2\File;
use Illuminate\Http\Request;
use function Sodium\compare;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class CloudController extends Controller
{
    public function upload(){
        request()->validate(
            [
                'image' => 'image|mimes:jpeg,png,jpg|max:2048|required',
            ]);

            $path = request()->image->path();
            $imageName = time() . request()->image->getClientOriginalName();
            \Storage::disk('b2')->put($imageName, file_get_contents($path));

            return back();
    }

    public function viewFiles(){

        $account_id = "1d50de196387"; // Obtained from your B2 account page
        $data = $this->authorizeAccount();
        $bucketData = $this->getBucketData($data, $account_id);
        $files = $this->getBucketFiles($data, $bucketData);

        return view('home', compact('files'));
    }

    public function getBucketData($data, $account_id){
        $api_url = $data['apiUrl']; // From b2_authorize_account call
        $auth_token = $data['authorizationToken']; // From b2_authorize_account call

        $session = curl_init($api_url .  "/b2api/v1/b2_list_buckets");

        // Add post fields
        $data = array("accountId" => $account_id);
        $post_fields = json_encode($data);
        curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields);

        // Add headers
        $headers = array();
        $headers[] = "Authorization: " . $auth_token;
        curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($session, CURLOPT_POST, true); // HTTP POST
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
        $server_output = curl_exec($session); // Let's do this!
        curl_close ($session); // Clean up
        $data = json_decode($server_output, true);

        return $data;
    }

    public function getBucketFiles($data, $bucketData){
        $api_url = $data['apiUrl']; // From b2_authorize_account call
        $auth_token = $data['authorizationToken']; // From b2_authorize_account call
        $bucket_id = $bucketData['buckets'][0]['bucketId'];  // The ID of the bucket

        $session = curl_init($api_url .  "/b2api/v1/b2_list_file_names");

        // Add post fields
        $data = array("bucketId" => $bucket_id);
        $post_fields = json_encode($data);
        curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields);

        // Add headers
        $headers = array();
        $headers[] = "Authorization: " . $auth_token;
        curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($session, CURLOPT_POST, true); // HTTP POST
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
        $server_output = curl_exec($session); // Let's do this!
        curl_close ($session); // Clean up
        $data = json_decode($server_output, true);

        return $data;
    }

    public function delete($fileName){
        \Storage::disk('b2')->delete($fileName);

        return back();
    }

    public function update($fileName){
        request()->validate(
            [
                'image' => 'image|mimes:jpeg,png,jpg|max:2048|required',
            ]);

        $path = request()->image->path();
        $imageName = time() . request()->image->getClientOriginalName();


        \Storage::disk('b2')->update($fileName, file_get_contents($path));

        return back();
    }

    public function addUser(){
        $data = request()->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed',
                'permission' => 'required'
            ]);

        $data['password'] = bcrypt($data['password']);
        $user = User::create( $data );

        // Adding permissions via a role
        $user->assignRole('user');
        $user->givePermissionTo($data['permission']);
        return back();
    }

    public function authorizeAccount(){
        $account_id = "1d50de196387"; // Obtained from your B2 account page
        $application_key = "001a6e26facc05e4c06d7f1b660031068ec0b89ead"; // Obtained from your B2 account page
        $credentials = base64_encode($account_id . ":" . $application_key);
        $url = "https://api.backblazeb2.com/b2api/v1/b2_authorize_account";

        $session = curl_init($url);

        // Add headers
        $headers = array();
        $headers[] = "Accept: application/json";
        $headers[] = "Authorization: Basic " . $credentials;
        curl_setopt($session, CURLOPT_HTTPHEADER, $headers);  // Add headers

        curl_setopt($session, CURLOPT_HTTPGET, true);  // HTTP GET
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // Receive server response
        $server_output = curl_exec($session);
        curl_close ($session);
        $data = json_decode($server_output, true);
        return $data;
    }

    public function downloadFile($fileId){
        $data = $this->authorizeAccount();
        $download_url = $data['downloadUrl']; // From b2_authorize_account call
        $file_id = $fileId; // The ID of the file you want to download
        $uri = $download_url . "/b2api/v1/b2_download_file_by_id?fileId=" . $file_id;

        $session = curl_init($uri);

        curl_setopt($session, CURLOPT_HTTPGET, true); // HTTP GET
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
        $server_output = curl_exec($session); // Let's do this!
        curl_close ($session); // Clean up

        \Storage::put(time() . ".jpg",$server_output);
        session()->flash('message', 'Dowloaded');
        return back();
    }

}

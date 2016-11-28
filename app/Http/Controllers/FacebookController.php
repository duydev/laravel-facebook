<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Facebook;

class FacebookController extends Controller
{
    public function login() {
        
        $fb = new Facebook( config( 'facebook' ) );
        $helper = $fb->getRedirectLoginHelper();
        
        $permissions = ['email']; // Optional permissions
        
        $loginUrl = $helper->getLoginUrl( url( '/login/fb/callback' ), $permissions);
        
        return redirect( $loginUrl );
    }
    
    public function callback(Request $req) {
        
        $fb = new Facebook( config( 'facebook' ) );
        $helper = $fb->getRedirectLoginHelper();
        
        try {
            
            // Lay access token
            $accessToken = $helper->getAccessToken();
          
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me?fields=id,name', $accessToken);
            
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return 'Graph returned an error: ' . $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
        
        $user = $response->getGraphUser();

        return 'Xin chào ' + $user['name'];
        
    }
}

<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

		//AC
		
		$this->api_token = env('API_TOKEN');
		//echo $this->api_token;

        $this->app['auth']->viaRequest('api', function ($request) {
			
		if($request->header('API-TOKEN')){	
			$api_token = $request->header('API-TOKEN');
		}else{
			$api_token = $request->input('API-TOKEN');
		}
		
        //$headertoken = $request->header('API-TOKEN'); 
		//array_push($this->debug, '$req API-TOKEN: ' . $TOKEN);
		if ($api_token && $api_token === $this->api_token )
		{
			return new User();
		}
		else {
		return null;
		}
		
		 //   if ($request->input('api_token')) {
           //     return User::where('api_token', $request->input('api_token'))->first();
            //}
        });
    }
}

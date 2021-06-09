<?php

if (! function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

if (! function_exists('gravatar')) {
    /**
     * Access the gravatar helper.
     */
    function gravatar()
    {
        return app('gravatar');
    }
}
 function isRole() 
{
   return $this->roles()->where('role_id', 1)->first();
}

if (! function_exists('home_route')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function home_route()
    {
        if (auth()->check()) {

            $id = auth()->user()->id;

            $users = DB::table('role_user')->where('user_id', $id)->first();
        

  
            if (auth()->user()->can('view backend')) {
                return 'admin.dashboard';
            }/*else if ($users->role_id == 4) {
               
                return 'admin.dashboard';
            }*/




            return 'frontend.user.dashboard';
        }

        return 'frontend.auth.login';
    }
}

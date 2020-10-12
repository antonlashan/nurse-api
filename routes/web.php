<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It is a breeze. Simply tell Lumen the URIs it should respond to
  | and give it the Closure to call when that URI is requested.
  |
 */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->group(['namespace' => 'auth'], function () use ($router) {
        // auth client
        $router->group(['prefix' => 'auth'], function () use ($router) {
            $router->post('/login', 'AuthController@authenticate');
            $router->group(['middleware' => 'auth'], function () use ($router) {
                $router->post('/logout', 'AuthController@deauthenticate');
            });
        });

        // auth admin
        $router->group(['prefix' => 'admin/auth'], function () use ($router) {
            $router->post('/login', 'AuthAdminController@authenticate');
            $router->group(['middleware' => 'authAdmin'], function () use ($router) {
                $router->post('/logout', 'AuthAdminController@deauthenticate');
            });
        });
    });

    // registration client
    $router->group(['namespace' => 'app'], function () use ($router) {
        $router->group(['prefix' => 'user'], function () use ($router) {
            $router->post('/', 'UserController@register');
            $router->post('/verify-otp', 'UserController@verifyOTP');
            $router->post('/resend-otp', 'UserController@resendOTP');
        });
    });

    // forgot pwd client
    $router->group(['namespace' => 'app'], function () use ($router) {
        $router->group(['prefix' => 'forgot-pwd'], function () use ($router) {
            $router->post('/send-otp', 'ForgotPwdController@sendOTP');
            $router->post('/verify-otp', 'ForgotPwdController@verifyOTP');
            $router->post('/resend-otp', 'ForgotPwdController@resendOTP');
            $router->put('/', 'ForgotPwdController@update');
        });
    });

    // for testing
    $router->group(['namespace' => 'app'], function () use ($router) {
        $router->group(['prefix' => 'test-list'], function () use ($router) {
            $router->get('/', 'DistrictController@lists');
        });
    });

    // authenticated client
    $router->group(['namespace' => 'app', 'middleware' => 'auth'], function () use ($router) {
        $router->group(['prefix' => 'districts'], function () use ($router) {
            $router->get('/', 'DistrictController@lists');
        });
        $router->group(['prefix' => 'company-posts'], function () use ($router) {
            $router->get('/', 'CompanyPostController@lists');
            $router->get('/{id}', 'CompanyPostController@getOne');
        });
        $router->group(['prefix' => 'advertisements'], function () use ($router) {
            $router->get('/', 'AdvertisementController@lists');
        });
        $router->group(['prefix' => 'company-post-bookmarks'], function () use ($router) {
            $router->get('/', 'CompanyPostBookmarkController@lists');
            $router->post('/', 'CompanyPostBookmarkController@bookmark');
        });
        $router->group(['prefix' => 'company-post-applications'], function () use ($router) {
            $router->get('/', 'CompanyPostApplicationController@lists');
            $router->post('/apply', 'CompanyPostApplicationController@apply');
            $router->post('/confirm', 'CompanyPostApplicationController@confirm');
        });
        $router->group(['prefix' => 'user'], function () use ($router) {
            $router->get('/', 'UserController@getOne');
            $router->put('/', 'UserController@update');
            $router->put('/profile-pic', 'UserController@updateProfPic');
            $router->put('/update-pwd', 'UserController@changePwd');
            $router->get('/referral-points', 'UserController@getReferralPoints');
        });
        $router->group(['prefix' => 'news'], function () use ($router) {
            $router->get('/', 'NewsController@lists');
            $router->get('/featured-news', 'NewsController@getFeaturedNews');
        });
        $router->group(['prefix' => 'post-categories'], function () use ($router) {
            $router->get('/', 'PostCategoryController@lists');
        });
        $router->group(['prefix' => 'posts'], function () use ($router) {
            $router->get('/', 'PostController@lists');
            $router->get('/{id}', 'PostController@getOne');
            $router->put('/{id}/like', 'PostController@like');
            $router->put('/{id}/dislike', 'PostController@dislike');
        });
        $router->group(['prefix' => 'posts/{pid}/post-comments'], function () use ($router) {
            $router->get('/', 'PostCommentController@lists');
            $router->post('/', 'PostCommentController@create');
            $router->put('/{id}', 'PostCommentController@update');
            $router->delete('/{id}', 'PostCommentController@delete');
        });
        $router->group(['prefix' => 'post-comments/{cid}/reply'], function () use ($router) {
            $router->post('/', 'PostCommentReplyController@create');
            $router->put('/{id}', 'PostCommentReplyController@update');
            $router->delete('/{id}', 'PostCommentReplyController@delete');
        });
        $router->group(['prefix' => 'notifications'], function () use ($router) {
            $router->get('/', 'NotificationController@lists');
            $router->get('/unread-count', 'NotificationController@unreadCnt');
            $router->put('/read', 'NotificationController@read');
        });
    });

    // authenticated admin
    $router->group(['prefix' => 'admin', 'namespace' => 'admin', 'middleware' => 'authAdmin'], function () use ($router) {
        $router->group(['prefix' => 'users'], function () use ($router) {
            $router->get('/', 'UserController@lists');
            $router->get('/{id}', 'UserController@getOne');
            $router->delete('/{id}', 'UserController@delete');
            $router->put('/update-pwd', 'UserController@changePwd');
        });
        $router->group(['prefix' => 'companies'], function () use ($router) {
            $router->get('/', 'CompanyController@lists');
            $router->get('/{id}', 'CompanyController@getOne');
            $router->post('/', 'CompanyController@create');
            $router->put('/{id}', 'CompanyController@update');
            $router->delete('/{id}', 'CompanyController@delete');
        });
        $router->group(['prefix' => 'company-posts'], function () use ($router) {
            $router->get('/', 'CompanyPostController@lists');
            $router->get('/{id}', 'CompanyPostController@getOne');
            $router->post('/', 'CompanyPostController@create');
            $router->put('/{id}', 'CompanyPostController@update');
            $router->delete('/{id}', 'CompanyPostController@delete');
            $router->get('/{id}/applicants', 'CompanyPostApplicantController@lists');
            $router->post('/{id}/applicants/send-msg', 'CompanyPostApplicantController@sendMessage');
        });
        $router->group(['prefix' => 'advertisements'], function () use ($router) {
            $router->get('/', 'AdvertisementController@lists');
            $router->get('/{id}', 'AdvertisementController@getOne');
            $router->post('/', 'AdvertisementController@create');
            $router->put('/{id}', 'AdvertisementController@update');
            $router->delete('/{id}', 'AdvertisementController@delete');
        });
        $router->group(['prefix' => 'company-post-bookmarks'], function () use ($router) {
            $router->get('/', 'CompanyPostBookmarkController@lists');
        });
        $router->group(['prefix' => 'company-post-applications'], function () use ($router) {
            $router->get('/', 'CompanyPostApplicationController@lists');
            $router->put('/{id}', 'CompanyPostApplicationController@update');
        });
        $router->group(['prefix' => 'news'], function () use ($router) {
            $router->get('/', 'NewsController@lists');
            $router->get('/{id}', 'NewsController@getOne');
            $router->post('/', 'NewsController@create');
            $router->put('/{id}', 'NewsController@update');
            $router->delete('/{id}', 'NewsController@delete');
        });
        $router->group(['prefix' => 'post-categories'], function () use ($router) {
            $router->get('/', 'PostCategoryController@lists');
            $router->get('/{id}', 'PostCategoryController@getOne');
            $router->post('/', 'PostCategoryController@create');
            $router->put('/{id}', 'PostCategoryController@update');
            $router->delete('/{id}', 'PostCategoryController@delete');
        });
        $router->group(['prefix' => 'posts'], function () use ($router) {
            $router->get('/', 'PostController@lists');
            $router->get('/{id}', 'PostController@getOne');
            $router->post('/', 'PostController@create');
            $router->put('/{id}', 'PostController@update');
            $router->delete('/{id}', 'PostController@delete');
        });
        $router->group(['prefix' => 'posts/{pid}/post-comments'], function () use ($router) {
            $router->get('/', 'PostCommentController@lists');
            $router->delete('/{id}', 'PostCommentController@delete');
        });
        $router->group(['prefix' => 'post-comments/{cid}/reply'], function () use ($router) {
            $router->delete('/{id}', 'PostCommentReplyController@delete');
        });
        $router->group(['prefix' => 'dashboard-images'], function () use ($router) {
            $router->get('/', 'DashboardImageController@lists');
            $router->get('/{id}', 'DashboardImageController@getOne');
            $router->post('/', 'DashboardImageController@create');
            $router->put('/{id}', 'DashboardImageController@update');
            $router->delete('/{id}', 'DashboardImageController@delete');
        });
    });
});

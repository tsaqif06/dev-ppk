<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Dokumentasi API Barantin",
 *      description="Data Request",
 *      @OA\Contact(
 *          email="nandaputraservice@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_ADMIN_HOST,
 *      description="Api Admin Barantin"
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_USER_HOST,
 *      description="Api User Barantin Test"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}

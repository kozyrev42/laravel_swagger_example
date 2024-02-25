<?php

namespace App\Http\Controllers\Swagger;

/**
 * 
 * @OA\Info(
 *    version="1.0.0",
 *    title="Документация к API",
 * ),
 * 
 * @OA\PathItem(
 *      path="/api"
 * ),
 * 
 * 
 * @OA\Components(
 *     @OA\SecurityScheme(
 *          securityScheme="bearerAuth",
 *          type="http",
 *          scheme="bearer",
 *          bearerFormat="JWT",
 *     )
 * )
 * 
 */
class MainController
{
}

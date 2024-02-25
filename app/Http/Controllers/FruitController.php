<?php

namespace App\Http\Controllers;

use App\Models\Fruit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\FruitResource;

class FruitController
{
    /**
     * @OA\Get(
     *      path="/api/fruits/get-all",
     *      operationId="getFruits",
     *      tags={"API Fruits"},
     *      summary="Получение списка всех фруктов",
     *      description="Возвращает список всех фруктов, доступных в базе данных.",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer",
     *                          example=2
     *                      ),
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          example="Киви"
     *                      ),
     *                      @OA\Property(
     *                          property="price",
     *                          type="number",
     *                          example=2000
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="error",
     *                  type="string",
     *                  example="An unexpected error occurred."
     *              )
     *          )
     *      )
     * )
     */
    public function getFruits()
    {
        $fruits = Fruit::all();

        return FruitResource::collection($fruits);
    }

    /**
     * @OA\Get(
     *      path="/api/fruits/{id}",
     *      operationId="getFruitById",
     *      tags={"API Fruits"},
     *      summary="Получение фрукта по id",
     *      description="Получение фрукта по id",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                 property="data",
     *                 type="object",
     *              @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  example=1
     *                  ),
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  example="apple"
     *                  ),
     *              @OA\Property(
     *                  property="price",
     *                  type="number",
     *                  example=100
     *                  ),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Bad Request",
     *          @OA\JsonContent( 
     *              @OA\Property(
     *                  property="error",
     *                  type="string",
     *                  example="Fruit not found."
     *              ),
     *          ),
     *      )
     *   )
     */
    public function getFruitById($id)
    {
        $fruit = Fruit::find($id);

        if (!$fruit) {
            return response()->json([
                'error' => 'Fruit not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        return new FruitResource($fruit);
    }

    /**
     * @OA\Post(
     *     path="/api/fruits/create",
     *     summary="Создание фрукта.",
     *     tags={"API Fruits"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass fruit data",
     *         @OA\JsonContent(
     *             required={"name","price"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Манго"
     *             ),
     *             @OA\Property(
     *                 property="price",
     *                 type="number",
     *                 example=3000
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Фрукт создан.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=3
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Манго"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="number",
     *                     example=3000
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     * )
     */
    public function createFruit(Request $request)
    {
        // валидация
        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);

        // создание записи в таблице
        $fruit = new Fruit();
        $fruit->name = $request->input('name');
        $fruit->price = $request->input('price');
        $fruit->save();

        return new FruitResource($fruit);
    }

    public function deleteFruit($id)
    {
        $fruit = Fruit::find($id);

        $fruit->delete();

        return response()->json(['message' => 'Фрукт успешно удален']);
    }
}

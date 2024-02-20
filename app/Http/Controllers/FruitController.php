<?php

namespace App\Http\Controllers;

use App\Http\Resources\FruitResource;
use App\Models\Fruit;
use Illuminate\Http\Request;

class FruitController
{
    // метод для получения фруктов
    public function getFruits()
    {
        $fruits = Fruit::all();

        return FruitResource::collection($fruits);
    }

    public function getFruitById($id)
    {
        $fruit = Fruit::find($id);

        return new FruitResource($fruit);
    }

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

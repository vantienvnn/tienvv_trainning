<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Category;
use Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * The welcome board
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $categories = Category::query()->orderBy('created_at', 'desc')->get();
        return view('category/index', [
            'pageTitle' => 'Category Management',
            'categories' => $categories
        ]);
    }

    /**
     * Get a validator for an incoming create/update request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255'
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function postAdd(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
            $request, $validator
            );
        }
        $category = new Category($request->all());
        $category->save();
        $request->session()->flash('alert-success', 'Successfully saved.');
        return redirect('category');
    }

}

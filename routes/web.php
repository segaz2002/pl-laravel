<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('blog.index');
})->name('blog.index');

Route::get('post/{id}',function($id){
    if($id == 1){
        $post = [
            'title' => 'Post 1',
            'content' => 'Content for the first post'
        ];
    }else{
        $post = [
            'title' => 'Post 2',
            'content' => 'Content for the second post'
        ];
    }
    return view('blog.post', ['post' => $post]);
})->name('blog.post');

Route::get('about',function(){
    return view('other.about');
})->name('other.about');

Route::get('admin',function(){
    return view('admin.index');
})->name('admin.index');

Route::group(['prefix' => 'admin'], function(){
    Route::get('create',function(){
        return view('admin.create');
    })->name('admin.create');

    Route::post('create', function(\Illuminate\Http\Request $request, \Illuminate\Contracts\Validation\Factory $validator){
        $validation = $validator->make($request->all(),[
           'title' => 'required|min:5',
           'content' => 'required|min:10'
        ]);
        if($validation->fails()){
            return redirect()->back()->withErrors($validation);
        }
        return redirect()
            ->route('admin.index')
            ->with('info', 'Post created, Title: '. $request->input('title'));
    })->name('admin.create');

    Route::get('edit/{id}',function($id){
        if($id == 1){
            $post = [
                'title' => 'Post 1',
                'content' => 'Content for the first post'
            ];
        }else{
            $post = [
                'title' => 'Post 2',
                'content' => 'Content for the second post'
            ];
        }
        return view('admin.edit',['post' => $post]);
    })->name('admin.edit');

    Route::post('edit', function(\Illuminate\Http\Request $request, \Illuminate\Contracts\Validation\Factory $validator ){
        $validation = $validator->make($request->all(),[
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);
        if($validation->fails()){
            return redirect()->back()->withErrors($validation);
        }
        return redirect()
            ->route('admin.index')
            ->with('info', 'Post edited, new Title: '. $request->input('title'));
    })->name('admin.update');
});




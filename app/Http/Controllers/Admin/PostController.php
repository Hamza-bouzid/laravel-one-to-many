<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    protected $validation = [
        'title' => 'required|max:255',
        'content' => 'required',
        'category_id' => 'nullable|exists:categories,id',
        //'image' => 'nullable|image|mimes:jped,bmp,png'
     ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  
    public function index()
    {
        $posts = Post::all();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $request->validate($this->validation);

        //$newPost = Post::create($data);

        $slugTmp = Str::slug($data['title']);

        $count = 1;
        while(Post::where('slug', $slugTmp)->first()) {
            $slugTmp = Str::slug($data['title'])."-".$count;
            $count++;
        }

        if(isset($data['image'])) {
            //salvare l'immagine
            $img_path = Storage::put('uploads', $data['image']);
            // salvare il percorso sul post nel DB
            $data['image'] = $img_path;
        }

        $data['slug']= $slugTmp;
        $newPost = new Post();
        $newPost->fill($data);
        $newPost->save();

        return redirect()->route('admin.posts.show', $newPost->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->all();

        $request->validate($this->validation);

        //$newPost = Post::create($data);

        if($post->title == $data['title']) {
            $slugTmp = $post->slug;
        } else {
            $slugTmp = Str::slug($data['title']);
            $count = 1;
            while(Post::where('slug', $slugTmp)->where('id', '!=' , $post->id)->first()) {
                $slugTmp = Str::slug($data['title'])."-".$count;
                $count++;
            }
            
        }
        $data['slug']= $slugTmp;
        $post->update($data);

        return redirect()->route('admin.posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        
        return redirect()->route('admin.posts.index');
    }
}

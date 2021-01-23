<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Note;



class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
  
   public function index()
  {    
       $date = [];
       if (\Auth::check()) {
       $user =  \Auth::user();
       $notes= $user->notes()->orderBy('created_at', 'desc')->paginate(25);
       //$image = Storage::all();
       
       $data = [
           'user'=> $user,
           'notes'=> $notes,
       ];
       
     return view('notes.index', $data);
       }
    else {
    return view('welcome');
    }   

     
  }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        
        $note = new Note;

        return view('notes.create',[
            'note'=> $note,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request, [
             'status' => 'required|max:10', 
            'content' => 'required|max:191',
        ]);
           
        if(isset($image_path)){
            $image_path = $request->file('image')->store('public');
            $note->image_path = str_replace('public/', '', $image_path);
        }
        $note = new Note();
        $note->user_id = \Auth::user()->id;
        $note->status = $request->status;
        $note->content = $request->content;
        //$image_path = $request->file('image')->store('public');
        //$note->image_path = str_replace('public/', '', $image_path);
        
        
        $note->save();

        return redirect()->route('notes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note = \App\Note::find($id);
        //Storage::disk('local')->exists('public/storage/'.$notes->image);
        
        if (\Auth::id() === $note->user_id) {
            return view('notes.show', [
            'note' => $note, 'image_path'=>$note,
        ]);
        }
        else 
        return redirect('/');
         }   
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $note = \App\Note::find($id);
        
       if (\Auth::id() === $note->user_id) {
        return view('notes.edit', ['note' => $note,'image_path'=>$note,
        ]);
       }
        else {
        return redirect('/');
         }   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $note = \App\Note::find($id);
        
        if (\Auth::id() === $note->user_id) {
        $this->validate($request, [
            'status' => 'required|max:10', 
            'content' => 'required|max:191',
        ]);
         
          $image = $request->file('image');
          
        if($image){
            $image_path = $request->file('image')->store('public');
            $note->image_path = str_replace('public/', '', $image_path);
        }
        $note->status = $request->status;
        $note->content = $request->content;
        //$image_path = $request->file('image')->store('public');
        //$note->image_path = str_replace('public/', '', $image_path);
        $note->save();

        return redirect('/');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = \App\Note::find($id);
        
        if (\Auth::id() === $note->user_id) {
            $note->delete();
        
        return redirect('/');
    }
    }
    public function upload(Request $request)
    {
        
        $upload_image = $request->file('image');
        
        if($upload_image) {
//アップロードされた画像を保存する
            $path = $upload_image->store('public','storage');
            //画像の保存に成功したらDBに記録する
            if($path){
            UploadImage::create([
            "file_name" => $upload_image->getClientOriginalName(),
            "file_path" => $path
            ]);
            }
        }
        return redirect('notes.index');
    }
    }
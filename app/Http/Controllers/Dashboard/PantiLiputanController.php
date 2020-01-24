<?php

namespace App\Http\Controllers\Dashboard;

use Storage;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Panti;
use App\Models\PantiLiputan;
use App\Models\PantiLiputanGallery;

class PantiLiputanController extends Controller
{
    protected $file_location = 'img/panti/liputan';

    /**
     * Image Upload for Panti Gallery
     * 
     */
    private function imageUpload($files, $liputan_id = 0)
    {
        $arr_data = array();
        if(!empty($files)){
            foreach($files as $key => $file){
                if(!empty($file['validate'])){
                    // Modify Existing File/Data
                    $panti_gallery = PantiLiputanGallery::where('gallery_filename', $file['validate'])->first();
                    if(!empty($file['file'])){
                        // Remove old File
                        Storage::delete($this->file_location.'/'.$panti_gallery->gallery_fullname);

                        // Upload new File
                        $uploadedFile = $file['file'];        
                        $filename = 'pantiliputan_'.$liputan_id.'-'.(Carbon::now()->timestamp+rand(1,1000));
                        $fullname = $filename.'.'.strtolower($uploadedFile->getClientOriginalExtension());
                        $filesize = $uploadedFile->getSize();
                        $path = $uploadedFile->storeAs($this->file_location, $fullname);

                        // Save new Data
                        $panti_gallery->gallery_filename = $filename;
                        $panti_gallery->gallery_fullname = $fullname;
                        $panti_gallery->gallery_filesize = $filesize;
                        $panti_gallery->save();
                    }
                } else {
                    // Insert new File/Data
                    if(!empty($file['file'])){
                        $uploadedFile = $file['file'];        
                        $filename = 'pantiliputan_'.$liputan_id.'-'.(Carbon::now()->timestamp+rand(1,1000));
                        $fullname = $filename.'.'.strtolower($uploadedFile->getClientOriginalExtension());
                        $filesize = $uploadedFile->getSize();
                        $path = $uploadedFile->storeAs($this->file_location, $fullname);
    
                        $arr_data[] = new PantiLiputanGallery([
                            'gallery_filename' => $filename,
                            'gallery_fullname' => $fullname,
                            'gallery_filesize' => $filesize,
                        ]);
                    }
                }
            }
        }

        return $arr_data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.dashboard.panti.liputan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\PantiLiputan  $slug (slug)
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        $panti = Panti::where('panti_slug', $slug)->first();

        return view('content.dashboard.panti.liputan.create', compact('panti'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\PantiLiputan  $slug (slug)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($slug, Request $request)
    {
        $panti = Panti::where('panti_slug', $slug)->first();
        
        ($request->liputan_content == '<p><br/></p>' ? $request->merge(['liputan_content' => null]) : '');
        $vgallery = ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'];
        if(!empty($request->gallery)){
            $vgallery = ['required', 'mimes:jpg,jpeg,png', 'max:2048'];
        }
        $request->validate([
            'liputan_date' => ['required'],
            'liputan_content' => ['required', 'string'],
            'gallery.*.file' => $vgallery,
        ]);

        $liputan = new PantiLiputan;
        $liputan->panti_id = $panti->id;
        $liputan->author_id = $request->author_id;
        $liputan->editor_id = null;
        $liputan->liputan_date = $request->liputan_date;
        $liputan->liputan_content = $request->liputan_content;
        $liputan->save();

        // PantiGallery
        if(!empty($request->gallery)){
            $gallery = $this->imageUpload($request->gallery, $liputan->id);
            if(!empty($gallery)){
                $liputan->pantiLiputanGallery()->saveMany($gallery);
            }
        }

        return redirect()->route('dashboard.panti.show', $panti->panti_slug)->with([
            'action' => 'Liputan Store',
            'message' => 'Panti Liputan successfully added'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PantiLiputan  $slug (slug)
     * @return \Illuminate\Http\Response
     */
    public function show($slug, $id)
    {
        $panti = Panti::where('panti_slug', $slug)->first();
        $liputan = PantiLiputan::findOrFail($id);

        return view('content.dashboard.panti.liputan.show', compact('panti', 'liputan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PantiLiputan  $slug (slug)
     * @return \Illuminate\Http\Response
     */
    public function edit($slug, $id)
    {
        $panti = Panti::where('panti_slug', $slug)->first();
        $liputan = PantiLiputan::findOrFail($id);

        return view('content.dashboard.panti.liputan.edit', compact('panti', 'liputan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PantiLiputan  $slug (slug)
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $liputan = PantiLiputan::findOrFail($id);
        $panti = Panti::findOrFail($request->panti_id);

        ($request->liputan_content == '<p><br/></p>' ? $request->merge(['liputan_content' => null]) : '');
        $vgallery = ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'];
        if(!empty($request->gallery)){
            $vgallery = ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'];
        }
        $request->validate([
            'liputan_date' => ['required'],
            'liputan_content' => ['required', 'string'],
            'gallery.*.file' => $vgallery,
        ]);

        $liputan->panti_id = $request->panti_id;
        $liputan->liputan_date = $request->liputan_date;
        $liputan->liputan_content = $request->liputan_content;

        if($liputan->isDirty()){
            if($liputan->author_id != $request->author_id){
                $liputan->editor_id = $request->author_id;
            } else {
                $liputan->editor_id = null;
            }
        }
        $liputan->save();

        // PantiGallery
        if(!empty($request->gallery)){
            $gallery = $this->imageUpload($request->gallery, $liputan->id);
            if(!empty($gallery)){
                $liputan->pantiLiputanGallery()->saveMany($gallery);
            }
        } else {
            if($liputan->pantiLiputanGallery()->exists()){
                foreach($liputan->pantiLiputanGallery as $value){
                    Storage::delete($this->file_location.'/'.$value->gallery_fullname);
                }
                // Delete All Gallery
                $liputan->pantiLiputanGallery()->delete();
            }
        }

        return redirect()->route('dashboard.panti.show', $panti->panti_slug)->with([
            'action' => 'Liputan Store',
            'message' => 'Panti Liputan successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PantiLiputan  $slug (slug)
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        //
    }

    /**
     * DataTable
     */
    public function datatableAll()
    {
        $data = PantiLiputan::query();

        if(isset($_GET['panti_id'])){
            $data->where('panti_id', $_GET['panti_id']);
        }

        return datatables()
            ->of($data->with('author', 'editor', 'panti'))
            ->toJson();
    }
}

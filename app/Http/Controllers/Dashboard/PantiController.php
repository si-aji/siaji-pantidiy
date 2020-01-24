<?php

namespace App\Http\Controllers\Dashboard;

use Storage;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Provinsi;
use App\Models\Panti;
use App\Models\PantiGallery;
use App\Models\PantiContact;
use App\Models\PantiLiputan;

class PantiController extends Controller
{
    protected $contact_type;
    protected $file_location = 'img/panti';

    public function __construct()
    {
        $this->contact_type = [
            'facebook',
            'twitter',
            'instagram',
            'website',
            'email',
            'whatsapp',
            'phone'
        ];
    }

    /**
     * Image Upload for Panti Gallery
     * 
     */
    private function imageUpload($files, $panti_id = 0)
    {
        $arr_data = array();
        if(!empty($files)){
            foreach($files as $key => $file){
                if(!empty($file['validate'])){
                    // Modify Existing File/Data
                    $panti_gallery = PantiGallery::where('gallery_filename', $file['validate'])->first();
                    if(!empty($file['file'])){
                        // Remove old File
                        Storage::delete($this->file_location.'/'.$panti_gallery->gallery_fullname);

                        // Upload new File
                        $uploadedFile = $file['file'];        
                        $filename = 'panti_'.$panti_id.'-'.(Carbon::now()->timestamp+rand(1,1000));
                        $fullname = $filename.'.'.strtolower($uploadedFile->getClientOriginalExtension());
                        $filesize = $uploadedFile->getSize();
                        $path = $uploadedFile->storeAs($this->file_location, $fullname);

                        // Save new Data
                        $panti_gallery->gallery_filename = $filename;
                        $panti_gallery->gallery_fullname = $fullname;
                        $panti_gallery->gallery_filesize = $filesize;
                    }
                    $panti_gallery->is_thumb = !empty($file['is_thumb']) ? true : false;
                    $panti_gallery->save();
                } else {
                    // Insert new File/Data
                    if(!empty($file['file'])){
                        $uploadedFile = $file['file'];        
                        $filename = 'panti_'.$panti_id.'-'.(Carbon::now()->timestamp+rand(1,1000));
                        $fullname = $filename.'.'.strtolower($uploadedFile->getClientOriginalExtension());
                        $filesize = $uploadedFile->getSize();
                        $path = $uploadedFile->storeAs($this->file_location, $fullname);
    
                        $arr_data[] = new PantiGallery([
                            'gallery_filename' => $filename,
                            'gallery_fullname' => $fullname,
                            'gallery_filesize' => $filesize,
                            'is_thumb' => !empty($file['is_thumb']) ? true : false
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
        $province = Provinsi::orderBy('provinsi_name', 'asc')->get();
        return view('content.dashboard.panti.index', compact('province'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $province = Provinsi::orderBy('provinsi_name', 'asc')->get();
        $contact_type = $this->contact_type;
        return view('content.dashboard.panti.create', compact('province', 'contact_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ($request->provinsi_id == 'none' ? $request->merge(['provinsi_id' => null]) : '');
        ($request->kabupaten_id == 'none' ? $request->merge(['kabupaten_id' => null]) : '');
        ($request->kecamatan_id == 'none' ? $request->merge(['kecamatan_id' => null]) : '');
        ($request->panti_description == '<p><br/></p>' ? $request->merge(['panti_description' => null]) : '');

        $vgallery = ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'];
        $vprovinsi_id = $vkabupaten_id = $vkecamatan_id = ['nullable'];
        if(!empty($request->provinsi_id)){
            $vprovinsi_id = $vkabupaten_id = $vkecamatan_id = ['required'];
        }
        if(!empty($request->gallery)){
            $vgallery = ['required', 'mimes:jpg,jpeg,png', 'max:2048'];
        }

        $request->validate([
            'provinsi_id' => $vprovinsi_id,
            'kabupaten_id' => $vkabupaten_id,
            'kecamatan_id' => $vkecamatan_id,
            'gallery.*.file' => $vgallery,

            'panti_name' => ['required', 'string', 'max:255'],
            'panti_slug' => ['required', 'string', 'max:255', 'unique:sa_panti,panti_slug'],
            'panti_address' => ['required', 'string'],
            'panti_description' => ['required', 'string'],
            'data_contact.*.contact_value' => ['required'],
        ]);

        $panti = new Panti;
        $panti->provinsi_id = $request->provinsi_id;
        $panti->kabupaten_id = $request->kabupaten_id;
        $panti->kecamatan_id = $request->kecamatan_id;
        $panti->panti_name = $request->panti_name;
        $panti->panti_slug = $request->panti_slug;
        $panti->panti_alamat = $request->panti_address;
        $panti->panti_description = $request->panti_description;
        $panti->save();

        // PantiGallery
        if(!empty($request->gallery)){
            $gallery = $this->imageUpload($request->gallery, $panti->id);
            if(!empty($gallery)){
                $panti->pantiGallery()->saveMany($gallery);
            }
        }

        // PantiContact
        $panti->pantiContact()->saveMany($this->pantiContact($request->data_contact));

        return redirect()->route('dashboard.panti.index')->with([
            'action' => 'Store',
            'message' => 'Panti successfully added'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Panti  $panti
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $liputan = null;
        $panti = Panti::where('panti_slug', $id)->firstOrFail();
        if($panti->pantiLiputan()->exists()){
            $liputan = PantiLiputan::where('panti_id', $panti->id)->orderBy('liputan_date', 'desc')->get();
        }
        return view('content.dashboard.panti.show', compact('panti', 'liputan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Panti  $panti
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact_type = $this->contact_type;
        $panti = Panti::wherePantiSlug($id)->first();
        $province = Provinsi::orderBy('provinsi_name', 'asc')->get();
        return view('content.dashboard.panti.edit', compact('panti', 'province', 'contact_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Panti  $panti
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        ($request->provinsi_id == 'none' ? $request->merge(['provinsi_id' => null]) : '');
        ($request->kabupaten_id == 'none' ? $request->merge(['kabupaten_id' => null]) : '');
        ($request->kecamatan_id == 'none' ? $request->merge(['kecamatan_id' => null]) : '');
        ($request->panti_description == '<p><br/></p>' ? $request->merge(['panti_description' => null]) : '');

        $vgallery = ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'];
        $vprovinsi_id = $vkabupaten_id = $vkecamatan_id = ['nullable'];
        if(!empty($request->provinsi_id)){
            $vprovinsi_id = $vkabupaten_id = $vkecamatan_id = ['required'];
        }
        if(!empty($request->gallery)){
            $vgallery = ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'];
        }

        $request->validate([
            'provinsi_id' => $vprovinsi_id,
            'kabupaten_id' => $vkabupaten_id,
            'kecamatan_id' => $vkecamatan_id,
            'gallery.*.file' => $vgallery,

            'panti_name' => ['required', 'string', 'max:255'],
            'panti_slug' => ['required', 'string', 'max:255', 'unique:sa_panti,panti_slug,'.$id],
            'panti_address' => ['required', 'string'],
            'panti_description' => ['required', 'string'],
            'data_contact.*.contact_value' => ['required'],
        ]);

        $panti = Panti::findOrFail($id);
        $panti->provinsi_id = $request->provinsi_id;
        $panti->kabupaten_id = $request->kabupaten_id;
        $panti->kecamatan_id = $request->kecamatan_id;
        $panti->panti_name = $request->panti_name;
        $panti->panti_slug = $request->panti_slug;
        $panti->panti_alamat = $request->panti_address;
        $panti->panti_description = $request->panti_description;
        $panti->save();

        // PantiGallery
        if(!empty($request->gallery)){
            $gallery = $this->imageUpload($request->gallery, $panti->id);
            if(!empty($gallery)){
                $panti->pantiGallery()->saveMany($gallery);
            }
        } else {
            if($panti->pantiGallery()->exists()){
                foreach($panti->pantiGallery as $value){
                    Storage::delete($this->file_location.'/'.$value->gallery_fullname);
                }
                // Delete All Gallery
                $panti->pantiGallery()->delete();
            }
        }

        if($request->has('data_contact')){
            // Request has Data Contact
            if($panti->pantiContact()->exists()){
                $panti->pantiContact()->delete();
            }
            
            // PantiContact
            $panti->pantiContact()->saveMany($this->pantiContact($request->data_contact));
        } else {
            // No Data Contact
            if($panti->pantiContact()->exists()){
                $panti->pantiContact()->delete();
            }
        }

        return redirect()->route('dashboard.panti.index')->with([
            'action' => 'Update',
            'message' => 'Panti successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Panti  $panti
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Save Contact Panti
     * 
     */
    protected function pantiContact($contact = null)
    {
        $contactArr = array();
        if(!empty($contact)){
            foreach($contact as $key => $value){
                if($value['contact_value'] != ""){
                    $contactArr[] = new PantiContact([
                        'contact_type' => $value['contact_type'],
                        'contact_value' => $value['contact_value'],
                    ]);
                }
            }
        }

        return $contactArr ?? null;
    }

    /**
     * DataTable
     */
    public function datatableAll()
    {
        // DB::enableQueryLog();
        $data = Panti::query();

        if($_GET['filter'] == 'filtered'){
            if($_GET['provinsi'] != 'none'){
                $data->where('provinsi_id', $_GET['provinsi']);
            }

            if($_GET['kabupaten'] != 'none'){
                $data->where('kabupaten_id', $_GET['kabupaten']);
            }

            if($_GET['kecamatan'] != 'none'){
                $data->where('kecamatan_id', $_GET['kecamatan']);
            }
        }

        return datatables()
            ->of($data->with('provinsi', 'kabupaten', 'kecamatan'))
            ->toJson();
    }

    /**
     * Select2
     */
    public function select2(Request $request)
    {
        $data = Panti::query();
        $last_page = null;
        if($request->has('search') && $request->search != ''){
            // Apply search param
            $data = $data->orWhereHas('provinsi', function($query) use ($request){
                $query->where('provinsi_name', 'like', '%'.$request->search.'%');
            })->orWhereHas('kabupaten', function($query) use ($request){
                $query->where('kabupaten_name', 'like', '%'.$request->search.'%');
            })->orWhereHas('kecamatan', function($query) use ($request){
                $query->where('kecamatan_name', 'like', '%'.$request->search.'%');
            })->orWhere('panti_name', 'like', '%'.$request->search.'%');
        }

        $data->with('provinsi', 'kabupaten', 'kecamatan');
        if($request->has('page')){
            $data->paginate(10);
            $last_page = $data->paginate(10)->lastPage();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data Fetched',
            'last_page' => $last_page,
            'data' => $data->get(),
        ]);
    }
}

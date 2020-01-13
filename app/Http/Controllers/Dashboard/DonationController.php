<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.dashboard.donation.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.dashboard.donation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate_end = ['nullable'];
        if($request->donation_description == '<p><br/></p>'){
            $request->merge(['donation_description' => null]);
        }
        if($request->donation_hasdeadline == 'true'){
            $validate_end = ['required'];
        }
        $request->validate([
            'panti_id' => ['required', 'exists:sa_panti,id'],
            'donation_title' => ['nullable', 'string', 'max:191'],
            'donation_description' => ['required', 'string'],
            'donation_start' => ['required'],
            'donation_end' => $validate_end,
            'amount_needed' => ['required', 'numeric', 'min:0']
        ]);

        $donation = new Donation;
        $donation->panti_id = $request->panti_id;
        $donation->donation_title = $request->donation_title;
        $donation->donation_description = $request->donation_description;
        $donation->donation_start = date('Y-m-d', strtotime($request->donation_start));
        $donation->donation_hasdeadline = $request->donation_hasdeadline == 'true' ? true : false;
        $donation->donation_end = $request->donation_hasdeadline == 'true' ? date('Y-m-d', strtotime($request->donation_end)) : null;
        $donation->donation_needed = $request->amount_needed;
        $donation->save();

        return redirect()->route('dashboard.donation.index')->with([
            'action' => 'Store',
            'message' => 'Donation successfully added'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $donation = Donation::findOrFail($id);
        return view('content.dashboard.donation.show', compact('donation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $donation = Donation::findOrFail($id);
        return view('content.dashboard.donation.edit', compact('donation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate_end = ['nullable'];
        if($request->donation_description == '<p><br/></p>'){
            $request->merge(['donation_description' => null]);
        }
        if($request->donation_hasdeadline == 'true'){
            $validate_end = ['required'];
        }
        $request->validate([
            // 'panti_id' => ['required', 'exists:sa_panti,id'],
            'donation_title' => ['nullable', 'string', 'max:191'],
            'donation_description' => ['required', 'string'],
            'donation_start' => ['required'],
            'donation_end' => $validate_end,
            'amount_needed' => ['required', 'numeric', 'min:0']
        ]);

        $donation = Donation::findOrFail($id);
        // $donation->panti_id = $request->panti_id;
        $donation->donation_title = $request->donation_title;
        $donation->donation_description = $request->donation_description;
        $donation->donation_start = date('Y-m-d', strtotime($request->donation_start));
        $donation->donation_hasdeadline = $request->donation_hasdeadline == 'true' ? true : false;
        $donation->donation_end = $request->donation_hasdeadline == 'true' ? date('Y-m-d', strtotime($request->donation_end)) : null;
        $donation->donation_needed = $request->amount_needed;
        $donation->save();

        return redirect()->route('dashboard.donation.index')->with([
            'action' => 'Update',
            'message' => 'Donation successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * DataTable
     */
    public function datatableAll()
    {
        // DB::enableQueryLog();
        $data = Donation::query();

        return datatables()
            ->of($data->with('panti'))
            ->toJson();
    }
}

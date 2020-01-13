<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.dashboard.event.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.dashboard.event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->event_description == '<p><br/></p>'){
            $request->merge(['event_description' => null]);
        }
        $request->validate([
            'event_title' => ['required', 'string', 'max:191', 'unique:sa_event,event_title'],
            'event_slug' => ['required', 'string', 'max:191', 'unique:sa_event,event_slug'],
            'event_thumbnail' => ['nullable', 'mimes:jpg,jpeg,png'],
            'event_description' => ['required', 'string'],
            'event_start' => ['required'],
            'event_end' => ['required'],
            'event_place' => ['nullable']
        ]);

        $event = new Event;
        $event->event_title = $request->event_title;
        $event->event_slug = $request->event_slug;
        $event->event_description = $request->event_description;
        $event->event_start = date('Y-m-d H:i:00', strtotime($request->event_start));
        $event->event_end = date('Y-m-d H:i:00', strtotime($request->event_end));
        $event->event_place = $request->event_place;
        $event->save();

        return redirect()->route('dashboard.event.index')->with([
            'action' => 'Store',
            'message' => 'Event successfully added'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::where('event_slug', $id)->firstOrFail();
        return view('content.dashboard.event.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::where('event_slug', $id)->firstOrFail();
        return view('content.dashboard.event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = Event::where('event_slug', $id)->firstOrFail();

        if($request->event_description == '<p><br/></p>'){
            $request->merge(['event_description' => null]);
        }
        $request->validate([
            'event_title' => ['required', 'string', 'max:191', 'unique:sa_event,event_title,'.$event->id],
            'event_slug' => ['required', 'string', 'max:191', 'unique:sa_event,event_slug,'.$event->id],
            'event_thumbnail' => ['nullable', 'mimes:jpg,jpeg,png'],
            'event_description' => ['required', 'string'],
            'event_start' => ['required'],
            'event_end' => ['required'],
            'event_place' => ['nullable']
        ]);

        $event->event_title = $request->event_title;
        $event->event_slug = $request->event_slug;
        $event->event_description = $request->event_description;
        $event->event_start = date('Y-m-d H:i:00', strtotime($request->event_start));
        $event->event_end = date('Y-m-d H:i:00', strtotime($request->event_end));
        $event->event_place = $request->event_place;
        $event->save();

        return redirect()->route('dashboard.event.index')->with([
            'action' => 'Update',
            'message' => 'Event successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
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
        $data = Event::query();

        return datatables()
            ->of($data)
            ->toJson();
    }
}

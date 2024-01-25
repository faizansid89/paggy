<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->section = new \stdClass();
        $this->section->title = 'Sales';
        $this->section->heading = 'Sales';
        $this->section->slug = 'sales';
        $this->section->folder = 'sales';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //checkPermission('read-sale');
        $section = $this->section;
        $branches = Branch::where('status',1)->get();

        $s = Sale::query();
        $s = $s->with(['sales_items']);
        // filters here
        if(!empty($request->from_date) || !empty($request->to_date)){
            $to = \Carbon\Carbon::parse($request->to_date)->format('Y-m-d');
            $from = \Carbon\Carbon::parse($request->from_date)->addDay()->format('Y-m-d');
            $s->whereBetween('created_at', [$to, $from]);
        }
        if(isset($request->branch_id)){
            $s->where('branch_id', $request->branch_id);
        }
        $sales = $s->get();

        return view($section->folder . '.index', compact('sales', 'section','branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $section = $this->section;
        $section->title = 'Sales';
        $sale = Sale::with('sales_items')->where('sale_auto_id', $id)->first();
//        dd($id, $sale->toArray());
        return view($section->folder . '.show', compact('sale',  'section'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function updateContent($id)
    {

    }
}

<?php

namespace App\Http\Controllers\Company;

use App\Company;
use App\Filters\TemplateFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\TemplateRequest;
use App\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TemplateFilter $templateFilter)
    {
        $company = auth()->user()->company;

        $templates = Template::
        where('company_id', $company->id)
        ->orWhere('company_id', null)
        ->filter($templateFilter)
        ->paginate(15);

        return response()->json($templates);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TemplateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TemplateRequest $request)
    {
        $company = auth()->user()->company;

        $data = $request->validated();

        $template = new Template();
        $template->fill($data);
        $template->company_id = $company->id;
        $template->save();

        return response()->json($template);
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $template = Template::where('company_id', company()->id)->orWhere('company_id', null)->findOrFail($id);

        return response()->json($template);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TemplateRequest  $request
     * @param string $slug
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TemplateRequest $request, $id)
    {
        $data = $request->validated();

        $template = Template::where('company_id', company()->id)->findOrFail($id);
        $template->fill($data);
        $template->save();

        return response()->json($template, 201);

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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Image;

class ImageController extends Controller
{
    private $imm;

    public function __construct(Image $imm) {
        $this->middleware('api');

        $this->imm = $imm;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        $q = $r->input('q');
        $l = $r->input('l');
        $o = $r->input('o');

        if (empty($q)) $q = '';
        if (empty($l)) $l = 10;
        if (empty($o)) $o = 0;

        return $this->imm->search($q, $l, $o);
    }
    
    public function upload(Request $r) {
        if ($r->hasFile('image')) {
            if ($r->image->isValid()) {
                return $this->imm->create($r->image->path());
            }
            throw new \Exception("Upload invalid or damaged");
        }
        throw new \Exception("Image not uploaded");
    }

    public function attach(Request $r) {
        $ids = $r->input('images');
        $domain = $r->input('domain');
        $slug = $r->input('slug');
        $cnt = $this->imm->attach($ids, $domain, $slug);
        return ['attached' => $cnt];
    }

    public function display_all($domain, $profile, $density, $slug, $index) {
        $bytes = $this->imm->display($slug, $domain, $index, $profile, $density);

        $response = Response::make($bytes);
        $response->header('Content-Type', 'image/jpg');
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
}

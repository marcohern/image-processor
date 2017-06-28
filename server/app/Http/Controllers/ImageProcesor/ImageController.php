<?php

namespace App\Http\Controllers\ImageProcesor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use App\Models\ImageProcesor\Image;

class ImageController extends Controller
{
    private $imm; // Image Model

    /**
     * Constructor
     * @param App\Models\Image $imm Image Model
     */
    public function __construct(Image $imm) {
        $this->middleware('api');

        $this->imm = $imm;
    }

    /**
     * Returns a list of image records (not the images themselves).
     * @param $r Request
     * @return List of images
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
    
    /**
     * Receives an uploaded image.
     * @param $r Request.
     */
    public function upload(Request $r) {
        if ($r->hasFile('image')) {
            if ($r->image->isValid()) {
                return $this->imm->create($r->image->path());
            }
            throw new \Exception("Upload invalid or damaged");
        }
        throw new \Exception("Image not uploaded");
    }

    /**
     * Attach an image to a domain and slug.
     * The imputs are provided in the request as a json object.
     * @param $r Request.
     * @param $r.images Array of images
     * @param $r.domain Domain
     * @param $r.slug Slug.
     */
    public function attach(Request $r) {
        $ids = $r->input('images');
        $domain = $r->input('domain');
        $slug = $r->input('slug');
        $cnt = $this->imm->attach($ids, $domain, $slug);
        return ['attached' => $cnt];
    }

    /**
     * Display's an image
     * @param $domain Domain
     * @param $profile Profile
     * @param $density Density
     * @param $slug Image slug
     * @param $index Index
     */
    public function display_all($domain, $profile, $density, $slug, $index) {
        $bytes = $this->imm->display($slug, $domain, $index, $profile, $density);

        $response = Response::make($bytes);
        $response->header('Content-Type', 'image/jpg');
        return $response;
    }

    /**
     * Display's an image
     * @param $domain Domain
     * @param $slug Image slug
     * @param $index Index
     */
    public function display_dsi($domain, $slug, $index) {
        $bytes = $this->imm->display($slug, $domain, $index, 'org', 'org');

        $response = Response::make($bytes);
        $response->header('Content-Type', 'image/jpg');
        return $response;
    }

    /**
     * Display's an image
     * @param $slug Image slug
     * @param $index Index
     */
    public function display_si($slug, $index) {
        $bytes = $this->imm->display($slug, 'global', $index, 'org', 'org');

        $response = Response::make($bytes);
        $response->header('Content-Type', 'image/jpg');
        return $response;
    }

    /**
     * Display's an image
     * @param $domain Domain
     * @param $profile Profile
     * @param $density Density
     * @param $slug Image slug
     */
    public function display_dxs($domain, $profile, $density, $slug) {
        $bytes = $this->imm->display($slug, $domain, 0, $profile, $density);

        $response = Response::make($bytes);
        $response->header('Content-Type', 'image/jpg');
        return $response;
    }

    /**
     * Display's an image
     * @param $domain Domain
     * @param $slug Image slug
     */
    public function display_ds($domain, $slug) {
        $bytes = $this->imm->display($slug, $domain, 0, 'org', 'org');

        $response = Response::make($bytes);
        $response->header('Content-Type', 'image/jpg');
        return $response;
    }

    /**
     * Display's an image
     * @param $slug Image slug
     */
    public function display_s($slug) {
        $bytes = $this->imm->display($slug, 'global', 0, 'org', 'org');

        $response = Response::make($bytes);
        $response->header('Content-Type', 'image/jpg');
        return $response;
    }

    /**
     * Returns the record of specified image
     *
     * @param  int  $id Image ID
     * @return Image record
     */
    public function show($id)
    {
        return $this->imm->view($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->imm->erase($id);
    }
}

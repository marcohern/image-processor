<?php

namespace App\Models;

use App\Lib\Dpi;
use Illuminate\Database\Eloquent\Model;
use InterventionImage;

class Image extends Model
{
    protected $hidden = [
        'bytes'
    ];

    //
    public function search($q='', $limit=10, $offset=0) {
        $query = $this->take($limit)->skip($offset);
        if (!empty($q)) {
            $q->where('slug','LIKE',"%$q%");
        }
        return $query->get();
    }

    public function view($id) {
        $image = $this->where('id',$id)->first();
        if (empty($image)) throw new \Exception("Image not found");
        return $image;
    }

    public function bytes($id) {
        $image = $this->select('bytes')->where('id',$id)->first();
        if (empty($image)) throw new \Exception("Image not found");
        return $image->bytes;
    }

    public function create($filepath) {
        $im = InterventionImage::make($filepath);
        $slug = md5(uniqid());
        $id = $this->insertGetId([
            'attached' => 'FALSE',
            'domain' => 'tmp',
            'slug' => $slug,
            'index' => 0,
            'profile' => 'org',
            'density' => 'org',
            'ext' => 'jpg',
            'width' => $im->width(),
            'height' => $im->height(),
            'parent_id' => null,

            'bytes' => $im->encode('jpg'),

            'created_at' => new \Datetime("now")
        ]);
        $image = $this->where('id',$id)->first();
        return $image;
    }

     public function attach($ids, $domain, $slug) {
        $i=0;
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $this->where('id',$id)->update([
                    'domain' => $domain,
                    'slug' => $slug,
                    'index' => $i,
                    'attached' => 'TRUE',
                    'updated_at' => new \Datetime("now")
                ]);
                $i++;
            }
        } else {
            $i=1;
            $this->where('id',$ids)->update([
                'domain' => $domain,
                'slug' => $slug,
                'index' => 0,
                'attached' => 'TRUE',
                'updated_at' => new \Datetime("now")
            ]);
        }
        return $i;
    }

    public function display($slug, $domain='global', $index=0,$profile='org',$density='org') {
        $bytes = null;
        $ext = 'jpg';
        $record = $this->select('bytes')
            ->where('domain' , $domain)
            ->where('slug'   , $slug)
            ->where('index'  , $index)
            ->where('profile', $profile)
            ->where('density', $density)
            ->first();
        if (empty($image)) {
            $record = $this->select('bytes')
                ->where('domain' , $domain)
                ->where('slug'   , $slug)
                ->where('index'  , $index)
                ->where('profile', 'org')
                ->where('density', 'org')
                ->first();

            if (empty($image)) {
                throw new \Exception("Image not found");
            }

            $size = Dpi::size($profile,$density);

            $image = InterventionImage::make($record['bytes'])->fit($size[0],$size[1]);
            $bytes = $image->encode($ext);
            $this->insertGetId([
                'domain' => $domain,
                'slug' => $slug,
                'index' => $index,
                'profile' => $profile,
                'density' => $density,
                'ext' => $ext,
                'width' => $size[0],
                'height' => $size[1],
                'parent_id' => $record->id,
                'created_at' => new \Datetime("now")
            ]);

        } else {
            $bytes = $record->bytes;
        }
        return $bytes;
    }
}

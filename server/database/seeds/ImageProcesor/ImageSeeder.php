<?php

use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path().'/database/seeds/ImageProcesor/images';
        $files = [
            'helix_nebula',
            'big_ben'
        ];
        $n = count($files);

        $model = App::make(App\Models\ImageProcesor\Image::class);
        for ($i=0;$i<$n;$i++) {
            $file = $files[$i];
            $record = $model->create("$path/$file.jpg");
            $model->attach($record->id, "global", $file);
        }
    }
}

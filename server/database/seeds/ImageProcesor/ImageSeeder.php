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
            'big_ben',
            'curiosity_mars_rover'
        ];
        $n = count($files);
        $model = App::make(App\Models\ImageProcesor\Image::class);

        for ($i=0;$i<$n;$i++) {
            $file = $files[$i];
            $this->saveImages($model, $path, $file);
        }
    }

    private function saveImages($model, $path, $file) {
        $filepath = "$path/$file.0.jpg";
        if (file_exists($filepath)) {
            $i=1;
            $ids = [];
            while (file_exists($filepath)) {
                $record = $model->create($filepath);
                $filepath = "$path/$file.$i.jpg";
                $ids[] = $record->id;
                $i++;
            }
            $model->attach($ids, "seed", $file);
        } else {
            $filepath = "$path/$file.jpg";
            if (file_exists($filepath)) {
                $record = $model->create($filepath);
                $model->attach($record->id, "seed", $file);
            }
        }
    }
}

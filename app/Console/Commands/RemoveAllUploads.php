<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RemoveAllUploads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uploads:remove {--confirm=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all files existing in the folders inside uploads directory';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $confirm = $this->option('confirm');
        if ($confirm == '10_10_1992') {

            $files_count = 0;
            $uploads_folders = array_diff(scandir('uploads'), array('.', '..', '.gitignore'));
            foreach ($uploads_folders as $folder) {
                foreach (array_diff(scandir('uploads/' . $folder), array('.', '..', '.gitignore')) as $image) {
                    $files_count++;
                }
            }
            if ($files_count > 0) {
                $bar = $this->output->createProgressBar($files_count);
                $bar->start();
                foreach ($uploads_folders as $folder) {
                    foreach (array_diff(scandir('uploads/' . $folder), array('.', '..', '.gitignore')) as $image) {
                        unlink('uploads/' . $folder . '/' . $image);
                        $bar->advance();
                    }
                }
                $bar->finish();
                $this->info("\nFiles removed successfully");
            } else {
                $this->info("There are no Files to be removed");
            }
        }
    }
}

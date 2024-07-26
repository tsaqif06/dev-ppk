<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HelperGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:helper {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat helper baru dengan nama yang ditentukan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $helperName = $this->argument('name');
        $helperPath = app_path("Helpers/{$helperName}.php");

        if (file_exists($helperPath)) {
            $this->error("Helper {$helperName} sudah ada.");
            return;
        }

        $content = "<?php\n\nnamespace App\Helpers;\n\nclass {$helperName}\n{\n    // Tambahkan fungsi di sini\n}\n";

        try {
            file_put_contents($helperPath, $content);
            $this->info("Helper {$helperName} berhasil dibuat di {$helperPath}");
        } catch (\Exception $e) {
            $this->error("Gagal membuat helper: " . $e->getMessage());
        }
    }
}

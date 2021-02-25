<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use setasign\Fpdi\Fpdi;
use File;

class AddLogos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logos:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add logo of CI and EU to pdfs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $path = './storage/onepagers/';
        $outputPath = './storage/onepagersOutput/';
        $imagePath = './resources/images/logos/';
        $ciLogo = 'CI_puvodni.png';
        $euLogo = 'Logo OPZ_origo.jpg';

        $files = File::allFiles($path);

        if (!File::exists($outputPath)) {
            File::makeDirectory($outputPath, $mode = 0777, true, true);
        }
        foreach ($files as $file) {
            $pdfName = $file->getRelativePathName();
            $folder = $file->getRelativePath();
            $pdfFile = sprintf('%s%s',$path, $pdfName);
            exec(
                sprintf(
                    'gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dBATCH -sOutputFile=\'%s.v14\' \'%s\'',
                    $pdfFile,
                    $pdfFile
                )
            );

            $pages = $this->countPages(sprintf('%s.v14', $pdfFile));

            $pdf = new FPDI();
            $pdf->setSourceFile(sprintf('%s.v14', $pdfFile));
            for ($i = 1; $i <= $pages; $i++) {
                $pdf->AddPage();
                $template = $pdf->importPage($i);
                $pdf->useTemplate($template);
                $pdf->Image($imagePath . $ciLogo, 120, 5, 25, 10);
                $pdf->Image($imagePath . $euLogo, 151, 5, 49, 10);
            }
            if (!File::exists($outputPath . $folder)) {
                File::makeDirectory($outputPath . $folder, $mode = 0777, true, true);
            }
            $pdf->Output($outputPath . $pdfName, 'F');
            File::delete(sprintf('%s.v14', $pdfFile));
        }
    }

    private function countPages($path)
    {
        $pdftext = file_get_contents($path);
        $num = preg_match_all('/\/Page\W/', $pdftext, $dummy);
        return $num;
    }
}

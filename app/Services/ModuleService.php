<?php

namespace App\Services;
use ZipArchive;

class ModuleService
{

	public function downloadModule($module){
		$zip = new ZipArchive;
		$zipFileName = 'module.zip';
		$zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
		$zip->addFromString('index.html', $this->generateHtmlFile());
		$zip->addFromString('style.css', $this->generateCssFile($module));
		$zip->addFromString('script.js', $this->generateJsFile($module->link));
		$zip->close();

		return response()->download($zipFileName)->deleteFileAfterSend(true);
	}


    private function generateHtmlFile(){
		return <<<HTML
			<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<title>Web module</title>
				<link rel="stylesheet" href="style.css">
				<script defer src="script.js"></script>
			</head>
			<body>
				<div class="container">
					<div class="module" id="module">
					</div>
				</div>
			</body>
			</html>
		HTML;
    }

	private function generateCssFile($module){
		$width = $module->width;
        $height = $module->height;
        $color = $module->color;

		return <<<CSS
			.container {
				width: 500px;
				height: 500px;
				border: solid #222831 0.5px;
			}

			.module {
				width: $width;
				height: $height;
				background-color: $color;
				cursor: pointer;
			}
		CSS;
	}

	private function generateJsFile($url){
		return <<<JS
			document.getElementById("module").addEventListener("click", () => {
				window.open("$url")
			})
		JS;
	}
}
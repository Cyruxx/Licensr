<?php

class LicenseController extends BaseController
{
    public function index()
    {
        return View::make('index');
    }

    public function process()
    {
        Input::flash();


        if (!Input::hasFile('licenseFiles')) {
            return Redirect::to('/')->with('error', true)->with('message',
                'We could not find any uploaded text files. Please try again.');
        }

        $aFileWithBadEndings = [];
        foreach (Input::file('licenseFiles') as $oFile) {
            if (!str_is('text/*', $oFile->getMimeType())) {
                $aFileWithBadEndings[] = $oFile;
            }
        }

        if (count($aFileWithBadEndings) > 0) {
            $sBadFiles = '';
            foreach ($aFileWithBadEndings as $oBadFile) {
                $sBadFiles .= '<li>' . $oBadFile->getClientOriginalName() . '</li>';
            }
            return Redirect::to('/')->with('error', true)->with('message',
                'The following files are no text-files: <ul>' . $sBadFiles . '</ul>');
        }

        $sZipGuid = str_random(8);
        $aLicenseNames = ['MIT', 'Apache 2.0', 'GPL v2', 'GPL v3'];
        $sSelectedLicense = $aLicenseNames[intval(Input::get('licenseType'))];

        // Prepare zipping
        foreach(Input::file('licenseFiles') as $oFile) {
            $sFileName = $sZipGuid . '_' . $oFile->getClientOriginalName();
            $oFile->move(app_path('storage/licenses/'), $sFileName);

            $sLicenseText = Input::get('commentStart') . "\n    Copyright (c) " . date('Y') . " " . Input::get('contributors') . "\n\n" .
                            "    This file is part of the '" . Input::get('projectName') . "' project.\n" .
                            "    It uses the " . $sSelectedLicense . " license.\n\n" .
                            "    For more information about your permission to use, copy, modify, merge, publish,\n" .
                            "    distribute, sublicense and/or sell copies of this software, and to permit persons to whom\n" .
                            "    the software is furnished to do so, please visit the official website of the " . $sSelectedLicense . " license.\n"
                            . Input::get('commentEnd') . "\n\n";

            File::prepend(app_path('storage/licenses/' . $sFileName), $sLicenseText);
        }

        $aFiles = File::glob(app_path('storage/licenses/' . $sZipGuid . '_*.*'));
        $oZip = new ZipArchive();
        $oZip->open(app_path('storage/licenses/' . $sZipGuid . '.zip'), ZipArchive::CREATE);

        foreach($aFiles as $sFilePath) {
            $oZip->addFile(str_replace('/', '\\', $sFilePath));
        }

        $oZip->close();

        // Delete all files
        foreach($aFiles as $sFile) {
            File::delete($sFile);
        }

        return View::make('index', ['sZipGuid' => $sZipGuid]);
    }

    public function download($sHash)
    {
        $sFile = app_path('storage/licenses/' . $sHash . '.zip');

        if(!File::exists($sFile)) {
            return Redirect::to('/')->with('error', true)->with('message',
                'This file does not exist anymore.');
        }

        App::finish(function($request, $response) use ($sFile) {
            File::delete($sFile);
        });

        return Response::download($sFile);
    }
}
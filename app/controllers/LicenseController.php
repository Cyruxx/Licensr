<?php

class LicenseController extends BaseController
{
    public function index()
    {
        return View::make('index');
    }

    public function process()
    {
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



        return View::make('index');
    }
}
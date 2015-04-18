<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">

    <title>Licensr</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />


    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>

    <div class="vertical-center">
        <div class="container text-center">
            <h1 class="main-heading">Licensr</h1>
            <p class="shadow">License your files the easy way: Append a license notice!</p>
            <div class="row">
            	<div class="col-xs-12 col-md-6 col-xs-offset-0 col-md-offset-3">
                    @if(Session::has('error'))
                        <div class="alert alert-danger text-left">
                        	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        	{{ Session::get('message') }}
                        </div>
                    @endif

                    {{ Form::open(['action' => 'process', 'class' => 'fileUpload text-left', 'files' => true]) }}


                        <div class="form-group small-margin">
                            <select name="licenseType" class="input-lg form-control licenseType" data-placeholder="1. License" required="required">
                                <option></option>
                                <option value="0">MIT</option>
                                <option value="1">Apache 2.0</option>
                                <option value="2">GPL v2</option>
                                <option value="3">GPL v3</option>
                            </select>
                            <p class="help-block">Choose what license you'd like to use.</p>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control input-lg projectInput" placeholder="2. Project name"
                                   required="required" value="{{ Input::old('projectName') }}" name="projectName">
                            <p class="help-block">Your awesome project name: <i>Ionic</i></p>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control input-lg contributorsInput" placeholder="3. Names of the contributors"
                                   required="required" name="contributors" value="{{ Input::old('contributors') }}">
                            <p class="help-block">Seperated by commas: Alex Mahrt, Peter Lustig</p>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <input type="text" name="commentStart" class="form-control input-lg" placeholder="4. Comment start" required="required"
                                            value="{{ Input::old('commentStart') }}">
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <input type="text" name="commentEnd" class="form-control input-lg" placeholder="5. Comment end" required="required"
                                            value="{{ Input::old('commentEnd') }}">
                                </div>
                            </div>
                            <p class="help-block">Please define the mass comment start and end call. Example: /* and */</p>
                        </div>

                        <input type="file" name="licenseFiles[]" multiple class="fileInput" required="required">
                        <input type="text" class="form-control input-lg fileText" placeholder="4. Choose your files" readonly>
                        <p class="help-block">Only text files are allowed in here.</p>

                        <h4>Preview</h4>
                        <div class="well well-sm">
                            Copyright (c) {{ date('Y') }} <span class="contributors">Alex Mahrt</span><br><br>

                            This file is part of the '<span class="projectName">Licensr</span>' project.<br>
                            It uses the <span class="licenseName">MIT</span> license.<br><br>
                            For more information about your permission to use, copy, modify, merge, publish,
                            distribute, sublicense and/or sell copies of this software, and to permit persons to whom
                            the software is furnished to do so, please visit the official website of the <span class="licenseName">MIT</span> license.
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fa fa-fw fa-magic"></i> Give me some magic</button>

                        @if(Input::hasFile('licenseFiles'))
                            <hr>
                            <a name="link"></a>
                            <h4>Your download link</h4>
                            <p>Note: Your files will be deleted after the first visit of this URL.</p>
                            <a href="{{ url('/' . $sZipGuid) }}" target="_blank">http://licensr.net/{{ $sZipGuid }}</a>

                            <script>
                                window.location.hash = 'link';
                            </script>
                        @endif
                    {{ Form::close() }}
                    <p class="shadow">Made with <i class="fa fa-fw fa-heart"></i> by <a href="https://twitter.com/AlexMahrt" target="_blank">@AlexMahrt</a></p>
            	</div>
            </div>
        </div>
    </div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
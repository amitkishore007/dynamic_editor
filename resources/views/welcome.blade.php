<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editor Demo</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style type="text/css">
        #html-editor, #css-editor {
            width: 500px;
            height: 400px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Template</h3>
                        <div id="html-editor"></div>

                    </div>
                    <div class="col-md-6">
                        <h3>Custom CSS</h3>
                        <div id="css-editor">/*** Write your custom css here *****/</div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-12 mt-3">
                <button class="btn btn-primary">Update Template</button>
            </div>
        </div>
    </div>
<p> </p>
    <script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="{{ url('/editor/ace.js') }}"></script>
<script src="{{ url('/editor/theme-monokai.js') }}"></script>
<script src="{{ url('/editor/mode-html.js') }}"></script>
    <script>
        var html_editor = ace.edit("html-editor"); 
        html_editor.setTheme("ace/theme/monokai"); 
        html_editor.session.setMode("ace/mode/html");
        
        var css_editor = ace.edit("css-editor"); 
        css_editor.setTheme("ace/theme/monokai");
        css_editor.session.setMode("ace/mode/css");


        var base_url = '{{ url("/") }}';
    </script>

<script type="text/javascript">
    $(document).ready(function(){
        var let = $('#editor').text();
        console.log(editor.getValue());
    });
</script>


</body>
</html>
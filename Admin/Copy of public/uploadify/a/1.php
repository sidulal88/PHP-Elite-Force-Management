<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>File Uploader</title>
        <link href="../uploadify.css" rel="stylesheet" media="screen" type="text/css" />
        <script type="text/javascript" src="../jquery-1.6.2.min.js"></script>
        <script src="jquery.uploadify-3.1.min.js" type="text/javascript"></script>

    </head>

    <script type="text/javascript">
        $(document).ready(function(event) {
            $('#file_upload').uploadify({
                // Some options
                'method'   : 'post',
                'formData' : { 'id' : '02' },
                'uploader' : 'uploadify.php',
                'buttonClass' : 'uploadify-button',
                'buttonText' : 'BROWSE',
                'onUploadSuccess' : function(file, data, response) {
                    $('#v').val(data);
                    alert('The file was saved to: ' + data);
                }
            });
        });
    </script>  


</head>
<body>




    <form id="form1" action="post.php" method="post" enctype="multipart/form-data">


        <h3>Please input the XML:</h3>
        <input type="file" name="file_upload" id="file_upload" /><br/>
        <input id="v" type="text" value=""/>
    </form>

    <div id="result">call back result will appear here</div>

</body>

</html>

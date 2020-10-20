<!DOCTYPE html>
<html>
    <head>
        <title>
            binary upload
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="application/javascript">
            function sendFile(file) 
            {
                const uri = "test2output.php";
                const xhr = new XMLHttpRequest();
                const fd = new FormData();
                
                xhr.open("POST", uri, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                       document.getElementById("output").innerHTML=xhr.responseText; // handle response.
                    }
                };
                fd.append('myImage', file);
                fd.append("upload","upload");
                // Initiate a multipart/form-data upload
                xhr.send(fd);
            }
            function processForm()
            {
                var form = document.forms.namedItem("fileUploadForm");
                form.onsubmit=function(event)
                {
                    event.preventDefault();
                    data = new FormData(this);
                    data.append("upload", "A file is uploading");

                    var req = new XMLHttpRequest();
                    req.open("POST", "test2output.php", true);
                    req.onload = function(oEvent)
                    {
                        if (req.status == 200) 
                        {
                          console.log(req.responseText);
                        } 
                        else 
                        {
                          console.log("Error " + req.status + " occurred when trying to upload your file.");
                        }
                    };
                    req.send(data);
                }
            }
            window.onload=function(event)
            {
                processForm();
            }
        </script>
    </head>
    <body>
        <div id="output"></div>
        <form method="post" enctype="multipart/form-data" name="fileUploadForm">
            <div>
                <label for="picture">
                    Upload:
                </label>
                <input type="file" id="myImage" name="myImage" accept="image/png, image/jpeg, image/gif, image/jpg">
            </div>
            <div>
                <input type="submit" id="upload" name="upload" value="upload">
            </div>
        </form>
    </body>
</html>
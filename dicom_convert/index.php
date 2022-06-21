<?php

  // Allow Access for Testing 
  header('Access-Control-Allow-Origin: *');

$files = scandir("../uploads/ct_scans");
$files = array_diff($files, array(".", ".."));
$dcms = array();
foreach($files as $file) {
  if(pathinfo("../uploads/ct_scans/$file", PATHINFO_EXTENSION) == 'dcm' && !file_exists("../uploads/ct_scans/$file.png")) {
    $dcms[] = $file;
  }

}

echo "DICOMS: ".count($dcms); 

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<img id="dicom-img" style="display:none !important">
<canvas id="dicom-canvas" style="display:none !important">
<script type="module">
  import * as dicomjs from "https://cdn.skypack.dev/dicom.ts@1.0.3";

  var dcms = <?php echo json_encode($dcms); ?>;

  for (var i = 0; i < dcms.length; i++) {
    
    var img_type = 'png';
    var imgBase64 = [];
    try {

      var dicomUrl = "../uploads/ct_scans/"+dcms[i];
      
      var canvas = document.getElementById("dicom-canvas");
      
      // get the data into an ArrayBuffer
      var response = await fetch(dicomUrl);
      var buffer = await response.arrayBuffer();
      // parse it
      var image = dicomjs.parseImage(new DataView(buffer));
      // render to canvas
      var renderer = new dicomjs.Renderer(canvas);
          // decode, and display frame 0 on the canvas
      await renderer.render(image, 0).then( data => {
        
        // var img_data = canvas.toDataURL("image/jpeg");
        // $("#dicom-img").attr("src", img_data);
        
        // var filename = dicomUrl.substring(dicomUrl.lastIndexOf('/')+1).replace(".dcm", "");

        var dataURL = canvas.toDataURL();
        imgBase64.push(dataURL)
      });

      if(imgBase64.length != 0)
        $.ajax({
          type: "POST",
          url: "save-scan.php",
          data: {imgBase64, img_type, filename:dcms[i]},
          async:false
        });

    } catch (e) {
      console.error(e);
    }
  }
</script>
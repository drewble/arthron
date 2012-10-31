<?
/*
	File added on 10/24/2003 for v1.3.0
	
	 purpose of this file is to display a page upon clicking an image link in the back end
	 this page allows the user to modify images by resizing, rotating, flipping, mirroring, and cropping
*/

	$on_popup = 1;
	$on_image_edit_page = 1;
	 include "config.php"; 

	// stop parsing if person is not a store admin
	if (!security_level("Store Admin")) die;

	// get variables from session of URI
	if ($HTTP_GET_VARS['table']) {
		$table = $HTTP_GET_VARS['table'];
		$SC['table'] = $table;
	} else {
		$table= $SC['table'];
	}
	if ($HTTP_POST_VARS['path']) {
		$path = $HTTP_POST_VARS['path'];
	} else {
		$path = $HTTP_GET_VARS['path'];
	}	
	if ($HTTP_POST_VARS['rn']) {
		$rn = $HTTP_POST_VARS['rn'];
	} else {
		$rn = $HTTP_GET_VARS['rn'];
	}
	if ($HTTP_POST_VARS['field_name']) {
		$field_name = $HTTP_POST_VARS['field_name'];
	} else {
		$field_name = $HTTP_GET_VARS['field_name'];
	}

	// click and drag crop feature doesn't work in MAC, so detect Macs here for later use
	$is_mac = $HTTP_SERVER_VARS['HTTP_UA_OS'] == "MacOS";

	// grab images for icons
	$resize_img = get_image("Cart_Images","resize");
	$flip_img = get_image("Cart_Images","flip");
	$mirror_img = get_image("Cart_Images","mirror");
	$rotate_img = get_image("Cart_Images","rotate");
	$crop_img = get_image("Cart_Images","crop");

	// get original image file info
	$orig_img_path = $SC['site_isp_root']."/$path";
	
	// if file is not there, do not continue
	if (is_file($orig_img_path)) {	
		$orig_img_size = getimagesize($orig_img_path);
		$orig_uri_path = $SC['site_www_root']."/$path";
	
		
		// obtain a source image file to work with
		if ($HTTP_POST_VARS) {
			// grab values from post vars
			$rotate_degrees = $HTTP_POST_VARS['rotate_degrees'];
			$rotate_direction = $HTTP_POST_VARS['rotate_direction'];
			$image_action = $HTTP_POST_VARS['image_action'];
			if ($crop_end_width || $HTTP_POST_VARS['crop_end_x']) $image_action = "crop";
	
			// image_action tells us whether we are modifying the image or not
			if ($image_action) {
				if ($image_action == "crop") {
					// grab cropping coordinates
					$crop_start_x = $HTTP_POST_VARS['crop_start_x'];
					$crop_start_y = $HTTP_POST_VARS['crop_start_y'];
					if (!$is_mac) {
						// for advanced crop, form posts the crop area's width and height
						$crop_end_width = $HTTP_POST_VARS['crop_end_width'];
						$crop_end_height = $HTTP_POST_VARS['crop_end_height'];
						$crop_end_width = str_replace("px","",$crop_end_width);
						$crop_end_height = str_replace("px","",$crop_end_height);
					} else {
						// for simple crop, form posts the ending (bottom right) x and y coordinates of the crop
						$crop_end_x = $HTTP_POST_VARS['crop_end_x'];
						$crop_end_y = $HTTP_POST_VARS['crop_end_y'];
						$crop_start_x = $crop_start_x + 1; // simple method outputs coordinates, including 0. we need to bump it up one
						$crop_start_y = $crop_start_y + 1; // simple method outputs coordinates, including 0. we need to bump it up one
						if ($crop_end_x) {
							// if here, then all coordinates are available, and we need to calculate the crop area width and height
							$crop_end_width = $crop_end_x - $crop_start_x;
							$crop_end_height = $crop_end_y - $crop_start_y;
						}	
					}
						
					// test output
					if ($crop_start_x && $crop_end_width) {
						// calculate new width and height of image
						$new_x = $crop_end_width;
						$new_y = $crop_end_height;
						$orig_img_width = $orig_img_size[0];
						$orig_img_height = $orig_img_size[1];
						$width_left = $orig_img_width - $crop_start_x;
						$height_left = $orig_img_height - $crop_start_y;
						
						if ($new_x > $width_left) $new_x = $width_left;
						if ($new_y > $height_left) $new_y = $height_left;
					}
				}
				
				
				if ($image_action == "flip") {
					$mirror = "horizontal";
				} 
				if ($image_action == "mirror") {
					$mirror = "vertical";
				} 
				if ($image_action == "rotate"){
					// figure out whether rotation is left or right
					if ($rotate_direction == "right") $rotate_degrees = $rotate_degrees - ($rotate_degrees * 2);
				}
				// set a temporary name for this file (which will be in the /tmp directory on the server)
				// this will be used to preview the image, and will be stored in the SESSION variable for later cleanup
				$file_ext = strrchr($orig_img_path, ".");
				$tempname = str_replace($file_ext,"~TEMP~".time(),"$orig_img_path");

				if ($image_action == "crop" && isset($crop_start_x) && isset($crop_end_width)) {
					if ($crop_end_width <= 0 || $crop_end_height <= 0) {
						$error .= "<b>Error: </b> Dimensions specified for the crop area are invalid.<br>";
					} else {
						$ok_to_crop = 1;
					}
				}
				
				if ($image_action != "crop" || $ok_to_crop == 1) {
					$temp_image = image_manipulate($orig_img_path,$tempname,$new_x,$new_y,$rotate_degrees,$mirror,$crop_start_x,$crop_start_y);

					if ($temp_image['error']) {
						$error .= "<b>Error:</b> $temp_image[error]<br>";
					} else {
						if ($SC['temp_image']) {
							// image was stored here before and not used....clean it up
							if (is_file($SC['temp_image'])) {
								@unlink($SC['temp_image']);
							}
						}
						$SC['temp_image'] = $temp_image['image']; // store for later deletion if image is not excepted.
						$uri_path = str_replace($SC['site_isp_root'],$SC['site_www_root'],$temp_image['image']);
						$time = time();
						$accept_code =  "<div id=\"accept_section\">
						<div style=\"font-size: 12pt; font-weight: bold\">Preview of New Image: </div><br>
						<img src=\"$uri_path?".time()."\"><br><br>
						<form action=\"$SC[cart_www_root]/image_edit_popup.php\" method=\"post\">
							<b>Warning!</b> If you click the button below, the original image will be replaced by the new one.<br><br>
							<input type=\"hidden\" name=\"path\" value=\"$path\">
							<input type=\"hidden\" name=\"rn\" value=\"$rn\">
							<input type=\"hidden\" name=\"field_name\" value=\"$field_name\">
							<input type=\"submit\" name=\"image_accept\" value=\"Accept Changes\">
							<input type=\"reset\" name=\"image_cancel\" onClick=\"javascript: hide_accept()\" value=\"Cancel\">
						</form>
						</div>
						";
					}
				}
			}
			if ($HTTP_POST_VARS['image_accept']) {
				// if here, than the user decided to accept an image modification, and replace the original file with the temp file
				// determine the appropriate name for the new image. because we may have converted from GIF to PNG, we cant just use the same name
				// must retain the extension that is in the temp image, as that is the correct one
				if (is_file($SC['temp_image'])) {
					$temp_ext = strrchr($SC['temp_image'], ".");
					$orig_ext = strrchr($orig_img_path, ".");
					$new_img_path = str_replace($orig_ext,$temp_ext,$orig_img_path); // use the original name, but with a new extension if there is one
					$new_uri_path = str_replace($orig_ext,$temp_ext,$orig_uri_path); // use the original name, but with a new extension if there is one
					// check and see if original path is writeable (so we can replace it!)
					if (is_writeable($orig_img_path)) {
						// copy new image, replacing original
						$copy_result = @copy ($SC['temp_image'],$new_img_path);
						if ($copy_result) {
							$message .= "Successfully modified image.<br>";
							// check to see if original image path and new one is the same. if it isn't, then delete the original. 
							// this will happen if the extension was changed
							// if extension has changed, then the record also needs to be updated accordingly.
							if($orig_img_path != $new_img_path) {
								@unlink($orig_img_path);
								$path_from_db = get_field_val($SC['table'],$field_name,"record_number = $rn");
								$update_path = str_replace($orig_ext,$temp_ext,$path_from_db);
								set_field_val($SC['table'],$field_name,$update_path,"record_number = $rn");
								// fix path for display to user
								$orig_uri_path = str_replace($SC['site_isp_root'],$SC['site_www_root'],$new_img_path);
							}
						} else {
							$error .= "<b>Error:</b> unable to copy $SC[temp_image] to $new_img_path.<br>";
						}
					} else {
						$error .= "<b>Error:</b> unable to replace original file, $orig_img_path. Check permissions.";
					}
				} else {
					$error .= "<b>Error:</b> The modified file, $SC[temp_image]  is no longer available";
				}
			}
		}
		// toggle display of certain things after form is submitted
		if (isset($crop_start_x)  && !$accept_code) {
			$crop_display2 = "";
			$current_display = "none";
		} else {
			$crop_display2 = "none";
			$current_display = "";
		}
	} else {
		$error .= "<b>Error: </b> file specified in link to this page does not exist: $orig_img_path.<br>";
	}
?>
<html>
	<head>
		<script type="text/javascript">

var moz = ((document.all)? false : true);
    var ie = ((document.all)? true : false);
      
    function ImageBox(imgId) {      
      var origX, origY;
      

var point = getPosition(document.getElementById(imgId));

      // I put this div over the image to remove drag behaviour 
      // on image in mozilla.
      if(moz) {
        var overLayer = document.createElement("div");
        document.body.appendChild(overLayer);
        var point = getPosition(document.getElementById(imgId));
        var dim = getDimension(document.getElementById(imgId));      
        overLayer.style.position = "absolute";
        overLayer.style.left = point.left;
        overLayer.style.top = point.top;
        overLayer.style.width = dim.width;
        overLayer.style.height = dim.height;
        overLayer.style.border = "1px solid red";
      }
      
      var dragDiv = document.createElement("div");
      document.body.appendChild(dragDiv);                        
      dragDiv.style.visibility = "hidden";
      dragDiv.style.position = "absolute";
      dragDiv.style.border = "1px dotted black";
      dragDiv.style.width = "0px";
      dragDiv.style.height = "0px";
      dragDiv.style.zIndex = 3;
      dragDiv.style.left = "20px";
      dragDiv.style.top = "20px";      
     
      function mouseDown(evt) {
        if(!evt) {
          evt = event;
        }
        dragDiv.style.visibility = "visible";
        dragDiv.style.left = evt.clientX -1 ;
        dragDiv.style.top = evt.clientY -1 ;
        dragDiv.style.width = "1px";
        dragDiv.style.height = "1px";
        origX = evt.clientX;
        origY = evt.clientY;
        addEventListener(document, "mousemove", mouseMove);
        addEventListener(document, "mouseup", mouseUp); 
        evt.cancelBubble = true;
        return false;     
      }
      
      if(ie) {
        // Removes default drag behaviour on image
        addEventListener(document.getElementById(imgId), "drag",
function() {return false;});
        // Adds my "drag" behaviour to the image
        addEventListener(document.getElementById(imgId), "mousedown",
mouseDown);
      }
      if(moz) {
        addEventListener(overLayer, "mousedown", mouseDown);      
      }

      
      function mouseMove(evt) {
        if(!evt) {
          evt = event;
        }               
        var newWidth = evt.clientX - origX;
        var newHeight = evt.clientY - origY;
        // You can add lots and lots of checks and arithmetics here to
        // to add possibility to go to "negative" widths, height, tops
//and lefts
        // and also see to it so you don't drag outside the image
        // I simply didn't have the energy
        if (newWidth > 0 ) dragDiv.style.width = newWidth;
        if (newHeight > 0) dragDiv.style.height = newHeight;
      }
      
      function mouseUp(evt) {        
        removeEventListener(document, "mousemove", mouseMove);  
        removeEventListener(document, "mouseup", mouseUp);
		document.image_form.crop_start_x.value = box.getX();
		document.image_form.crop_start_y.value = box.getY();
		document.image_form.crop_end_width.value = box.getWidth();
		document.image_form.crop_end_height.value = box.getHeight();
		document.image_form.submit();
      }     
     
      this.getX = function() {
        return (parseInt(dragDiv.style.left) - parseInt(point.left));
      }

      this.getY = function() {
        return (parseInt(dragDiv.style.top) - parseInt(point.top));
      }
      
      this.getWidth = function() {
        return dragDiv.style.width;
      }
      
      this.getHeight = function() {
        return dragDiv.style.height;
      }      
    }
    
    function getPosition(elt) {
      var point = new Object();      
      // You might have to do some more advanced tricks here like
      // looping through the offset parent until you get to the top
      // and add the positions as you go up
      point.left = elt.offsetLeft;
      point.top = elt.offsetTop;
      return point;
    }
    
    function getDimension(elt) {
      var dim = new Object();
      dim.width = elt.offsetWidth;
      dim.height = elt.offsetHeight;
      return dim;
    }
    
    
    function addEventListener(o, type, handler) {
      if(ie) {
        o.attachEvent("on" + type, handler);
      }
      else if(moz) {
        o.addEventListener(type, handler, false);
      }
    }

    function removeEventListener(o, type, handler) {
      if(ie) {
        o.detachEvent("on" + type, handler);
      }
      else if(moz) {
        o.removeEventListener(type, handler, false);
      }
    }
    
    function showResult() {
      var str = "Left: " + box.getX() + "\n" +
      "Top: " + box.getY() + "\n" +
      "Width: " + box.getWidth() + "\n" + 
      "Height: " + box.getHeight();
      alert(str);
    }

    
    function init() {
      box = new ImageBox("image");
    }
    var box = null;


			function flip() {
				clear_crop_values()
				document.image_form.image_action.value = 'flip'
				resize_section.style.display = 'none'
				message_section.style.display = "none"
				document.image_form.submit()
			}
			function mirror() {
				clear_crop_values()
				image_form.image_action.value = 'mirror'
				resize_section.style.display = 'none'
				message_section.style.display = "none"
				document.image_form.submit()
			}
			function rotate() {
				clear_crop_values()
				image_form.image_action.value = 'rotate'
				if (rotate_section.style.display == "none") {
					rotate_section.style.display = ""
					resize_section.style.display = "none"
					message_section.style.display = "none"
					submit_section.style.display = ""
					accept_section.style.display = "none"
				} else {
					rotate_section.style.display = "none"
					resize_section.style.display = "none"
					submit_section.style.display = "none"
					message_section.style.display = "none"
			}
			}

		<? if (!$is_mac) { ?>
			function crop() {
				current_image.style.display = "none"
				image_form.image_action.value = 'crop'
				if (crop_advanced.style.visibility == "hidden") {
					crop_advanced.style.visibility = "visible"
					rotate_section.style.display = "none"
					resize_section.style.display = "none"
					message_section.style.display = "none"
					submit_section.style.display = "none"
					accept_section.style.display = "none"
				} else {
					clear_crop_values()
					rotate_section.style.display = "none"
					resize_section.style.display = "none"
					message_section.style.display = "none"
			}
			}
			function clear_crop_values() {
				image_form.crop_start_x.value = ''
				image_form.crop_start_y.value = ''
				current_image.style.display = ""
				crop_advanced.style.visibility = "hidden"
			}
		<? } else { ?>
			function crop() {
				current_image.style.display = "none"
				image_form.image_action.value = 'crop'
				if (crop_simple_start.style.display == "none") {
					crop_simple_start.style.display = ""
					rotate_section.style.display = "none"
					resize_section.style.display = "none"
					message_section.style.display = "none"
					submit_section.style.display = "none"
					accept_section.style.display = "none"
				} else {
					clear_crop_values()
					rotate_section.style.display = "none"
					resize_section.style.display = "none"
					message_section.style.display = "none"
			}
			}
			function clear_crop_values() {
				image_form.crop_start_x.value = ''
				image_form.crop_start_y.value = ''
				current_image.style.display = ""
				crop_simple_start.style.display = "none"
				crop_simple_end.style.display = "none"
			}
		<? } ?>
			function resize() {
				clear_crop_values()
				image_form.image_action.value = 'resize'
				if (resize_section.style.display == "none") {
					resize_section.style.display = ""
					rotate_section.style.display = "none"
					submit_section.style.display = ""
					accept_section.style.display = "none"
					message_section.style.display = 'none'
				} else {
					resize_section.style.display = "none"
					rotate_section.style.display = "none"
					message_section.style.display = 'none'
					submit_section.style.display = "none"
				}
			}
			function hide_accept() {
				accept_section.style.display = "none"
			}
		</script>
		<? include "menu.css";?>
		<script src="check_for_IE.js" type="text/javascript"></script>
	</head>
	<body style="font-family: tahoma; font-size: 8pt; text-align: center; margin: 0" onload="init();">
		<div align="left" style="position: absolute; top: 0; left: 0; background-color: #DFDFDF; width: 100%; padding: 1px; border-bottom: solid gray 2px; border-top: solid gray 0px" >
			<a class="menuButton4" style="width: 71" href="javascript: resize()" href="#"><?=$resize_img?>
				<span style="position: relative; top: -6">Resize</span>
			</a>
			<a class="menuButton4"  style="width: 50"  href="javascript: flip()" href="#"><?=$flip_img?>
				<span style="position: relative; top: -6">Flip</span>
			</a>
			<a  class="menuButton4" style="width: 70" href="javascript: mirror()" href="#"><?=$mirror_img?>
				<span style="position: relative; top: -6">Mirror</span>
			</a>
			<a  class="menuButton4" style="width: 69" href="javascript: rotate()" href="#"><?=$rotate_img?>
				<span style="position: relative; top: -6">Rotate</span>
			</a>
			<a  class="menuButton4" style="width: 60" href="javascript: crop()" href="#"><?=$crop_img?>
				<span style="position: relative; top: -6">Crop</span>
			</a>
		</div>
		<br>
		<br>
		<br><br>
		<div id="current_image" style="font-size: 12pt; font-weight: bold; display: <?=$current_display?>">
			<br>
			Current Image:<br><br>
			<img src="<?=$orig_uri_path."?".microtime()?>"><br><br>
		</div>
		<form name="image_form" action="<?=$SC['cart_www_root']?>/image_edit_popup.php" method="post">
			<input type="hidden" name="image_action">
			<input type="hidden" name="rn" value="<?=$rn?>">
			<input type="hidden" name="path" value="<?=$path?>">
			<input type="hidden" name="field_name" value="<?=$field_name?>">
			<br>
			<div id="resize_section" style="display: none">
				New width: <input type="text" name="new_x" size="3"> 
				&nbsp;&nbsp;&nbsp;New height: <input type="text" name="new_y" size="3"> <br>
				<br>
				If you specify 1 dimension only, the aspect ratio of the image will be mainted.
			</div>
			<div id="rotate_section" style="display: none">
				Rotate: <input type="text" name="rotate_degrees" style="width: 30" > &deg; 
				<input type="radio" name="rotate_direction" value="left"> Left
				<input type="radio" name="rotate_direction" value="right" checked> Right<br>
			</div>
			<? 
				// only uses click and drag for crop if not macintosh
				if (!$is_mac) { 
			?>
				<div id="crop_advanced" style="visibility: hidden">
					<div style="font-size: 12pt; font-weight: bold">
						Designate Crop Area
					</div>
					<input type="hidden" name="crop_start_x">
					<input type="hidden" name="crop_start_y">
					<input type="hidden" name="crop_end_width">
					<input type="hidden" name="crop_end_height">
					<?
						$left_position = (700 - $orig_img_size[0]) / 2;
					?>
						<img style="position:absolute;left: <?=$left_position?>px;top:120px; cursor: crosshair" id="image" src="<?=$orig_uri_path."?".microtime()?>" >
					<br>
					Click and drag from top to bottom and left to right to indicate the crop area.
				</div>
			<? 
				} else { 
				// mac is special case...need to crop without click and drag
			?>
				<div id="crop_simple_start" style="display: none">
					<div style="font-size: 12pt; font-weight: bold">
						Designate Start of Crop Area
					</div>
					<input type="hidden" name="crop_start_x" value="<?=$crop_start_x?>">
					<input type="hidden" name="crop_start_y" value="<?=$crop_start_y?>">
					<input style="cursor: crosshair" type="image" name="crop_start" src="<?=$orig_uri_path."?".microtime()?>">
					<br>
					Click to designate the top left corner of the crop area.
				</div>
				<? if ($crop_start_x && !$crop_end_x) {
						$crop_simple_end_vis = "";
					} else {
						$crop_simple_end_vis = "none";
					}
				?>
				<div id="crop_simple_end" style="display: <?=$crop_simple_end_vis?>">
					<div style="font-size: 12pt; font-weight: bold">
						Designate End of Crop Area
					</div>
					<input style="cursor: crosshair" type="image" name="crop_end" src="<?=$orig_uri_path."?".microtime()?>">
					<br>
					Click to designate the bottom right corner of the crop area.
				</div>
			<? } ?>

			<br>
			<div id="submit_section" style="display: none">
				<input type="submit" value="Preview Changes">
			</div>
		</form>
		<? 
			if ($message) {
				$message_display = "";
			} else {
				$message_display = "none";
			}
		?>
		<div id="message_section" style="display: <?=$message_display?>">
			<?=$message?>
		</div>
		<br>
		<?=$error?>
		<?=$accept_code?>
	</body>
</html>
<?
// workaround for SESSION variable problem
$HTTP_SESSION_VARS['sc'] = $SC;
?>


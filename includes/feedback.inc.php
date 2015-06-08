<style type="text/css" media="screen">
    
    .slide-out-div {
       padding: 1px 3px 5px 3px;
        width: 490px;
		/*background: #285598;*/
		background: #285598;
        border: #29216d 2px solid;
		opacity:0.95;
		z-index:2000;
    }
    
	</style>
    <script src="js/jquery.tabSlideOut.v1.3.js"></script>
         
         <script>
         $(function(){
             $('.slide-out-div').tabSlideOut({
                 tabHandle: '.handle',                              //class of the element that will be your tab
                 pathToTabImage: 'images/write_to_us.jpg',          //path to the image for the tab (optionaly can be set using css)
                 imageHeight: '150px',                               //height of tab image
                 imageWidth: '48px',                               //width of tab image    
                 tabLocation: 'left',                               //side of screen where tab lives, top, right, bottom, or left
                 speed: 300,                                        //speed of animation
                 action: 'click',                                   //options: 'click' or 'hover', action to trigger animation
                 topPos: '320px',                                   //position from the top
                 fixedPosition: true                               //options: true makes it stick(fixed position) on scroll
             });
         });

         </script><div class="slide-out-div">
        <a class="handle" href="http://link-for-non-js-users">Content</a>
		<form action="feedback.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
		<table width="490px" class="feedback_tab">
			<tr>
			  <td width="85"><div align="right">To :</div></td>
				<td width="393"><select name="to_mail" >
					<option value="">Select Police Unit</option>
					<option value="d.ip1@police.gov.bd">INDUSTRIAL POLICE-1, DHAKA</option>
					<option value="d.ip2@police.gov.bd">INDUSTRIAL POLICE-2, GAZIPUR</option>
					<option value="d.ip3@police.gov.bd">INDUSTRIAL POLICE-3, CHITTAGONG</option>
					<option value="dip4@police.gov.bd">INDUSTRIAL POLICE-4, Narayanganj</option>
				</select></td>
			</tr>
			<tr>
			  <td><div align="right">From :</div></td>
			  <td><input type="text" name="from_mail" value="" size="36" placeholder="Input Your Email" /></td>
		  </tr>
			<tr>
			  <td><div align="right">Subject : </div></td>
				<td><input type="text" size="52" name="subject" placeHolder="Input Your Email Subject" /></td>
			</tr>	
					
			<tr>
			  <td><div align="right">Message :</div></td>
				<td><textarea name="message" placeHolder="Input Your Message" cols="45" rows="5" ></textarea></td>
			</tr>		<tr>
				<td><div align="right">Attachment </div></td>
				<td><input type="file" name="file" /></td>
			</tr>			
			
			<tr>
			  <td>&nbsp;</td>
				<td><input type="submit" name="Submit" value="  Send  " /></td>
			</tr>
		</table>
		</form>
    </div>

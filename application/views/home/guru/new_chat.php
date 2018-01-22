	GURU <div class="container">
		<!--<a href="./">New conference</a>-->
		<div class="clearfix"></div>

		<video id="me" autoplay></video>
		<video id="other0" autoplay></video>
		<video id="other1" autoplay></video>
		<video id="other2" autoplay></video>
		<video id="other3" autoplay></video>
		<video id="other4" autoplay></video>
</body>

<button onclick="join_call()" class="btn btn-primary" id="join">Join</button>

<button id="cut" class="btn btn-danger" >Hangup</button>
<input type="text" id="channel" value="<?php echo base64_decode($this->uri->segment(3));?>">
<input type="text" name="" id="receiver" value="victoriaarbba2">
<button id="call_again_video" onclick="call_again()">Call</button>




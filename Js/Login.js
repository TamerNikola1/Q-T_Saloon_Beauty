var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}





  //show the sign up form on click the button 
  var flag_global=0;
  $(document).on('click','.sign_up',function(){
      if($('.sign_up').is(":visible"))
          Signup();
  }); 




              
            //Function that shows the register/login modal
			function ShowHide(img)
			{
				document.getElementById('id01').style.display='block';
                document.getElementById('rgstr').style.display='none';
				document.getElementById('bs').src=img;
				Signin();
                $('#loginBtn').attr('data-pos');     
                  
			}


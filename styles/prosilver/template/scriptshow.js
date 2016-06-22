/* С днем попеды*/	
/*window.onload = function() {
    	var style = document.getElementsByClassName('site_logo')[0].style;
		style.backgroundImage='url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR-X-83SVIHibIpggGc0LgU-m19DH10ChlG1E29kaANArI2Bu7bvw")';
   		style.backgroundSize='cover';
		style.height='110px';
       }*/
/* Функции для примеров к уроку jqueri8 */
function hideDiv(){
    $('#les8_ex1').hide();
}
function showDiv(){
    $('#les8_ex1').show();
}
function hideShowDiv(){
      $('#les8_ex2').toggle('slow');
}
function slideUpDiv(){
    $('#les8_ex3').slideUp();
}
function slideDownDiv(){
    $('#les8_ex3').slideDown();
}
function slideToggleDiv(){
      $('#les8_ex4').slideToggle(7000);
}
function fadeOutDiv(){
      $('#les8_ex5').fadeOut(5000);
}
function fadeInDiv(){
      $('#les8_ex5').fadeIn(5000);
}
function fadeToDiv(){
      $('#les8_ex6').fadeTo(5000, 0.5);
}
function animateDiv(){
      $('#les8_ex7').animate({
          width:"400px",
          height:"200px"
      }, 3000 );
      $('#les8_ex8').animate({
          width:"100px",
          height:"100px"
      }, 3000 );
}
function stopDiv(){
      $('#les8_ex7').stop();
      $('#les8_ex8').stop();
}
function animateDiv2(){
      $('#les8_ex9').animate({
          "height": "toggle"
      }, 1000 );
      
}
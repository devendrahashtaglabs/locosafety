<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><style>body {
  background: linear-gradient(to right, #4A569D, #DC2424);
}
body .container {
  width: 70%;
  margin: auto;
}
body .container .logo {
  color: #fff;
  text-transform: uppercase;
  letter-spacing: 10px;
  text-align:center;
  margin-top:100px;
}
body .container .title {
  text-align: center;
  padding-top: 30px;
  font-size: 50px;
  color: #FFF;
  text-transform: uppercase;
}
body .container .title span {
  color: #fff;
  font-size: 150px;
  font-family: verdana;
  cursor: help;
  letter-spacing: -15px;
  animation-name: anim;
  animation-duration: 10s;
  animation-iteration-count: infinite;
}
body .container form input {
  margin-top: 30px;
  margin-left: 220px;
  width: 50%;
  padding: 5px;
  border: none;
  border-bottom: 2px solid #fff;
  background-color: transparent;
  font-size: 20px;
  color: #fff;
}
body .container form button {
  margin-left: 0;
  border: 2px solid;
  padding: 10px;
  outline: none;
  background-color: transparent;
  font-size: 20px;
  color: #fff;
  border-radius: 50%;
  cursor: pointer;
}
body footer {
  margin-top: 50px;
  -webkit-text-shadow: 3px 5px 5px #000;
  -moz-text-shadow: 3px 5px 5px #000;
  text-shadow: 3px 5px 5px #000;
}
body p {
  text-align: center;
  font-size: 20px;
  color: #fff;
  font-family: verdana;
}

@keyframes anim {
  0% {
    letter-spacing: -15px;
  }
  50% {
    letter-spacing: 25px;
  }
  100% {
    letter-spacing: -15px;
  }
}

</style>

<section class="container">
	<h2 class="logo">RSW SAFETY</h2>
	<h1 class="title"><span>Sorry</span><br>Can't execute your code.</h1>
	
</section>
<?php 
exit;
?>
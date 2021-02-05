<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN"
"http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <title>Send Free SMS API</title>
    <meta http-equiv="expires" content="0"/>
    <meta http-equiv="Content-Language" content="en-us"/>
    <meta http-equiv="content-type" content="Text/html; charset=UTF-8"/>
    <meta name="charset" content="UTF-8"/>
    <meta name="distribution" content="Global"/>
    <meta name="rating" content="General"/>
    <meta name="robots" content="Index,follow"/>
    <meta name="revisit-after" content="3 Day"/>
    <link rel="shortcut icon" href="favicon.ico"/>
    <link rel="stylesheet" href="style.css" type="text/css"/>
  </head>
  <body style="max-width:400px">
    <div class="w3-container w3-red">
      <h1>Send Free SMS</h1>
    </div>
    <div class="w3-container w3-pale-blue w3-leftbar w3-border-blue">
      <div class="content">
        <form action="sendsms.php" method="post" id="myForm">
          <label>Receipt:</label>
          <input type="text" class="w3-input" name="phone" value=""/>
          <br/>
          <label>Message:</label>
          <textarea class="w3-input" name="message"></textarea>
          <br/>
          <input type="submit" class="w3-btn w3-white w3-border w3-round" value="Send" id="submit"/>
        </form>
        <br>
      </div>
      <p><span class="w3-tag w3-blue" id="ack">Message Status</span></p>
    </div>
    <footer class="w3-container w3-red">
      <h3>Powered By : <a href="http://www.howi.in">HOWI.IN<a/></h3>
    </footer>
    <script type="text/javascript" src="jquery.min.js"></script>
    <script type="text/javascript" src="my_script.js"></script>

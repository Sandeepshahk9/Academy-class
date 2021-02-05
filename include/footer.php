    </div>
    <!-- ./wrapper -->
   		 <!-- jQuery 2.1.4 -->
		<script src="plugins/jQuery/jQuery-2.1.4.min.js"  type="text/javascript"></script>
	
        <!-- jQuery UI 1.11.4 -->
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"  type="text/javascript"></script>
        <script type="text/javascript">
            function confirm_click()
            {
            return confirm("Are you sure delete this records ?");
            }
            
            </script>
        <!--select2-->
        <script src="plugins/select2/select2.min.js" type="text/javascript"></script>
         <!-- Bootstrap 3.3.5 -->
        <script src="bootstrap/js/bootstrap.min.js"  type="text/javascript"></script>
		
        <!-- Bootstrap WYSIHTML5 -->
        <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- Slimscroll -->
        <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <!-- FastClick -->
        <script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/app.min.js" type="text/javascript"></script>
         <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js" type="text/javascript"></script>
		<script src="bootstrap/js/jquery.validate.min.js"  type="text/javascript"></script>
		<script src="bootstrap/js/chartlist.min.js"  type="text/javascript"></script>
		<script>
		    var alreadyclicked=false;
		    $(document).ready(function(){
        		$("form").submit(function(){
                    if($("form").valid()&&alreadyclicked){
                        return false;
                    }
                    else if($("form").valid()&&!alreadyclicked){
                        alreadyclicked=true;
                        return true;
                    }
                });
		    });
        </script>
 </body>
</html>
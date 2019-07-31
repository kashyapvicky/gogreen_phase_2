
<!-- BEGIN .main-footer -->
					<footer class="main-footer">
						Copyright Improof Admin.
					</footer>
					<!-- END: .main-footer -->

				</div>
				<!-- END: .app-main -->

			</div>
			<!-- END: .app-container -->

		</div>
		<!-- END: .app-wrap -->


		<!--
			**********************
			**********************
			Common JS files
			**********************
			**********************
		-->

		<!-- jQuery JS. -->
		
		<script src="{{ URL::asset('public/webadmin/js/jquery.js')}}"></script>

		<!-- Info: jQuery UI is required for datepicker and date range or any jQuery UI related plugins -->
		
		<script src="{{ asset('public/webadmin/js/jquery-ui.min.js')}}"></script>

		<!-- Tether Js, then other JS. -->
		<script src="{{ asset('public/webadmin/js/popper.min.js')}}"></script>
		<script src="{{ asset('public/webadmin/js/bootstrap.min.js')}}"></script>
		<script src="{{ asset('public/webadmin/vendor/unifyMenu/unifyMenu.js')}}"></script>
		<script src="{{ asset('public/webadmin/vendor/onoffcanvas/onoffcanvas.js')}}"></script>
		<script src="{{ asset('public/webadmin/js/moment.js')}}"></script>

		
		

		

		<!-- News Ticker JS -->
		<script src="{{ asset('public/webadmin/vendor/newsticker/newsTicker.min.js')}}"></script>
		<script src="{{ asset('public/webadmin/vendor/newsticker/custom-newsTicker.js')}}"></script>


		<!-- Slimscroll JS -->
		<script src="{{ asset('public/webadmin/vendor/slimscroll/slimscroll.min.js')}}"></script>
		<script src="{{ asset('public/webadmin/vendor/slimscroll/custom-scrollbar.js')}}"></script>

		
		

		<!-- Daterange JS -->
		<script src="{{ asset('public/webadmin/vendor/daterange/daterange.js')}}"></script>
		<script src="{{ asset('public/webadmin/vendor/daterange/custom-daterange.js')}}"></script>

		
		<!--
			**********************
			**********************
			Optional JS files - Plugns
			**********************
			**********************
		-->
		
		<!-- Morris Graphs -->
		

		

		<!-- Common JS -->
		<script src="{{ asset('public/webadmin/js/common.js')}}"></script>

		

        <!-- Data Tables JS -->
		<script src="{{ asset('public/webadmin/vendor/datatables/dataTables.min.js')}}"></script>
		<script src="{{ asset('public/webadmin/vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
		<script src="{{ asset('public/webadmin/js/validate.js')}}"></script>


		

		
		
		<!-- Custom Data tables JS -->
		<script src="{{ asset('public/webadmin/vendor/datatables/custom/custom-datatables.js')}}"></script>

		<script src="{{ asset('public/webadmin/vendor/datatables/custom/fixedHeader.js')}}"></script>



		
		
		<!-- Bootstrap Select JS -->
		<script src="{{ asset('public/webadmin/vendor/bs-select/bs-select.min.js')}}"></script>
		
		
		<!-- Common JS -->

		<script src="{{ asset('public/webadmin/js/common.js')}}"></script>
		<script src="{{ asset('public/webadmin/js/datetimepicker.js')}}"></script>

	
		 

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>


<script>
	$(document).ready(function(){
		var date_input=$('input[name="start_date"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'mm/dd/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
	})
</script>
		
		<script>
	$(document).ready(function(){
		var date_input=$('input[name="end_date"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'mm/dd/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
	})
</script>
<script>
	$(document).ready(function(){
		var date_input=$('input[name="dob"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'mm/dd/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
	})
</script>
<script>
	function close_modal()
	{
		$('#succmsg').hide();
		location.reload();
	}
</script>
		
	</body>

<!-- Mirrored from bootstrap.gallery/kingfisher/light-sidebar/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 15 May 2019 08:07:55 GMT -->
</html>
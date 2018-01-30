</section><!-- /#wrapper -->
<!--/ END WRAPPER -->

<!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->

<!-- START @CORE PLUGINS -->
<script src="<?=$system->getDomain()?>/assets/admin/js/jquery.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/admin/js/bootstrap.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/admin/js/chosen.jquery.min.js"></script>
<!--/ END CORE PLUGINS -->

<!-- START @GLOBAL MANDATORY SCRIPTS -->
<script src="<?=$system->getDomain()?>/assets/admin/js/apps.js"></script>
<!--/ END @GLOBAL MANDATORY SCRIPTS -->

<script>
$('.chosen').each(function(){  
	$(this).chosen({disable_search_threshold: 10});
}); 
</script>

</body>
<!--/ END BODY -->

</html>
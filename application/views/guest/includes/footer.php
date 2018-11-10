 <footer class="main-footer">
    <strong>Copyright &copy; <?= date('Y') ?> <a href="<?= base_url() ?>">Team H</a>.</strong> All rights
    reserved.
  </footer>
</div>

<script>
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
	$('.logout').css('cursor', 'pointer');
	$('.logout').on('click', () => {
		swal({
			title: 'Signing Out',
			timer: 1000,
			onOpen: () => {
				swal.showLoading();
		    }
		}).then(() => {
			window.location.href = "<?= base_url() . 'Guest/logout' ?>";
		})
	})
</script>

</body>
</html>
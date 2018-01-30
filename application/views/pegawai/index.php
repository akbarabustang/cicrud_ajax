<div class="container">
	<h2>Daftar Pegawai</h2>
	<div class="alert alert-success" style="display: none;"></div>
	<button id="btnTambah" class="btn btn-success">+Tambah</button>
	<table class="table table-bordered table-responsive" style="margin-top: 20px;">
		<thead>
			<tr>
				<td>ID</td>
				<td>Nama Pegawai</td>
				<td>Alamat</td>
				<td>Created at</td>
				<td width="180px">Aksi</td>
			</tr>
		</thead>
		<tbody id="tampildata">
			
		</tbody>
	</table>
</div>

<!-- showmodal -->
<div id="myModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <form id="myForm" action="" method="post" class="form-horizontal" >
        	<input type="hidden" name="id_pegawai" value="0">
			<div class="form-group">
				<label class="label-control col-md-4">Nama Pegawai</label>
				<div class="col-md-8">
					<input type="text" name="nama_pegawai" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="label-control col-md-4">Alamat</label>
				<div class="col-md-8">
					<input type="text" name="alamat" class="form-control">
				</div>
			</div>
		</form>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btnSimpan" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- showmodal hapus-->
<div id="modalHapus" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Konfirmasi Hapus</h4>
      </div>
      <div class="modal-body">
        Apakah anda yakin menghapus data ini ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="button" id="btnHapus" class="btn btn-danger">Hapus</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	$(function(){
		tampilkanPegawai();

		// menambah data
		$('#btnTambah').click(function(){
			$('#myModal').modal('show');
			$('#myModal').find('.modal-title').text('Tambahkan Pegawai baru');
			$('#myForm').attr('action', '<?php echo base_url() ?>pegawai/tambahkanPegawai');

		})

		$('#btnSimpan').click(function(){
			var url = $('#myForm').attr('action');
			var data = $('#myForm').serialize();
			// validasi data
			var nama_pegawai = $('input[name=nama_pegawai]');
			var alamat = $('input[name=alamat]');
			var result = '';
			if (nama_pegawai.val()=='') {
				nama_pegawai.parent().parent().addClass('has-error');
			}else{
				nama_pegawai.parent().parent().removeClass('has-error');
				result +='1';
			}
			if (alamat.val()=='') {
				alamat.parent().parent().addClass('has-error');
			}else{
				alamat.parent().parent().removeClass('has-error');
				result +='2';
			}

			if (result == '12') {
				$.ajax({
					type: 'ajax',
					method: 'post',
					url: url,
					data :data,
					async: false,
					dataType: 'json',
					success: function(response){
						if (response.success) {
							$('#myModal').modal('hide');
							$('#myForm')[0].reset();
							if (response.type == 'add') {
								var type = 'ditambahkan'
							}else if(response.type == 'update'){
								var type = 'diperbaharui'
							}
							$('.alert-success').html('Data pegawai berhasil'+' '+type).fadeIn().delay(4000).fadeOut('slow');
							tampilkanPegawai();
						}else{
							alert('Error mas');
						}
					},
					error: function(){
						alert('Tidak dapat menambahkan data');
					}
				});
			}
		});

		// update data
		$('#tampildata').on('click', '.item-edit', function(){
			var id = $(this).attr('data');
			$('#myModal').modal('show');
			$('#myForm').find('modal-title').text('Edit data Pegawai');
			$('#myForm').attr('action', '<?php echo base_url() ?>pegawai/updatePegawai');
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url() ?>pegawai/editPegawai',
				data:{id:id},
				async: false,
				dataType: 'json',
				success: function(data){
					$('input[name=nama_pegawai').val(data.nama_pegawai);
					$('input[name=alamat').val(data.alamat);
					$('input[name=id_pegawai').val(data.id_pegawai);
				},
				error: function(){
					alert('Tidak dapat mengedit data');
				}
			});
		})


		// hapus data
		$('#tampildata').on('click', '.item-delete', function(){
			var id = $(this).attr('data');
			$('#modalHapus').modal('show');
			$('#btnHapus').unbind().click(function(){
				$.ajax({
					type:'ajax',
					method:'get',
					async: false,
					url:'<?php echo base_url() ?>Pegawai/hapusPegawai',
					data:{id:id},
					dataType:'json',
					success: function(response){
						if (response.success) {
							$('#modalHapus').modal('hide');
							$('.alert-success').html('Data pegawai berhasil dihapus').fadeIn().delay(4000).fadeOut('slow');	
							tampilkanPegawai();
						}else{
							alert('waduh kenapa ini ');
						}
					},
					error: function(){
						alert('Errorki cantik');
					}
				});
			});
		});

		// menampilkan data
		function tampilkanPegawai(){
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>pegawai/tampilkanPegawai',
				async: false,
				dataType: 'json',
				success: function(data){
					var html = '';
					var i;
					for (i = 1; i<data.length; i++) {
						html +='<tr>'+
									'<td>'+i +'</td>'+
									'<td>'+data[i].nama_pegawai+'</td>'+
									'<td>'+data[i].alamat+'</td>'+
									'<td>'+data[i].created_at+'</td>'+
									'<td>'+
										'<a href="javascript:;" class="btn btn-info item-edit" data="'+data[i].id_pegawai+'">Edit</a>' + 
										'|'+
										'<a href="javascript:;" class="btn btn-danger item-delete" data="'+data[i].id_pegawai+'">Hapus</a>'+ 
									'</td>'+
								'</tr>';
					}
					$('#tampildata').html(html);
				},
				error: function(){
					alert('Tidak Dapat mengambil data');
				}
			});
		}
	});
</script>
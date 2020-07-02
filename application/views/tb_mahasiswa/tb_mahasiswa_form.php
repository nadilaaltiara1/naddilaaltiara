<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Tb_mahasiswa <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Npm <?php echo form_error('Npm') ?></label>
            <input type="text" class="form-control" name="Npm" id="Npm" placeholder="Npm" value="<?php echo $Npm; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nama <?php echo form_error('Nama') ?></label>
            <input type="text" class="form-control" name="Nama" id="Nama" placeholder="Nama" value="<?php echo $Nama; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Jk <?php echo form_error('Jk') ?></label>
            <input type="text" class="form-control" name="Jk" id="Jk" placeholder="Jk" value="<?php echo $Jk; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Prodi <?php echo form_error('prodi') ?></label>
            <input type="text" class="form-control" name="prodi" id="prodi" placeholder="Prodi" value="<?php echo $prodi; ?>" />
        </div>
	    <input type="hidden" name="No" value="<?php echo $No; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('tb_mahasiswa') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>
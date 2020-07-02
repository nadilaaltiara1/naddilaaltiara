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
        <h2 style="margin-top:0px">Tb_biodata_nadilaaltiara List</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('tb_biodata_nadilaaltiara/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('tb_biodata_nadilaaltiara/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('tb_biodata_nadilaaltiara'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Nama</th>
		<th>Kelas</th>
		<th>Jurusan</th>
		<th>Action</th>
            </tr><?php
            foreach ($tb_biodata_nadilaaltiara_data as $tb_biodata_nadilaaltiara)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $tb_biodata_nadilaaltiara->nama ?></td>
			<td><?php echo $tb_biodata_nadilaaltiara->kelas ?></td>
			<td><?php echo $tb_biodata_nadilaaltiara->jurusan ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('tb_biodata_nadilaaltiara/read/'.$tb_biodata_nadilaaltiara->npm),'Read'); 
				echo ' | '; 
				echo anchor(site_url('tb_biodata_nadilaaltiara/update/'.$tb_biodata_nadilaaltiara->npm),'Update'); 
				echo ' | '; 
				echo anchor(site_url('tb_biodata_nadilaaltiara/delete/'.$tb_biodata_nadilaaltiara->npm),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    </body>
</html>
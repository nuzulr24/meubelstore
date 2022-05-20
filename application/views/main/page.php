<?php
    $this->db->where("slug",$slug);
    $db = $this->db->get("page");

    if($db->num_rows() == 0){
        redirect("404_error");
        exit;
    }

    foreach($db->result() as $res){
?>
    
	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg m-b-30">
			<a href="index.html" class="text-primary">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				<?=$res->nama?>
			</span>
		</div>
	</div>


	<!-- Page Content -->
	<div class="container">
		<div class="m-b-40 text-center font-medium text-primary">
			<h1><?=$res->nama?></h1>
		</div>
        <ol><?=$res->konten?></ol>
		<div class="m-b-80"></div>
    </div>
<?php
    }
?>
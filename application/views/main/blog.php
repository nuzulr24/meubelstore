
	<!-- breadcrumb -->
	<div class="container">
		<div class="hidesmall m-t-40"></div>
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="<?php echo site_url(); ?>" class="text-primary">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Blog
			</span>
		</div>
	</div>


	<!-- Shoping Cart -->
	<style rel="stylesheet">
		@media only screen and (min-width:721px){
			.mobilefix{
				margin-left: -36px;
			}
		}
	</style>
	<div class="container p-t-10 p-b-40" style="background: #f8f9fa1c;">
		<div class="p-t-40 p-b-40 text-center">
			<h2 class="text-primary font-bold"><b>BLOG TERBARU</b></h2>
		</div>
		<div class="row m-t-20 m-b-30" style="justify-content:center;">
			<?php
				$page = (isset($_GET["page"]) AND $_GET["page"] != "") ? $_GET["page"] : 1;
				$orderby = (isset($_GET["orderby"]) AND $_GET["orderby"] != "") ? $_GET["orderby"] : "id DESC";
				$perpage = 12;
				
				$dbs = $this->db->get("blog");
				
				$this->db->limit($perpage,($page-1)*$perpage);
				$this->db->order_by($orderby);
				$db = $this->db->get("blog");
				
				if($db->num_rows() > 0){
					foreach($db->result() as $res){
			?>
				<div class="col-6 col-md-3 blog-wrap">
					<div class="blog-grid" onclick="window.location.href='<?=site_url('blog/'.$res->url)?>'">
						<div class="img" style="background-image: url('<?=base_url("blackexpo/uploads/".$res->img)?>')"></div>
						<div class="m-t-10 titel">
							<?=$this->func->potong($res->judul,40,"...")?>
						</div>
						<div class="m-t-10 konten">
							<?=$this->func->potong(strip_tags($res->konten),90,"...")?>
						</div>
					</div>
				</div>
			<?php
					}
				}else{
					echo "
						<div class='text-danger text-center p-tb-20'>
							Belum Ada Postingan
						</div>
					";
				}
			?>
		</div>
		<div class="m-b-60">
			<!-- Pagination -->
			<div class="pagination flex-m flex-w p-t-26">
				<?=$this->func->createPagination($dbs->num_rows(),$page,$perpage)?>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		function refreshTabel(page){
			window.location.href = "<?=site_url("blog")?>?page="+page;
		}
	</script>
	
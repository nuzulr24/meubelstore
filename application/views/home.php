

	<!-- Slider -->	
    <div class="carousel slider">
		<?php
			$this->db->where("tgl<=",date("Y-m-d H:i:s"));
			$this->db->where("tgl_selesai>=",date("Y-m-d H:i:s"));
			$this->db->where("jenis",1);
			$this->db->where("status",1);
			$this->db->order_by("id","DESC");
			$sld = $this->db->get("promo");
			if($sld->num_rows() > 0){
				foreach($sld->result() as $s){
		?>
			<div class="slider-item" style="cursor:pointer;" data-onclick="<?=$s->link?>">
				<div class="wrap">
					<img src="<?= base_url('blackexpo/promo/'.$s->gambar) ?>" />
				</div>
			</div>
		<?php
				}
			}
		?>
    </div>

	<!-- Kategori -->
	<section class="banner p-t-40 p-b-40 m-b-40">
		<div class="container">
			<div class="sec-title p-b-30">
				<h2 class="t-center">
					Kategori Produk
				</h2>
			</div>
			<div class="cat">
			<?php
				$this->db->where("parent",0);
				$db = $this->db->get("kategori");
				foreach($db->result() as $r){
			?>
				<div class="cat-item">
					<div class="cat-bg" style="background-position:center center;background-image:url('<?=base_url("blackexpo/kategori/".$r->icon)?>');background-size:cover;" onclick="window.location.href='<?=site_url("kategori/".$r->url)?>'">
					</div>
					<div class="cat-nama"><?=$r->nama?></div>
				</div>
			<?php
				}
			?>
			</div>
		</div>
	</section>

	<!-- Space Iklan -->
	<?php
		$this->db->where("tgl<=",date("Y-m-d H:i:s"));
		$this->db->where("tgl_selesai>=",date("Y-m-d H:i:s"));
		$this->db->where("jenis",2);
		$this->db->where("status",1);
		$this->db->order_by("RAND()");
		$this->db->limit(3);
		$ikl = $this->db->get("promo");

		if($ikl->num_rows() > 0){
	?>
	<section class="banner-iklans m-b-40">
		<div class="container center">
			<div class="sec-title p-b-60">
				<h2 class="t-center">
					Iklan
				</h2>
			</div>

			<div class="row">
				<?php
					foreach($ikl->result() as $iklan){
				?>
					<div class="col-md-4 iklans m-b-20">
						<a href="<?=$iklan->link?>">
							<img src="<?= base_url('blackexpo/promo/'.$iklan->gambar) ?>" />
						</a>
					</div>
				<?php
					}
				?>
			</div>
		</div>
	</section>
	<?php
		}
	?>

	<!-- New Product -->
	<section class="newproduct p-t-40 p-b-40">
		<div class="container">
			<div class="sec-title p-b-60">
				<h2 class="t-center">
					Daftar Produk
				</h2>
			</div>

			<!-- Slide2 -->
			<div class="row display-flex produk-wrap">
				<?php
					$this->db->where("preorder !=",1);
					$this->db->limit(300);
					$this->db->order_by("stok DESC,tglupdate DESC");
					$db = $this->db->get("produk");
					$totalproduk = 0;
					foreach($db->result() as $r){
						$level = isset($_SESSION["lvl"]) ? $_SESSION["lvl"] : 0;
						if($level == 5){
							$result = $r->hargadistri;
						}elseif($level == 4){
							$result = $r->hargaagensp;
						}elseif($level == 3){
							$result = $r->hargaagen;
						}elseif($level == 2){
							$result = $r->hargareseller;
						}else{
							$result = $r->harga;
						}
						$ulasan = $this->func->getReviewProduk($r->id);

						$this->db->where("idproduk",$r->id);
						$dbv = $this->db->get("produkvariasi");
						$totalstok = ($dbv->num_rows() > 0) ? 0 : $r->stok;
						$hargs = 0;
						$harga = array();
						foreach($dbv->result() as $rv){
							$totalstok += $rv->stok;
							if($level == 5){
								$harga[] = $rv->hargadistri;
							}elseif($level == 4){
								$harga[] = $rv->hargaagensp;
							}elseif($level == 3){
								$harga[] = $rv->hargaagen;
							}elseif($level == 2){
								$harga[] = $rv->hargareseller;
							}else{
								$harga[] = $rv->harga;
							}
							$hargs += $rv->harga;
						}

						if($totalstok > 0 AND $totalproduk < 12){
							$totalproduk += 1;
							$wishis = ($this->func->cekWishlist($r->id)) ? "active" : "";
				?>
					<div class="col-6 col-md-4 col-lg-3 m-b-30 cursor-pointer produk-item">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-wishlist" onclick="tambahWishlist(<?=$r->id?>,'<?=$r->nama?>')"><i class="fas fa-heart <?=$wishis?>"></i></div>
							<div class="block2-img wrap-pic-w of-hidden pos-relative" style="background-image:url('<?=$this->func->getFoto($r->id,"utama")?>');" onclick="window.location.href='<?php echo site_url('produk/'.$r->url); ?>'"></div>
							<div class="block2-txt" onclick="window.location.href='<?php echo site_url('produk/'.$r->url); ?>'">
								<a href="<?php echo site_url('produk/'.$r->url); ?>" class="block2-name dis-block p-b-5">
									<?=$r->nama?>
								</a>
								<span class="block2-price-coret btn-block">
									<?php if($r->hargacoret > 0){ echo "Rp. ".$this->func->formUang($r->hargacoret); } ?>
								</span>
								<span class="block2-price p-r-5 color1">
									<?php 
										if($hargs > 0){
											echo "Rp. ".$this->func->formUang(min($harga))." - ".$this->func->formUang(max($harga));
										}else{
											echo "Rp. ".$this->func->formUang($result);
										}
									?>
								</span>
							</div>
							<div class="row block2-ulasan" onclick="window.location.href='<?php echo site_url('produk/'.$r->url); ?>'">
								<div class='col-6'>
									<small><?=$ulasan['ulasan']?> Ulasan</small>
								</div>
								<div class='col-6 text-right'>
									<span class="text-warning font-bold"><i class='fa fa-star'></i> <?=$ulasan['nilai']?></span>
								</div>
							</div>
						</div>
					</div>
				<?php
						}
					}
							
					if($totalproduk == 0){
						echo "<div class='col-12 text-center m-tb-40'><h5><mark>Belum ada Produk</mark></h5></div>";
					}
				?>
					</div>

		</div>
		<div class="t-center m-t-20">
			<a href="<?=site_url("shop")?>" class="btn btn-lg btn-primary">Lihat Semua Produk <i class="fas fa-chevron-circle-right"></i></a>
		</div>
	</section>

	<!-- Testismoni -->
	<section class="testismoni p-t-40 p-b-40 m-b-40">
		<div class="container">
			<div class="sec-title p-b-30">
				<h2 class="t-center">
					Testimoni Pelanggan
				</h2>
			</div>
			<div class="testimoni">
				<div class="m-r-24"></div>
			<?php
				$this->db->where("status",1);
				$this->db->limit(9);
				$db = $this->db->get("testimoni");
				foreach($db->result() as $r){
			?>
				<div class="testimoni-item">
					<div class="testimoni-wrap">
						<div class="m-b-20 testimoni-komentar">" <?=$r->komentar?> "</div>
						<div class="row m-lr-0">
							<div class="col-3 p-lr-0">
								<div class="testimoni-img" style="background-position:center center;background-image:url('<?=base_url("blackexpo/uploads/".$r->foto)?>');background-size:cover;"></div>
							</div>
							<div class="col-9 p-r-4">
								<div class="font-bold text-primary fs-14 ellipsis"><?=$r->nama?></div>
								<div class="fs-12"><?=$r->jabatan?></div>
							</div>
						</div>
					</div>
				</div>
			<?php
				}
			?>
			</div>
		</div>
	</section>

	<!-- Blog Terbaru -->
	<div class="container p-t-10 p-b-40">
		<div class="sec-title p-t-30 p-b-40">
			<h2 class="t-center"><b>Blog Terbaru</b></h2>
		</div>
		<div class="row m-t-20 m-b-30" style="justify-content:center;">
			<?php
				$this->db->select("id");
				$dbs = $this->db->get("blog");
				
				$this->db->limit(12,0);
				$this->db->order_by("tgl DESC");
				$db = $this->db->get("blog");
				
				if($db->num_rows() > 0){
					foreach($db->result() as $res){
			?>
				<div class="col-md-6 blog-wrap">
					<div class="blog row" onclick="window.location.href='<?=site_url('blog/'.$res->url)?>'">
						<div class="col-4 p-l-0 p-r-0">
							<div class="img" style="background-image: url('<?=base_url("blackexpo/uploads/".$res->img)?>')"></div>
						</div>
						<div class="col-8">
							<div class="titel">
								<?=$this->func->potong($res->judul,40,"...")?>
							</div>
							<div class="konten">
								<?=$this->func->potong(strip_tags($res->konten),90,"...")?>
							</div>
						</div>
					</div>
				</div>
			<?php
					}
				}else{
					echo "
						<div class='text-danger text-center p-tb-20'>
							BELUM ADA POSTINGAN
						</div>
					";
				}
			?>
		</div>
		<div class="t-center m-t-20 m-b-30">
			<a href="<?=site_url("blog")?>" class="btn btn-lg btn-primary">Lihat Semua Postingan <i class="fas fa-chevron-circle-right"></i></a>
		</div>
	</div>

	<script type="text/javascript">
		function refreshTabel(page){
			window.location.href = "<?=site_url("blog")?>?page="+page;
		}
	</script>

	<?php $notif_booster = $this->func->getSetting("notif_booster"); if($notif_booster == 1){ ?>
	<div id="toaster" class="toaster row col-md-4" style="display:none;">
		<div class="col-3 img p-lr-6"><img id="toast-foto" src="<?=base_url("blackexpo/uploads/520200116140232.jpg")?>" /></div>
		<div class="col-9 p-lr-6">
			<b id="toast-user">USER</b> telah membeli<br/>
			<b id="toast-produk">Nama Produknya</b>
		</div>
	</div>
	<?php } ?>
	<script type="text/javascript">
		$(function(){
			$('.carousel .slick-slide').on('click', function(ev){
				var slideIndex = $(ev.currentTarget).data('slick-index');
				var current = $('.carousel').slick('slickCurrentSlide');
				if(slideIndex == current){
					window.location.href= $(this).data("onclick");
				}else{
					$('.carousel').slick('slickGoTo',parseInt(slideIndex));
				}
			});
		});

		<?php if($notif_booster == 1){ ?>
		$(function(){
			setTimeout(() => {
				toaster();
			}, 3000);
			
		});

		function toaster(){
			$.post("<?=site_url("assync/booster")?>",{"id":0,[$("#names").val()]:$("#tokens").val()},function(msg){
				var data = eval("("+msg+")");
				updateToken(data.token);
				if(data.success == true){
					$("#toast-foto").attr("src",data.foto);
					$("#toast-user").html(data.user);
					$("#toast-produk").html(data.produk);

					$("#toaster").show("slow");
					setTimeout(() => {
						$("#toaster").hide("slow");
						setTimeout(() => {
							toaster();
						}, 3000);
					}, 5000);
				}else{
					setTimeout(() => {
						toaster();
					}, 5000);
				}
			});
		}
		<?php } ?>
	</script>
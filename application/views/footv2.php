
	<!-- Footer -->
	<div class="bg-foot-gradient p-t-40"></div>
	<footer class="bg-foot p-t-40 p-b-40" style="margin-top: -2px;">
		<div class="row p-b-90 container m-l-auto m-r-auto">
			<div class="col-md-3 m-b-30">
				<h4 class="font-medium foot-title p-b-30">
					KONTAK
				</h4>

				<div class="">
					<?php $set = $this->func->getSetting("semua"); ?>
					<p>
						<?=$set->jamkerja?>
					</p>
					&nbsp;
					<table>
						<tr><td class='p-r-10'><i class="fa fa-phone color1"></i></td><td><?=$set->wasap?></td></tr>
						<tr><td class='p-r-10'><i class="fa fa-square color1"></i> </td><td><?=$set->lineid?></td></tr>
						<tr><td class='p-r-10'><i class="fa fa-envelope-open color1"></i> </td><td><?=$set->email?></td></tr>
						<tr><td class='p-r-10'><i class="fa fa-map-marker color1"></i> </td><td><?=$set->alamat?></td></tr>
					</table>
				</div>

				<h4 class="font-medium foot-title p-b-10 p-t-30">
					Sosial Media
				</h4>
				<div class="">
					<a target="_blank" onclick="fbq('track','Contact')" href="https://wa.me/<?=$this->func->getRandomWasap()?>/?text=Halo%20admin%20*<?=$this->func->getSetting("nama")?>*" class="btn btn-success btn-block"><i class="fab fa-whatsapp"></i> Hubungi Admin</a>
					</div>
				<div class="flex-m p-t-10">
					<a onclick="fbq('track','Contact')" href="<?=$set->facebook?>" style="color: #2980b9;" class="fs-32 color1 p-r-20 fab fa-facebook-square"></a>
					<a onclick="fbq('track','Contact')" href="<?=$set->instagram?>" style="color: #dd2a7b;" class="fs-32 color1 p-r-20 fab fa-instagram"></a>
					<a onclick="fbq('track','Contact')" href="mailto:<?=$set->email?>" class="color1 fs-32 color1 p-r-20 fas fa-envelope"></a>
				</div>
			</div>

			<div class="col-md-3 m-b-30">
				<h4 class="font-medium foot-title p-b-30">
					Kategori
				</h4>

				<ul class="foot-menu">
					<?php
						$this->db->where("parent",0);
						$this->db->limit(9); //Jika ingin membatasi jumlah
						$kategori = $this->db->get("kategori");
						foreach($kategori->result() as $r){
					?>
					<li class="p-b-9">
						<a href="<?=site_url("kategori/".$r->url)?>">
							<?=ucwords(strtolower($r->nama))?>
						</a>
					</li>
					<?php
						}
					?>
				</ul>
			</div>

			<div class="col-md-3 m-b-30">
				<h4 class="font-medium foot-title p-b-30">
					Halaman
				</h4>

				<ul class="foot-menu">
					<?php
						$this->db->where("status",1);
						$page = $this->db->get("page");
						$this->db->limit(9); //Jika ingin membatasi jumlah
						foreach($page->result() as $pg){
					?>
					<li class="p-b-9">
						<a href="<?=site_url("page/".$pg->slug)?>">
							<?=ucwords(strtolower($pg->nama))?>
						</a>
					</li>
					<?php
						}
					?>
				</ul>
			</div>

			<div class="col-md-3 m-b-30">
				<h4 class="font-medium foot-title p-b-10">
					Pembayaran
				</h4>

				<div class="flex-m p-t-10">
					<img style="width:100%;" src="<?=base_url("assets/images/ipaymu.png")?>" />
				</div>

				<h4 class="font-medium foot-title p-b-10 p-t-30">
					Pengiriman
				</h4>

				<div class="p-t-10">
					<?php
						$kurir = explode("|",$set->kurir);
						for($i=0; $i<count($kurir); $i++){
							$kur = $this->func->getKurir($kurir[$i],"halaman");
							echo '<img style="width:28%;margin:2%;" src="'.base_url("sso/assets/img/kurir/".$kur.".png").'" />';
						}
					?>
				</div>
			</div>
		</div>

		<div class="t-center p-l-15 p-r-15">
			<div class="t-center p-t-20">
				Copyright © <?=date('Y');?> <?=ucwords(strtolower($set->nama))?>
			</div>
		</div>
	</footer>



	<!-- Back to top
	<div class="btn-back-to-top bg0-hov" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="fa fa-angle-double-up" aria-hidden="true"></i>
		</span>
	</div> -->
	<input type="hidden" id="names" value="<?=$this->security->get_csrf_token_name()?>" />
	<input type="hidden" id="tokens" value="<?=$this->security->get_csrf_hash();?>" />

	<?php if($this->func->cekLogin() == true){ ?>
	<div class="modal fade" id="modalpilihpesan" tabindex="-1" role="dialog" style="background: rgba(0,0,0,.5);" style="bottom:0;right:0;" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content p-lr-30 p-tb-40 text-center">
				<h3 class="text-primary font-bold">Hubungi Admin</h3><br/>
				<a href="https://wa.me/<?=$this->func->getRandomWasap()?>" target="_blank" class="btn btn-lg btn-block btn-success m-b-10"><i class="fab fa-whatsapp"></i> &nbsp;Hubungi via Whatsapp</a>
			</div>
		</div>
	</div>
	<a href="javascript:void(0)" class="chat-sticky" onclick='$("#modalpilihpesan").modal()'><i class="fas fa-comment-dots"></i> Chat</a>
	<?php }else{ ?>
	<a href="https://wa.me/<?=$this->func->getRandomWasap()?>" class="chat-sticky" target="_blank"><i class="fas fa-comment-dots"></i> Chat</a>
	<?php }?>
	
	<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/vendor/select2/select2.min.js') ?>"></script>
	<script type="text/javascript">
		$(".js-select2").each(function(){
			$(this).select2({
    			theme: 'bootstrap4',
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		});
	</script>
	<script type="text/javascript" src="<?= base_url('assets/vendor/slick/slick.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/vendor/swal/sweetalert2.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/aos.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/main.js') ?>"></script>
	<script type="text/javascript">
  		AOS.init();
		  
		function formUang(data){
			return data.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
		}
		function signoutNow(){
			swal.fire({
				title: "Keluar",
				text: "Lanjutkan keluar dari akun anda?",
				icon: "warning",
				showDenyButton: true,
				confirmButtonText: "Oke",
				denyButtonText: "Batal"
			})
			.then((willDelete) => {
				if (willDelete.isConfirmed) {
					window.location.href="<?=site_url("home/signout")?>";
				}
			});
		}

		function tambahWishlist(id,nama){
			$.post("<?php echo site_url("assync/tambahwishlist/"); ?>"+id,{[$("#names").val()]:$("#tokens").val()},function(msg){
				var data = eval("("+msg+")");
				var wish = parseInt($(".wishlistcount").html());
				updateToken(data.token);
				if(data.success == true){
					$(".wishlistcount").html(wish+1);
					swal.fire(nama, "berhasil ditambahkan ke wishlist", "success");
				}else{
					swal.fire("Gagal", data.msg, "error");
				}
			});
		}

		function updateToken(token){
			$("#tokens,.tokens").val(token);
		}

		$(".block2-wishlist .fas").on("click",function(){
			$(this).removeClass("active");
			$(this).addClass("active");
		});

	</script>
	<script src="<?= base_url('assets/js/main.js') ?>"></script>

	<!-- Facebook Pixel Code -->
		<script>
		!function(f,b,e,v,n,t,s)
		{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];
		s.parentNode.insertBefore(t,s)}(window, document,'script',
		'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '<?=$set->fb_pixel?>');
		fbq('track', 'PageView');
		</script>
		<noscript>
		<img height="1" width="1" style="display:none" 
			src="https://www.facebook.com/tr?id=<?=$set->fb_pixel?>&ev=PageView&noscript=1"/>
		</noscript>
	<!-- End Facebook Pixel Code -->

</body>
</html>

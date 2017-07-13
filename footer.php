<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 */
?>

	<footer id="footer" role="contentinfo">
		<a id="footerLogo" title="Başa Dön" href="#"></a>
		<div id="footerContent" class="container">
			<div class="row">
				<div id="footerSec1" class="span4 pull-left">
					<p>
						Adres: Doğu Anadolu Kalkınma Ajansı <br/>
						Şerefiye Mah. Mareşal Fevzi Çakmak Cad. No: 27<br/>
						65100 Merkez / VAN
					</p>
					<p>
						Tel : (0432) 215 65 55 (pbx)
					</p>
					<p>
						Faks : (0432) 215 65 54 - (0212) 381 79 93
					</p>
					<p>
						E-posta : bilgi@daka.org.tr
					</p>
				</div>
				<div id="footerSec2" class="span4 pull-left">
                    <ul class="inline clearfix">
                        <li><a id="fbLink" class="socialLink pull-left ttip" href="http://www.facebook.com/soz.sahibiol" title="Sen de soz sahibi ol - Facebook" target="_blank">Facebook</a></li>
                        <li><a id="twitterLink" class="socialLink pull-left ttip" href="https://twitter.com/sozsahibiol" title="Sen de soz sahibi ol - Twitter" target="_blank">Twitter</a></li>
                    </ul>
				</div>
				<div id="footerSec3" class="span4 pull-left">
					<?php 
					   echo do_shortcode('[contact-form-7 id="277" title="Bize Ulaşın"]');
					?>
				</div>				
			</div>
		</div>
		<div id="copyright">
			<p>
				&copy; Copyright 2013. Bu sitede yayinlanan her türlü bilgi ve belge Dogu Anadolu Kalkinma Ajansi tarafindan saglanmistir. Tüm haklari saklidir.
			</p>
		</div>	
	</footer><!-- #footer -->
	
</div><!-- #mainDiv -->

<?php 
if(is_home())
{
?>
<div id="welcome" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="Hosgeldiniz" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Hoşgeldiniz</h3>
  </div>
  <div class="modal-body">
    <img src="<?php echo get_template_directory_uri(); ?>/images/popup.png" alt="Hosgeldiniz"/>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Kapat</button>
  </div>
</div>
<?php
}else{echo 'f';}
?>

<script type="text/javascript"> 
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-38533862-1']);
  _gaq.push(['_trackPageview']);
 
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })(); 
</script>

<?php wp_footer(); ?>

</body>
</html>
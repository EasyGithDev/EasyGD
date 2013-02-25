<?php
require '../autoload.php';

define('THUMB_ORIGINAL', './images/original/');
define('THUMB_200', './images/thumb/200/');
define('THUMB_400', './images/thumb/400/');
define('THUMB_100', './images/thumb/100/');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Bootstrap, from Twitter</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">
        <style>
            body {
                padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
            }

            #myModal {
                max-height: 800px;
                width: 900px; /* SET THE WIDTH OF THE MODAL */
                margin: 0px 0 0 -450px; /* CHANGE MARGINS TO ACCOMODATE THE NEW WIDTH (original = margin: -250px 0 0 -280px;) */
            }

	    #myModal .modal-header {
		padding-top: 10px;
		max-height: 35px;
	    }

	    #myModal .modal-footer {
		padding: 0px 15px 0px;
	    }

	    #myModal .modal-body {
		min-height: 420px;
		padding-top: 5px;
	    }

	    #myModal .modal-body .span5 {
		width: 405px;
		margin-left: 5px;
	    }

	    #myModal .modal-body .span6 {
		width: 445px;
		margin-left: 5px;
	    }

	    #myModal .modal-tabs {

	    }

	    #myModal .pager {
		margin-top: 5px;
		margin-bottom: 5px;
	    }

            #modal-img {
                /*max-width: 400px;*/
            }

	    span {
		/*border: 1px solid #000000;*/
	    }




        </style>
	<link href="assets/css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">

	<link href="assets/css/imgareaselect/imgareaselect-default.css" rel="stylesheet">

        <link href="assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="assets/bootstrap/js/html5shiv.js"></script>
        <![endif]-->

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/bootstrap/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/bootstrap/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/bootstrap/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/bootstrap/ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="assets/bootstrap/ico/favicon.png">



	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/jquery-ui-1.10.1.custom.min.js"></script>
        <script src="assets/js/jQueryRotateCompressed.2.2.js"></script>
	<script src="assets/js/screenfull.min.js"></script>
	<script src="assets/js/jquery.imgareaselect.min.js"></script>


        <script>

	    var thumb_original = "<?php echo THUMB_ORIGINAL; ?>";
	    var thumb_400 = "<?php echo THUMB_400; ?>";
	    var thumb_200 = "<?php echo THUMB_200; ?>";
	    var thumb_100 = "<?php echo THUMB_100; ?>";

	    var date = new Date();
            var angle = 0;

            $(document).ready( function() {
    
    
		$('.container .thumbnail img').click(function () {
		    var filename = $(this).attr('alt').split('/').pop();
		    loadModal(filename);
		    $('#myModal').modal('show');
		}); 

                $('#myModal').on('hidden', function() {
                    $(this).removeData('modal');
                    angle = 0;
                    $('#modal-img').rotate(angle);
                });
    
                $('#modal-btn-rotate-left').click(  function() {
                    angle += 90;
                    $('#modal-img').rotate(angle);
                });
		
		$('#modal-btn-rotate-right').click(  function() {
                    angle -= 90;
                    $('#modal-img').rotate(angle);
                });
		
		
		$('#modal-btn-crop').click(  function() {
		    $('#modal-img').imgAreaSelect({x1: 120, y1: 90, x2: 280, y2: 210, maxWidth: 200, maxHeight: 150, handles: true });
		});
		
		$('#modal-btn-fullscreen').click(function() {
		    if ( screenfull ) {		
			var img = thumb_original + getFilename();
			$("#modal-img").attr("src", img);
			screenfull.toggle( $("#modal-img")[0] );
		    }
		});
		
		if (screenfull.enabled) {
		    screenfull.onchange = function() {
			if(!screenfull.isFullscreen) {
			    var img = thumb_400 + getFilename();
			    $("#modal-img").attr("src", img);
			}
			console.log('Am I fullscreen? ' + screenfull.isFullscreen ? 'Yes' : 'No');
		    };
		}
		
		
		
		$( "#modal-slider-brightness" ).on( "slide", function( event, ui ) {} );
		$( "#modal-slider-contrast" ).on( "slide", function( event, ui ) {} );
		$( "#modal-slider-smooth" ).on( "slide", function( event, ui ) {} );
		$( "#modal-slider-pixelate" ).on( "slide", function( event, ui ) {} );
		
		$( "#modal-slider-brightness" ).on( "slidestop", function( event, ui ) {
		    //console.log(ui.value)		    
		    var filesrc = thumb_400 + getFilename();
		    var  src = 'loader.php?action=filter&filesrc=' + filesrc + '&filter=brightness&brightness='+ui.value;
		    $("#modal-img").attr("src", src );
		} );
		
		$( "#modal-slider-contrast" ).on( "slidestop", function( event, ui ) {
		    //console.log(ui.value)
		    var filesrc = thumb_400 + getFilename();  
		    var  src = 'loader.php?action=filter&filesrc=' + filesrc + '&filter=contrast&contrast='+ui.value;
		    $("#modal-img").attr("src", src );
		} );
		
		$( "#modal-slider-smooth" ).on( "slidestop", function( event, ui ) {
		    //console.log(ui.value)		    
		    var filesrc = thumb_400 + getFilename();	    
		    var  src = 'loader.php?action=filter&filesrc=' + filesrc + '&filter=smooth&smooth='+ui.value;
		    $("#modal-img").attr("src", src );
		} );
		
		$( "#modal-slider-pixelate" ).on( "slidestop", function( event, ui ) {
		    //console.log(ui.value)		    
		    var filesrc = thumb_400 + getFilename();	    
		    var  src = 'loader.php?action=filter&filesrc=' + filesrc + '&filter=pixelate&blocksize='+ui.value;
		    $("#modal-img").attr("src", src );
		} );
		
		$('#btn-img-prev').click( function(){
		    
		    var img = getFilename();
		    var prev = '';
		    for(i=0; i<images.length; i++) {
			if(images[i] == img) {
			    if(prev == '') 
				return;
			    loadModal(prev);
			    return;	
			}
			prev = images[i];
		    }
		} );
		
		$('#btn-img-next').click( function(){
		    
		    var img = getFilename();
		    var prev = '';
		    for(i=images.length; i>=0; i--) {
			if(images[i] == img) {
			    if(prev == '') 
				return;
			    loadModal(prev);
			    return;	
			}
			prev = images[i];
		    }

		} );
		
		
		$('#modal-nav li').click(function(e) {
		    e.preventDefault();
		    $('#modal-nav li').removeClass('active');		    
		    $(this).addClass('active');
		    
		    $('.modal-tab').addClass('hide');
		    var tabContent = '#modal-tab-' + $(this).attr('id');
		    $(tabContent).removeClass('hide');
		   
		});
		
	    });
        
	
	    function getFilename() {
		return  $("#modal-img").attr("alt");
	    }
	
	    function loadModal(filename){
		loadFilters(filename);
		loadTools();
		loadInfos(filename);
		$("#modal-img").attr("src", thumb_400 + filename);
		$("#modal-img").attr("alt", filename);
		$('#myModal .modal-header H4').html(filename);
	    }
    
	    function loadFilters(filename) {
		    
		var  src = 'loader.php?action=filter&filesrc=' + thumb_100 + filename + '&filter=';
		
		$("#myModal .thumbnail").find('*').each( function (key, val) {
		
		    //console.log(key +' '+val)
		    var filter = $(val).attr('id').split('-').pop();
		    $(val).attr("src", src + filter + '&t=' + date.getTime());
		    $(val).click(function(){
			
			var filesrc = thumb_400 + getFilename();	    
			var  src = 'loader.php?action=filter&filesrc=' + filesrc + '&filter=' + filter;
			$("#modal-img").attr("src", src + '&t=' + date.getTime() );
			
		    });
	    
		});
	
	    }
	    
	    function loadTools() {
		$( "#modal-slider-brightness" ).slider({ values: [ 0 ], min: -255, max: 255 });
		$( "#modal-slider-contrast" ).slider({ values: [ 0 ], min: -100, max: 100 });
		$( "#modal-slider-smooth" ).slider({ values: [ 0 ],min: -8, max: 8 });
		$( "#modal-slider-pixelate" ).slider({ values: [ 0 ], min: 0, max: 10 });    
	    }
	    
	    function loadInfos(filename) {
	    
		var src ='loader.php?action=info&filesrc=' + thumb_original + filename;
		$.getJSON(src + '&t=' + date.getTime(), function(data) {
		    var items = [];
		    $.each(data, function(key, val) {
			items.push('<li id="' + key + '">' + key + ': ' + val + '</li>');
		    });
		    $('#modal-tab-infos').html('<ul>'+items.join('')+'</ul>');
		});
	    
	    } 
	    
	   
	    function convolution(obj) {
		filesrc = $("#modal-img").attr("src");
		console.log(filesrc)
		$("#modal-img").attr("src",'loader.php?action=convolution&filesrc='+filesrc+'&convolution='+obj[obj.selectedIndex].value);
	    }
	    

    
        </script>
    </head>

    <body>

        <div class="container">

            <ul class="thumbnails">

		<?php $images = array(); ?>

		<?php foreach (new \Easy\ImageFilterIterator(new DirectoryIterator(THUMB_200)) as $file) : ?>

		    <?php $images[] = $file->getFilename(); ?>

    		<li>
    		    <div class="thumbnail">
    			<img src="<?php echo $file->getPathname(); ?>" alt="<?php echo $file->getPathname(); ?>">
    		    </div>
    		    <!--
    		    <div>Nom : <?php echo $file->getFilename(); ?></div>
    		    <div>Poids : <?php echo round($file->getSize() / 1024); ?> Ko</div>   
    		    -->
    		</li>

		<?php endforeach; ?>

            </ul>

	</div> <!-- /container -->

	<script>
	    var images = <?php echo json_encode($images); ?>
	</script>

	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4></h4>
	    </div>
	    <div class="modal-body">

		<span class="span5">
		    <div>
			<img id="modal-img" alt="">
		    </div>
		    <div style="margin-top:5px">
			<a id="modal-btn-rotate-left" class="btn btn-small" href="#"><i class="icon-arrow-left"></i></a>
			<a id="modal-btn-rotate-right" class="btn btn-small" href="#"><i class="icon-arrow-right"></i></a>
			<a id="modal-btn-crop" class="btn btn-small" href="#"><i class="icon-screenshot"></i></a>
			<a id="modal-btn-fullscreen" class="btn btn-small" href="#"><i class="icon-fullscreen"></i></a>
		    </div>
		</span>
		<span class="span6">

		    <ul id="modal-nav" class="nav nav-tabs">
			<li class="active" id="filters"><a href="#">Filtres</a></li>
			<li id="tools"><a href="#">Outils</a></li>
			<li id="infos"><a href="#">Infos</a></li>
		    </ul>

		    <div class="modal-tabs">
			<div class="modal-tab" id="modal-tab-filters">
			    <ul class="thumbnails">
				<li>
				    <div class="thumbnail">
					<img id="modal-img-grayscale" />
				    </div>
				</li>
				<li>
				    <div class="thumbnail">
					<img id="modal-img-edgedetect" />
				    </div>
				</li>
				<li>
				    <div class="thumbnail">
					<img id="modal-img-emboss" />
				    </div>
				</li>
				<li>
				    <div class="thumbnail">
					<img id="modal-img-gaussian_blur" />
				    </div>
				</li>
				<li>
				    <div class="thumbnail">
					<img id="modal-img-mean_removal" />
				    </div>
				</li>
				<li>
				    <div class="thumbnail">
					<img id="modal-img-negate" />
				    </div>
				</li>
			    </ul>
			</div>

			<div id="modal-tab-tools" class="modal-tab hide">

			    <h3>Contrast</h3>
			    <div id="modal-slider-contrast"></div>

			    <h3>Brightness</h3>
			    <div id="modal-slider-brightness"></div>

			    <h3>Smooth</h3>
			    <div id="modal-slider-smooth"></div>

			    <h3>Pixelate</h3>
			    <div id="modal-slider-pixelate"></div>

			</div>

			<div id="modal-tab-infos" class="modal-tab hide">
			    infos caché
			</div>
		    </div>

		    <!--
		    <div>
		    <?php
		    $convolutions = Easy\Convolution::getConvolutionList();
		    ?>
			<select onchange="convolution(this)">
			    <option value="">--------------</option>
		    <?php foreach ($convolutions as $v) : ?>
    	
    			    <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
    	
		    <?php endforeach; ?>

			</select>
		    </div>

		    -->

		</span>

	    </div>
	    <div class="modal-footer">
		<ul class="pager">
		    <li class="previous"><a id="btn-img-prev" href="#">&larr; Prev</a></li>
		    <li class="next"><a id="btn-img-next" href="#">Next &rarr;</a></li>
		</ul>
	    </div>
	</div>


	<!-- Le javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<script src="assets/bootstrap/js/bootstrap-transition.js"></script>
	<script src="assets/bootstrap/js/bootstrap-alert.js"></script>
	<script src="assets/bootstrap/js/bootstrap-modal.js"></script>
	<script src="assets/bootstrap/js/bootstrap-dropdown.js"></script>
	<script src="assets/bootstrap/js/bootstrap-scrollspy.js"></script>
	<script src="assets/bootstrap/js/bootstrap-tab.js"></script>
	<script src="assets/bootstrap/js/bootstrap-tooltip.js"></script>
	<script src="assets/bootstrap/js/bootstrap-popover.js"></script>
	<script src="assets/bootstrap/js/bootstrap-button.js"></script>
	<script src="assets/bootstrap/js/bootstrap-collapse.js"></script>
	<script src="assets/bootstrap/js/bootstrap-carousel.js"></script>
	<script src="assets/bootstrap/js/bootstrap-typeahead.js"></script>

    </body>
</html>
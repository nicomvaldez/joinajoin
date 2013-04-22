<!-- <link rel="stylesheet" href="/css/jquery.ui.all.css" type="text/css" /> -->
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>-->
<!--
<script src="/js/jquery.ui.core.js"></script>
<script src="/js/jquery.ui.widget.js"></script>
<script src="/js/jquery.ui.button.js"></script> 
<script type="text/javascript" src="/js/jquery.ui.selectmenu.js"></script>
<link rel="stylesheet" href="/css/jquery.ui.selectmenu.css" type="text/css" /> --> 
<!-- nivo area -->



<style type="text/css">
    select, a.button { height: 25px; float: left; margin-right: 20px; }
    .city-dropdown { width: 150px; }
    .property-type-dropdown { width: 200px; }
    a.button { width: 150px; }
    a.button .ui-button-text { height: 25px; }
    
    ul.form { list-style: none; margin: 0; padding: 0; }
    ul.form li { float: left; margin-right: 20px; }
    .rectangle_center{
    	left: 50%;
        margin-left: -280px;
        padding-top: 0px;
        position: relative;
        width: 700px;
    	
    }
    
.collection_span4{
	min-width: 300px;
}

</style>

<script type="text/javascript">
//$(function() {
    //$('.city-dropdown, .property-type-dropdown').selectmenu({style:'dropdown'});
    //$('a.button').button();
//}); 

                                                              
</script>
	



<!--WELCOME AREA-->
    <div class="gray_bg">
        <div class="container">
            <div class="row welcome">
                <div class="span9" style="margin-left: 130px;">
                    <h1><?php echo __l('find & book enjoyable experiences');?></h1>
                    <p style="margin-bottom: 10px !important; font-size: 18px;color: #0099CC;"><em> The fun providing marketplace.</em></p>
                    <hr>                
                <!-- BUSCADOR -->                
				       <div class="rectangle_center" style="padding-left:10px; padding-bottom: 20px; margin:auto; width:860px;margin-left: -340px;">
				           
			<form id="searchform" method="get" action="/searches/mostrar">

                    <!-- input type="hidden" name="do" value="search"/ -->
                    <!--input type="hidden" name="data[Property][PropertyType]" value="20">						
                    <input type="hidden" name="data[Property][checkin]" value="2012-06-12">
                    <input type="hidden" name="data[Property][checkout]" value="2012-06-12">
                    <input type="hidden" name="data[Property][cityName]" value="Tandil, Buenos Aires, Argentina">
                    <input type="hidden" name="city" value="all"-->
                    <input type="hidden" name="do" value="search">
                    <!--
                    <input type="hidden" name="data[_Token][fields]" value="61345a5cd74164c81a8f8358c35c5282d9691d40%3AProperty.additional_guest%7CProperty.amenity%7CProperty.checkin%7CProperty.checkout%7CProperty.city%7CProperty.cityName%7CProperty.holidaytype%7CProperty.roomtype%7CProperty.type">
                    <input type="hidden" name="data[_Token][key]" value="001e70413b8ae0e26bffe3c0671d4ec2e5b8bb55">
                    -->

<?php /*
if($this->data) {
    $this->redirect(
        array(
            'action' => 'index',
            'city:'.$this->data['location']
        )
    );
}
*/ ?>


						<ul class="form">
							<li>
						        <select name="city" class="btn btn-large dropdown-toggle" style="height: 40px; text-align: left;">
						            <option select value="all">All Locations</option>
<!--
					            	<option value="all">Boston, USA</option>
					            	<option value="all">New York, USA</option>
					            	<!--option value="182">Washington DC, USA</option--><!--
					            	<option value="all">Tuscany, ITA</option>
					            	<option value="all">Canary Islands, ESP</option>
					            	<option value="all">Buenos Aires, ARG</option>-->
					            	<option value="196">Puerto Rico</option>
					            	<option value="253">United States</option>
					            	<option value="224">Spain</option>
					            	<!-- <option value="all">Other Locations</option> -->
						        </select>
						    </li>
<!--							
						    <li>

						        <select name="city" class="btn btn-large dropdown-toggle" style="height: 40px; text-align: left;">
						            <option value="all">Locations</option>
						            <?php 
						            	if(!empty ($cities)){ 
						            		foreach ($cities as $city_id => $city_name) { ?>
								            	<option value="<?= $city_id; ?>" <?php if(!empty($_GET["city"])){ if($_GET["city"] == $city_id){echo "selected";}else{NULL;}} ?>><?= $city_name; ?></option>
						            		<?php }; 
										}
						            ?>
						        </select>
						        
						    </li>
-->


						    <li>
						       <select name="property_type" class="btn btn-large dropdown-toggle" style="height: 40px; text-align: left;">
						            <option select value="all">All Categories</option>
						            <option value="17">Adventure</option>
					            	<option value="20">Fooding</option>
					            	<option value="18">Extreme Sports</option>
					            	<option value="24">Arts + Culture</option>
					            	<option value="19">Nightlife</option>						            
						            <!--
						            <?php
						            if(!empty($active_types)){
							            foreach ($active_types as $collection_search) { ?>
							            <option value="<?= $collection_search['Property_types']['id']; ?>" <?php 
							            if(!empty($_GET["property_type"])){
							            	 if($_GET["property_type"] == $collection_search['Property_types']['id']){
							            	 	 echo "selected";}} ?>>
							            	 	 <?= $collection_search['Property_types']['name']; ?>-->
							           	</option><!--
							            <?php }}; ?>-->
						        </select>
						    </li>
						    <li>
						        <!--a href="#" id="envio" class="btn btn-success btn-large">Search</a-->
						        <a href="javascript:document.forms['searchform'].submit();" class="btn btn-success btn-large">Search</a>
						    </li>
						</ul>
						
						<div style="clear: left;"></div>
				    </form>
					</div> 
                
                <!-- /BUSCADOR -->
                </div>
            </div>
        </div>
    </div>
    <!--/WELCOME AREA-->
  
    <!--SLIDER AREA-->
    <div class="slider_area">
        <div class="container">
            <div class="row">
                <div class="span4 collection_span4 hidden-phone">
                	<div class="full_widht">
                    	<h2><span class="label" style="width: 100%;">Have fun or make money with a Join</span></h2>
                    </div>	
                    <p><span class="pun"><em></em></span></p>
                    <!--p><span class="pun"><em>We make it fun and easy for adventurous travelers to find fun experiences with great people With our platform people can  make a living by doing what they love or renting what they own.</em></span></p-->
                    <hr class="visible-desktop">
	                    <div class="row visible-desktop">
	                        <div class="span2"><h4 class="visible-desktop">Join Provider:</h4>
	                            <ul style="margin-top:10px;" >
	                                <li><span class="colored">/// </span> Meet great people.</li>
	                                <li><span class="colored">/// </span> Earn money sharing fun or lending stuff.</li>
	                                <li><span class="colored">/// </span> View needed items to see what others want or need.</li>
	                                <li><span class="colored">/// </span> List for free.</li>
	                                <li><span class="colored">/// </span> Safe and secure transaction payments.</li>
	                            </ul>
	                        </div>
	                        
	                        <div class="span2"><h4 class="visible-desktop">Join Seeker:</h4>
	                            <ul style="margin-top:10px;" >
	                                <li><span class="colored">/// </span> Discover the world in a new way.</li>
	                                <li><span class="colored">/// </span> Rent fun stuff.</li>
	                                <li><span class="colored">/// </span> Save money.</li>
	                                <li><span class="colored">/// </span> Enjoy unique experiences.</li>
	                                <li><span class="colored">/// </span> Meet great people around the world.</li>
	                            </ul>
	                        </div>
	                    </div>
                    <hr>
					<p><span class="pun"><em>With our platform people can make a living by doing what they love or renting what they own.</em></span></p>
					<hr>
                    <a href="http://www.joinajoin.com/page/faq" class="btn btn-large btn-success mega" style="color:#FFF !important;"></i>Learn More</a>
                </div>
                <div class="span8">
                   	<div class="well slideJoin">
               		    <div id="wrapper">
					        <div class=" theme-default">
					            <div id="slider" class="nivoSlider">
					                <img src="assets/img/slide12.jpg" />
									<img src="assets/img/slide3.jpg" />
									<img src="assets/img/slide4.jpg" />
									<img src="assets/img/slide5.jpg" />
									<img src="assets/img/slide6.jpg" />
									<img src="assets/img/slide7.jpg" />
									<img src="assets/img/slide8.jpg" />
									<img src="assets/img/slide9.jpg" />
									<img src="assets/img/slide10.jpg" />
									<img src="assets/img/slide11.jpg" />
									
					            </div>
					            <!--
					            <div id="htmlcaption" class="nivo-html-caption">
					                <strong>This</strong> is an example of a <em>HTML</em> caption with <a href="#">a link</a>. 
					            </div>
					        	-->
					        </div>
                    	</div>    
                	</div>
                </div><!-- fin slider -->
            </div>
        </div>
    </div>
    <!--/SLIDER AREA-->



	<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>

	<!--div class="gray_bg" style="height: 50px;padding-top: 20px; text-align: center;"><div class="container"><h1 style="font-size: 25px !important;padding-top: 5px;">Collections</h1></div></div-->    	
	<div class="collections index">
	<div id="banner" class="banner-content">
	<div class="clearfix" style="width:1270px; margin:auto;">
	<div class="collection-top-block">
		<!-- h2 class="collection-header"><?php echo __l('Adventures and Experiences provided by YOU');?></h2 -->
	<ol class="collection-list" start="<?php echo $this->Paginator->counter(array('format' => '%start%'));?>">
		<div class="well well-collections" style="height: 220px; margin: 20px 20px 20px 28px; margin-left: 25px; max-width: 1128px;">
		
		
		<h2 style="padding: 1px; width: 85px; float: left;">Catalog</h2>
		<div id="proximamente" style="float: left;font-size: 1.3em; padding-top: 4px; color: #878787;"> ("soon you would be able to discover great Joins in all these categories")</div>
		<div class="clearfix" style="margin:auto;"></div>
		<hr>

<?php

if (!empty($collections)){

	$i = 0;
	 foreach ($collections as $collection){
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}?>
		<li<?php echo $class;?> style="width: 100px; height: 140px;margin:0 2px 20px 0 !important;">
		<?php if(!empty($collection['Attachment']['id'])){ ?>
    	    <?php echo $this->Html->showImage('Collection',$collection['Attachment'], array('dimension' => 'collage_thumb', 'alt' => sprintf(__l('[Image: %s]'), false)));?>
<!-- ORIGINAL    	    <?php echo $this->Html->link($this->Html->showImage('Collection',$collection['Attachment'], array('dimension' => 'collage_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($collection['Collection']['title'], false)), 'title' => $this->Html->cText($collection['Collection']['title'], false))), array('controller' => 'properties', 'action' => 'index', 'type'=>'collection','slug'=>$collection['Collection']['slug'], 'admin' => false), array('title'=>$this->Html->cText($collection['Collection']['title'],false),'escape' => false));?>-->
		<?php }else{ ?>
		<a href="<?php echo Router::url(array('controller' => 'properties', 'action' => 'index', 'type'=>'collection','slug'=>$collection['Collection']['slug'], 'admin' => false)); ?>" class='collections'>
	<div class="collection-image">
		<?php 
		// @todo "Collage Script"
			$i=1;
			foreach($collection['Property'] as $property){
			if($i > 4)
			{
				break;
			} ?>
			<?php echo $this->Html->showImage('Property',$property['Attachment'][0], array('dimension' => 'collage_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($collection['Collection']['title'], false)), 'title' => $this->Html->cText($collection['Collection']['title'], false)));?>
			<?php $i++; }; ?>
	</div>
		</a>

		<?php }; ?>
		<h3 style="font-size: 12px;">
		<?php echo $this->Html->cText($collection['Collection']['title'], false);?></h3>
<!-- ORIGINAL		<?php echo $this->Html->link($this->Html->cText($collection['Collection']['title'], false), array('controller' => 'properties', 'action' => 'index', 'type'=>'collection','slug'=>$collection['Collection']['slug'], 'admin' => false), array('title'=>$this->Html->cText($collection['Collection']['title'], false),'escape' => false)); ?></h3> -->
		<!-- <dl class="request-list1 view-list1 collection-list guest clearfix">
                      <dt class="properties" title ="<?php echo __l('Properties');?>">
                      <?php echo __l('Properties');?></dt>
                      <dd class="positive-feedback1">
                      <?php echo $this->Html->cInt($collection['Collection']['property_count']); ?>
                      </dd>
					  <!-- @todo "Collection city count, country count update" -->
         <!--/dl> -->
		<?php if($this->Auth->user('user_type_id') == ConstUserTypes::Admin): ?>
		<div class="actions"><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $collection['Collection']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $collection['Collection']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></div>
		<?php endif; ?>
	</li>
	<?php };
		}else{ ?>
		<li>
			<p class="notice"><?php echo __l('No Collections available');?></p>
		</li>
	<?php }; ?>
</ol>
</div>
<?php
if (!empty($collections)) {
   // echo $this->element('paging_links');
}
?>




<div id="marquesina" style="float: left; margin-left:110px;">
	<!-- MARQUESINA -->
	<ul id="js-news" class="js-hidden">
	    <li class="news-item">This is a beta pre release,  Don’t be surprised if you run into a few bugs here and there. Great features will be added soon. We’d love to hear your suggestions . Feel free to send us an email to info@joinajoin.com</li>
	</ul>
	<!-- fin marquesina -->
</div>





</div>
</div>
</div>



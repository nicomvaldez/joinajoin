<link rel="stylesheet" href="/css/jquery.ui.all.css" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="/js/jquery.ui.core.js"></script>
<script src="/js/jquery.ui.widget.js"></script>
<script src="/js/jquery.ui.button.js"></script>
<script type="text/javascript" src="/js/jquery.ui.selectmenu.js"></script>
<link rel="stylesheet" href="/css/jquery.ui.selectmenu.css" type="text/css" />

<style type="text/css">
select, a.button { height: 25px; float: left; margin-right: 20px; }
.city-dropdown { width: 150px; }
.property-type-dropdown { width: 200px; }
a.button { width: 150px; }
a.button .ui-button-text { height: 25px; }

ul.form { list-style: none; margin: 0; padding: 0; }
ul.form li { float: left; margin-right: 20px; }




</style>

<script type="text/javascript">
$(function() {
    $('.city-dropdown, .property-type-dropdown').selectmenu({style:'dropdown'});
    $('a.button').button();
});                                                                    
</script>

<form id="searchform" method="get" action="/properties/search2">
<input type="hidden" name="do" value="search"/>
<ul class="form">

    <li>
        <select name="city" class="city-dropdown">
            <option value="all">All Cities</option>
            
            <?php 
            	if(!empty ($cities)){ 
            		foreach ($cities as $city_id => $city_name) { ?>
		            	<option value="<?= $city_id; ?>" <?php if(!empty($_GET["city"])){ if($_GET["city"] == $city_id){echo "selected";}else{NULL;}} ?>><?= $city_name; ?></option>
            		<?php }; 
				}
            ?>
        </select>
    </li>
    <li>
       <select name="property_type" class="property-type-dropdown">
            <option value="all">All Types</option>
            
            <?php 
            if(!empty($collections_search)){
	            foreach ($collections_search as $collection_search) { ?>
	            <option value="<?= $collection_search['Collection']['id']; ?>" <?php 
	            if(!empty($_GET["property_type"])){
	            	 if($_GET["property_type"] == $collection_search['Collection']['id']){
	            	 	 echo "selected";}} ?>>
	            	 	 <?= $collection_search['Collection']['title']; ?>
	           	</option>
	            <?php }}; ?>
        </select>
    </li>
    <li>
        <a href="javascript:document.forms['searchform'].submit();" class="button">Search</a>
    </li>
</ul>

<div style="clear: left;"></div>
</form>

<p>&nbsp;</p>

<?php if (!empty($searched)) { ?>
    <?php if (count($search_properties)) { ?>
        <h2>Search Results</h2>

        <?php foreach ($search_properties as $property) : ?>
        <p>
               <div class="comment">
                    <div class="row">
                        <div class="span8">
                        	<img src="assets/img/avatar.jpg" alt="" class="avatar"  align="left"/>
                            <div>
                            <h5><a href="/property/<?= $property["Property"]["slug"]; ?>"><?= $property["Property"]["title"]; ?></a> <?= $property["Property"]["created"]; ?> <span class="small"><a class="badge" href="/property/<?= $property["Property"]["slug"]; ?>">View this Join</a></span></h5>
                            <em><?= $property["Property"]["description"]; ?>.</em>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                
        	<!-- <a href="/property/<?= $property["Property"]["slug"]; ?>"><?= $property["Property"]["title"]; ?></a> -->
       	
       	</p>
        <?php endforeach; ?>
    <?php }else { ?>
        <h2>No Search Results Found</h2>
    <?php }; ?>
<?php }; ?>

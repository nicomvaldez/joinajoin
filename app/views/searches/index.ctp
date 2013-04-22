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



<?php
//debug($search_keyword);
if($search_keyword){
    $city=isset($search_keyword['named']['cityname'])?$search_keyword['named']['cityname']:'';
    $latitude=isset($search_keyword['named']['latitude'])?$search_keyword['named']['latitude']:'';
    $longitude=isset($search_keyword['named']['longitude'])?$search_keyword['named']['longitude']:'';
    $checkin=isset($search_keyword['named']['checkin'])?$search_keyword['named']['checkin']:'';
    $checkout=isset($search_keyword['named']['checkout'])?$search_keyword['named']['checkout']:'';
    $additional_guest=isset($search_keyword['named']['additional_guest'])?$search_keyword['named']['additional_guest']:'';
    $type=isset($search_keyword['named']['type'])?$search_keyword['named']['type']:'';
    $is_flexible=isset($search_keyword['named']['is_flexible'])?$search_keyword['named']['is_flexible']:'';
    $holidaytype=isset($search_keyword['named']['holidaytype'])?$search_keyword['named']['holidaytype']:'';
    $roomtype=isset($search_keyword['named']['roomtype'])?$search_keyword['named']['roomtype']:'';
    $amenity=isset($search_keyword['named']['amenity'])?$search_keyword['named']['amenity']:'';
    $rangefrom=isset($search_keyword['named']['range_from'])?$search_keyword['named']['range_from']:'1';
    $rangeto=isset($search_keyword['named']['range_to'])?$search_keyword['named']['range_to']:'300+';
    $depositfrom=isset($search_keyword['named']['deposit_from'])?$search_keyword['named']['deposit_from']:'0';
    $depositto=isset($search_keyword['named']['deposit_to'])?$search_keyword['named']['deposit_to']:'300+';
    $keyword=isset($search_keyword['named']['keyword'])?$search_keyword['named']['keyword']:'';
    $cityy=isset($search_keyword['named']['city'])?$search_keyword['named']['city']:'all';
    $min_beds=isset($search_keyword['named']['min_beds'])?$search_keyword['named']['min_beds']:'1';
    $min_bedrooms=isset($search_keyword['named']['min_bedrooms'])?$search_keyword['named']['min_bedrooms']:'1';
    $min_bathrooms=isset($search_keyword['named']['min_bathrooms'])?$search_keyword['named']['min_bathrooms']:'1';
    if(!empty($rangeto))
    {
        $this->request->data['Property']['range_to']=$rangeto;
    }
}

?>









<form id="searchform" method="get" action="/searches/mostrar" >
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
                <option value="<?= $collection_search['Property_types']['id']; ?>" <?php 
                if(!empty($_GET["property_type"])){
                     if($_GET["property_type"] == $collection_search['Property_types']['id']){
                         echo "selected";}} ?>>
                         <?= $collection_search['Property_types']['name']; ?>
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

<?php if (!empty($properties)) { ?>
    <?php if (count($properties)) { ?>
        <h2>Search Results</h2>

        <?php foreach ($properties as $property) : ?>
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




<?php /*
    echo $this->Form->create('searches', array(
        'type'=>'post',
        'action' => 'mostrar'
    )); 

    echo $this->Form->input('ids', array(
        'type' => 'text',
        'value' => ''
    )); 

    echo $this->Form->end('ides'); 
*/
?>





<?php /*
    echo $this->Form->create('properties', array(
        'type'=>'post',
        'action' => 'index/'
    )); ?>


<?php
    echo $this->Form->input('RoomType', array(
        'type' => 'select',
        'multiple' => 'checkbox',
        'id' => 'RoomType',
        'label' => false
)); ?>


<?php
    echo $this->Form->input('Request.PropertyType', array(
        'type' => 'select',
        'multiple' => 'checkbox',
        'id' => 'PropertyTypes',
        'label' => false
)); ?>

<?php
    echo $this->Form->input('Request.HolidayType', array(
        'type' => 'select',
        'multiple' => 'checkbox',
        'id' => 'HolidayTypes',
        'label' => false
)); ?>

<?php

    echo $this->Form->input('Request.range_from', array(
        'type' => 'select',
        'options' => $range_from,
        'id' => 'js-range_from',
        'label' => false,
        'class' => 'hide'
    )); ?>
              <?php
    echo $this->Form->input('Request.range_to', array(
        'type' => 'select',
        'options' => $range_to,
        'id' => 'js-range_to',
        'value' => $rangeto,
        'label' => false,
        'class' => 'hide'
    )); ?>

                  <?php
    echo $this->Form->input('Request.Amenity', array(
        'type' => 'select',
        'multiple' => 'checkbox',
        'id' => 'Amenities',
        'label' => false
    )); ?>

<?php
    echo $this->Form->input('cityName', array(
        'type' => 'hidden',
        'id' => 'city_index',
        'value' => $city
    ));
    echo $this->Form->input('latitude', array(
        'type' => 'hidden',
        'value' => $latitude
    ));
    echo $this->Form->input('longitude', array(
        'type' => 'hidden',
        'value' => $longitude
    ));
    echo $this->Form->input('checkin', array(
        'type' => 'hidden',
        'value' => $checkin
    ));
    echo $this->Form->input('checkout', array(
        'type' => 'hidden',
        'value' => $checkout
    ));
    echo $this->Form->input('additional_guest', array(
        'type' => 'hidden',
        'value' => $additional_guest
    ));
    echo $this->Form->input('type', array(
        'type' => 'hidden',
        'value' => 'search'
    ));
    echo $this->Form->input('search', array(
        'type' => 'hidden',
        'value' => 'side'
    ));
    echo $this->Form->input('roomtype', array(
        'type' => 'hidden',
        'value' => $roomtype
    ));
    echo $this->Form->input('holidaytype', array(
        'type' => 'hidden',
        'value' => $holidaytype
    ));
    echo $this->Form->input('amenity', array(
        'type' => 'hidden',
        'value' => $amenity
    ));
    echo $this->Form->input('ne_longitude', array(
        'type' => 'hidden',
        'id' => 'ne_longitude_index'
    ));
    echo $this->Form->input('sw_longitude', array(
        'type' => 'hidden',
        'id' => 'sw_longitude_index'
    ));
    echo $this->Form->input('sw_latitude', array(
        'type' => 'hidden',
        'id' => 'sw_latitude_index'
    ));
    echo $this->Form->input('ne_latitude', array(
        'type' => 'hidden',
        'id' => 'ne_latitude_index'
    ));

    echo $this->Form->end('Mandale'); 

 
 */
?>





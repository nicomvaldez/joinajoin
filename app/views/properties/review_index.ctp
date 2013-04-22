      <div class="js-tabs  clearfix">
         <div class="pptab-menu-left">
          <div class="pptab-menu-right">
       <div class="pptab-menu-center clearfix">
        	<ul class="clearfix">
            		<li><?php echo $this->Html->link(__l('Reviews'), array('controller' => 'property_feedbacks', 'action' => 'index','property_id' =>$property_id,'type'=>'property','view'=>'compact'), array('title' => __l('Reviews')));?></li>
					<li><?php echo $this->Html->link(__l('Guest Photos'), array('controller' => 'property_feedbacks', 'action' => 'index','property_id' =>$property_id,'type'=>'photos','view'=>'compact'), array('title' => __l('Photos')));?></li>
					<li><?php echo $this->Html->link(__l('Guest Videos'), array('controller' => 'property_feedbacks', 'action' => 'index','property_id' =>$property_id,'type'=>'videos','view'=>'compact'), array('title' => __l('Videos')));?></li>
           	</ul>
            
        </div>
    	</div>
	 	</div>
	     <div class="pptview-mblock-ll">
            <div class="pptview-mblock-rr">
              <div class="pptview-mblock-mm clearfix">
	    <div id="Shopping_friends"></div>
        <div id="Reviews"></div>
        <div id="Top_comments"></div>
        <div id="All_users"></div>
        </div>
        </div>
        </div>
        <div class="pptview-mblock-bl">
         <div class="pptview-mblock-br">
            <div class="pptview-mblock-bb"></div>
           </div>
          </div>
    </div>
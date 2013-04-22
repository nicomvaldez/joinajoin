<?php 
if(!empty($type) && $type == 'guest'):?>
	<div class="js-calendar-response js-guestcalender-load-block">
		<p style="font-size: 10px">Select your date</p>
		<?php
            //$daysAvilable=array(1,2,3,4,5);
           echo $this->Calendar->month($year, $month, $data, '', $daysAvilable);
            
		?>
		<div id="leyenda_calendario" style="margin-left:-20px;">
			<?php echo $this->Html->image('nota_calendario2.png'); ?>
		</div>
	</div>
	
	
<?php else:?>
	<div class="calendarBody">
      <div id="calhead" style="padding-left:1px;padding-right:1px;">          
            <div class="cHead"><div class="ftitle"><?php echo __l('My Calendar');?></div>
                <div  id="js-edit-month" class="fbutton">
	                <div class="price-button">
                    	<input type="button" id="js-edit-month-price" value="Edit Monthly Price"/> 
                    </div>
                    <div id="js-edit-month-price-content" class="js-edit-month-price-bubble">
                    </div>
                </div>

                <div id="loadingpannel" class="ptogtitle loadicon" style="display: none;"><?php echo __l('Loading data...');?></div>
                 <div id="errorpannel" class="ptogtitle loaderror" style="display: none;"><?php echo __l('Sorry, could not load your data, please try again later');?></div>
            </div>          
            
            <div id="caltoolbar" class="ctoolbar">
            <div class="btnseparator"></div>
                        <div id="showdaybtn" class="fbutton">
                <div><span title='Day' class="showdayview">Day</span></div>
            </div>
              <div  id="showweekbtn" class="fbutton">
                <div><span title='Week' class="showweekview">Week</span></div>
            </div>
            <div  id="showmonthbtn" class="fbutton fcurrent">
                <div><span title='Month' class="showmonthview">Month</span></div>
            </div>

              <div  id="showreflashbtn" class="fbutton">
                <div><span title="Refresh view" class="showdayflash"><?php echo __l('Refresh');?></span></div>
                </div>
             <div class="btnseparator"></div>
                <div id="sfprevbtn" title="Prev"  class="fbutton">
                  <span class="fprev"></span>

                </div>
                <div id="sfnextbtn" title="Next" class="fbutton">
                    <span class="fnext"></span>
                </div>
                <div class="fshowdatep fbutton">
                        <div>
                            <input type="hidden" name="txtshow" id="hdtxtshow" />
                            <span id="txtdatetimeshow"><?php echo __l('Loading');?></span>

                        </div>
                </div>

            <div class="clear"></div>
            </div>
      </div>
      <div style="padding:1px;">

        <div class="t1 chromeColor">
            &nbsp;</div>
        <div class="t2 chromeColor">
            &nbsp;</div>
        <div id="dvCalMain" class="calmain printborder clearfix">
        	<div id="gridcontainer1" class="<?php echo $clss=!empty($id)?'calendar':'fullcalendar'; ?>" style="overflow-y: visible;">
            </div>
            <div id="gridcontainer" class="<?php echo $clss=!empty($id)?'calendar':'fullcalendar'; ?>" style="overflow-y: visible;">
            </div>
        </div>
        <div class="t2 chromeColor">

            &nbsp;</div>
        <div class="t1 chromeColor">
            &nbsp;
        </div>   
        </div>
     
  </div>
     <script type="text/javascript">
        $(document).ready(function() {     
           var view="month";          
           
            var DATA_FEED_URL =  __cfg('path_relative')+"properties/datafeed/property_id:<?php echo $id;?>";
            var op = {
                view: view,
                theme:3,
                showday: new Date(),
                EditCmdhandler:Edit,
                DeleteCmdhandler:Delete,
                ViewCmdhandler:View,    
                onWeekOrMonthToDay:wtd,
                onBeforeRequestData: cal_beforerequest,
                onAfterRequestData: cal_afterrequest,
                onRequestDataError: cal_onerror, 
                autoload:true,
				enableDrag:false,
                url: DATA_FEED_URL + "?method=list",  
                quickAddUrl: DATA_FEED_URL + "?method=add", 
                quickUpdateUrl: DATA_FEED_URL + "?method=update",
                quickDeleteUrl: DATA_FEED_URL + "?method=remove"        
            };
            var $dv = $("#calhead");
            var _MH = document.documentElement.scrollHeight;
            var dvH = $dv.height() + 2;
            op.height = _MH - dvH;
            op.eventItems =[];

            var p = $("#gridcontainer").bcalendar(op).BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
            $("#caltoolbar").noSelect();
            
            $("#hdtxtshow").datepicker({ picker: "#txtdatetimeshow", showtarget: $("#txtdatetimeshow"),
            onReturn:function(r){                 
                            var p = $("#gridcontainer").gotoDate(r).BcalGetOp();
                            if (p && p.datestrshow) {
                                $("#txtdatetimeshow").text(p.datestrshow);
                            }
                     } 
            });
            function cal_beforerequest(type)
            {
                var t="Loading data...";
                switch(type)
                {
                    case 1:
                        t="Loading data...";
                        break;
                    case 2:                      
                    case 3:  
                    case 4:    
                        t="The request is being processed ...";                                   
                        break;
                }
                $("#errorpannel").hide();
                $("#loadingpannel").html(t).show();    
            }
            function cal_afterrequest(type)
            {
                switch(type)
                {
                    case 1:
                        $("#loadingpannel").hide();
                        break;
                    case 2:
                    case 3:
                    case 4:
                        $("#loadingpannel").html("Success!");
                        window.setTimeout(function(){ $("#loadingpannel").hide();},2000);
                    break;
                }              
               
            }
            function cal_onerror(type,data)
            {
                $("#errorpannel").show();
            }
            function Edit(data)
            {

               var eurl=__cfg('path_absolute')+"properties/calendar_edit?id={0}&start={2}&end={3}&isallday={4}&title={1}&model={12}&property_id={10}&current_status={9}&price={13}";   
                if(data)
                {
                    var url = StrFormat(eurl,data);
                    OpenModelWindow(url,{ width: 600, height: 400, caption:"Manage  The Calendar",onClose:function(){
						alert('hello');
                       $("#gridcontainer").reload();
                    }});
                }
            }    
            function View(data)
            {
                var str = "";
                $.each(data, function(i, item){
                    str += "[" + i + "]: " + item + "\n";
                });
                alert(str);               
            }    
            function Delete(data,callback)
            {           
                
                $.alerts.okButton="Ok";  
                $.alerts.cancelButton="Cancel";  
                hiConfirm("Are You Sure to Delete this Event", 'Confirm',function(r){ r && callback(0);});           
            }
            function wtd(p)
            {
               if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $("#showdaybtn").addClass("fcurrent");
            }
            //to show day view
            $("#showdaybtn").click(function(e) {
                //document.location.href="#day";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("day").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
				$("#gridcontainer").css('width', '100%');
				$("#gridcontainer1").css('width', '0%');
				$("#gridcontainer1").hide();
            });
            //to show week view
            $("#showweekbtn").click(function(e) {
                //document.location.href="#week";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("week").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
				$("#gridcontainer").css('width', '100%');
				$("#gridcontainer1").css('width', '0%');
				$("#gridcontainer1").hide();
            });
            //to show month view
            $("#showmonthbtn").click(function(e) {
                //document.location.href="#month";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("month").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
				$("#gridcontainer").css('width', '87%');
				$("#gridcontainer1").css('width', '13%');
				$("#gridcontainer1").show();
            });
            
            $("#showreflashbtn").click(function(e){
                $("#gridcontainer").reload();
            });
            
            //Add a new event
            $("#faddbtn").click(function(e) {
                var url ="edit.php";
                OpenModelWindow(url,{ width: 500, height: 400, caption: "Create New Calendar"});
            });
            //go to today
            $("#showtodaybtn").click(function(e) {
                var p = $("#gridcontainer").gotoDate().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }


            });
            //previous date range
            $("#sfprevbtn").click(function(e) {
                var p = $("#gridcontainer").previousRange().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }

            });
            //next date range
            $("#sfnextbtn").click(function(e) {				
                var p = $("#gridcontainer").nextRange().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
            });
            
        });
		
    </script> 
<?php endif;?>

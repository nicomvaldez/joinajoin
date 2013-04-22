<?php /* SVN: $Id: $ */ ?>
<div class="properties properties-import">
	<div class="clearfix">
	<h2><?php echo __l('Import your properties from') . ' ';?></h2><span class="airbnb-logo grid_left"><?php echo __l('AirBnB'); ?></span></div>
	<?php if($steps <= 3):  ?>
		<ul id="stage" class="stage tab-link clearfix">
			<li class="tb <?php if($steps == 1): ?>highlight<?php endif; ?> <?php if($steps >= 1): ?>active<?php endif; ?>"><?php echo __l('AirBnB Login');?></li>
			<li class="tb <?php if($steps == 2): ?>highlight<?php endif; ?> <?php if($steps >= 2): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo __l('Import Properties');?></li>
		</ul>
	<?php endif; ?>
	<?php echo $this->Form->create('Property', array('action' => 'import', 'class' => 'normal add-property'));?>
		<?php if($steps >= 1):  ?>
			<div <?php if($steps > 1): ?>class="hide"<?php endif;?>>
				<fieldset>
					<p class="page-information page-information1"><?php echo __l('Note: We will not store your AirBnB email and password.'); ?></p>
					<div class="padd-bg-tl">
						<div class="padd-bg-tr">
							<div class="padd-bg-tmid"></div>
						</div>
					</div>
					<div class="padd-center">
						<?php echo $this->Form->input('airbnb_email', array('label' => __l('AirBnB Email')));  ?>
						<?php echo $this->Form->input('airbnb_password', array('label' => __l('AirBnB Password'), 'type' => 'password')); ?>
					</div>
					<div class="padd-bg-bl">
						<div class="padd-bg-br">
							<div class="padd-bg-bmid"></div>
						</div>
					</div>
				</fieldset>
				<div class="submit-block clearfix">
					<?php 
						if($steps == 1):
							echo $this->Form->submit(__l('Next'),array('name' => 'data[Property][step1]'));
						endif;
					?>
				</div>
			</div>
		<?php endif; ?>
		<?php if($steps >= 2):  ?>
			<div <?php if($steps > 2): ?>class="hide"<?php endif;?>>
				<fieldset>
					<div class="padd-bg-tl">
						<div class="padd-bg-tr">
							<div class="padd-bg-tmid"></div>
						</div>
					</div>
					<div class="padd-center">
						<table class="list">
							<tr>
								<th><?php echo __l('Select'); ?></th>
								<th class="dl"><?php echo __l('Property'); ?></th>
							</tr>
							<?php $is_show_import_button = 0; ?>
							<?php if (!empty($properties)): ?>
								<?php foreach($properties as $property): ?>
									<?php $disabled = (in_array($property['Property']['id'], array_values($importedProperties))) ? true : false; ?>
									<?php
										if (!$disabled):
											$is_show_import_button = 1;
										endif;
									?>
									<tr>
										<td><?php echo ($disabled) ? '<span class="active">' . __l('Imported') . '</span>' : $this->Form->input('Property.' . $property['Property']['id'] . '.id', array('type' => 'checkbox', 'id' => 'admin_checkbox_' . $property['Property']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
										<td class="dl"><?php echo $property['Property']['title']; ?><?php echo $this->Form->input('Property.' . $property['Property']['id'] . '.title', array('type' => 'hidden', 'value' => $this->Html->cText($property['Property']['title'],false))); ?></td>
									</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr>
									<td colspan="2"><?php echo __l('No properties available'); ?></td>
								</tr>
							<?php endif; ?>
						</table>
					</div>
					<div class="padd-bg-bl">
						<div class="padd-bg-br">
							<div class="padd-bg-bmid"></div>
						</div>
					</div>
				</fieldset>
				<div class="submit-block clearfix">
					<?php if (!empty($properties) && $is_show_import_button): ?>
						<?php 
							if($steps == 2):
								echo $this->Form->submit(__l('Import'),array('name' => 'data[Property][step2]'));
							endif;
						?>
					<?php endif; ?>
					<div class="cancel-block">
						<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'properties', 'action' => 'index', 'type' => 'myproperties', 'status' => 'imported'), array('class' => 'cancel-link dc', 'title' => __l('Cancel'), 'escape' => false));?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php echo $this->Form->end();?>
</div>

 <div class="timingsrow">
 	<?php if(!empty($available_time)): ?>
 	<?php foreach ($available_time as $key => $value): ?>
	    <div class="tbadge"><?php echo date('g:i a',strtotime($value['time_start'])); ?> - <?php echo date('g:i a',strtotime($value['time_end'])); ?> <span class="tclose"><a href="javascript:void(0)" class="delete_schedule" data-delete-val="<?php echo $value['appointment_id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a></span></div>
    <?php endforeach; ?>
<?php endif; ?>
</div>
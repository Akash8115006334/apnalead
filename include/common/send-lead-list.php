<li class="data-list lead-lists bg-light" loading="lazy">
    <label class="flex-s-b align-items-center w-100">
        <span class="text-primary checkbox w-pr-5">
            <input type="checkbox" name="selected_lead_for_transfer[]" style="margin-top:0.2rem;" class="p-1" value="<?php echo $leads->LeadsId; ?>">
        </span>
        <span class="w-pr-5">
            <span class='count'><?php echo $Count; ?></span>
        </span>
        <span class="bold  w-pr-20"><?php echo $leads->LeadSalutations; ?> <?php echo $leads->LeadPersonFullname; ?></span>
        <span class="bold  w-pr-15"><?php echo $leads->LeadPersonPhoneNumber; ?></span>

        <span class='text-danger w-pr-20'>
            <?php echo LeadStage($leads->LeadPersonStatus); ?>
            <!-- <span class='text-gray'>
                <?php //echo FETCH("SELECT * FROM lead_followups where LeadFollowMainId='" . $leads->LeadsId . "' ORDER BY LeadFollowUpId DESC", "LeadFollowCurrentStatus"); 
                ?>
            </span> -->
        </span>
        <span class="w-pr-10">
            <span class="italic text-warning" style="font-size:0.7rem !important;"><?php echo $leads->LeadPersonSource; ?></span>
        </span>

        <span class="w-pr-20">
            <span class="text-grey"> By <?php echo FETCH("SELECT * FROM users where UserId='" . $leads->LeadPersonManagedBy . "'", "UserFullName"); ?></span>
        </span>
    </label>
</li>
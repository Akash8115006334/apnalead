<div class="col-md-6" loading="lazy">
    <div class="list-record bg-light">
        <a target="_blank" class="w-100" href="<?php echo APP_URL; ?>/leads/details/index.php?LeadsId=<?php echo SECURE($leads->LeadsId, "e"); ?>">
            <p class="data-list w-100" loading="lazy" style="line-height:1rem;margin-bottom:0.5rem !important;">
                <span>
                    <span class='count'><?php echo $Count; ?></span>
                    <span class="text-primary">
                        <input type="checkbox" name="selected_lead_for_transfer[]" style="margin-top:0.1rem;" value="<?php echo $leads->LeadsId; ?>">
                    </span>
                    <span class="bold h6"><?php echo $leads->LeadSalutations; ?> <?php echo $leads->LeadPersonFullname; ?></span>
                    <br>
                    <span class='text-danger'>
                        <?php echo LeadStage($leads->LeadPersonStatus); ?>
                        <br>
                        <span class='text-gray'>
                            <?php echo FETCH("SELECT * FROM lead_followups where LeadFollowMainId='" . $leads->LeadsId . "' ORDER BY LeadFollowUpId DESC", "LeadFollowCurrentStatus"); ?>
                        </span>
                    </span>
                    <span class="italic text-info italic">
                        <?php $Data = FETCH("SELECT * FROM lead_requirements where LeadMainId='" . $leads->LeadsId . "'", "LeadRequirementDetails");
                        $projects = FETCH("SELECT * FROM projects WHERE ProjectsId='$Data'", "ProjectName");
                        if ($Data != null) {
                            echo "<br>For " . $projects;
                        } ?>
                    </span>
                    <br>
                    <span>
                        <span class="italic text-warning" style="font-size:0.7rem !important;"><?php echo $leads->LeadPersonSource; ?></span><br>
                        <span class="text-grey"> By <?php echo FETCH("SELECT * FROM users where UserId='" . $leads->LeadPersonManagedBy . "'", "UserFullName"); ?></span>
                        <span class="pull-right" style="margin-top:-2.5rem !important;"><?php echo LeadStatus($leads->LeadPriorityLevel); ?></span>
                    </span>
                </span>
            </p>
        </a>
    </div>
</div>
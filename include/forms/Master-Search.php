<section class="pop-section hidden" id="Master_Search">
    <div class="action-window w-75">
        <div class='container w-pr-50 mt-5 mb-5 '>
            <form class="row" action="<?php echo APP_URL; ?>/search" enctype="multipart/form-data" method="GET">
                <div class="form-group col-md-12 text-center">
                    <center>
                        <span>
                            <img src="<?php echo STORAGE_URL . '/company/img/logo/logo.webp' ?>" style="box-shadow:none !important" alt="companylogo" class=" w-75 mb-5">
                        </span>
                        <br>
                        <div class="w-100 text-center mt-3 ">
                            <h2 class="text-center"><i class="fa fa-search fs-40 text-success"></i> Search in <span class="text-primary"><?php echo FETCH("SELECT company_name FROM config_companies WHERE company_id='" . CompanyId . "'", "company_name"); ?></span></h2>
                            <input type="search" name="search" class="form-control form-control-lg " required="" min="3" placeholder="Search name, phone or email">
                        </div>
                    </center>
                </div>
                <div class="col-md-12 text-center mt-5">
                    <button type="submit" name="SearchRecords" class="btn btn-lg btn-success"><i class="fa fa-search"></i> Search </button>
                    <a href="#" onclick="Databar('Master_Search')" class="btn btn-lg mt-3 btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
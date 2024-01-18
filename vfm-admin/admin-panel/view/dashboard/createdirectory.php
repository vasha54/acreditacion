<?php
/**
 * Create directory
 **/
?>
<div id="view-create-directory" class="anchor"></div>
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center align-items-center">
                <h4 class="m-0"><i class="bi bi-folder"></i> <?php echo $setUp->getString("create_directory"); ?></h4>
                <button type="button" class="btn ms-auto" data-bs-toggle="collapse" data-bs-target="#card-create-directory" aria-expanded="false">
                    <i class="bi bi-dash-lg"></i>
                </button>
            </div>
            <div class="collapse show" id="card-create-directory">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label"><?php echo $setUp->getString("year"); ?></label>
                        <select class="form-select" name="year_directory">
                            <?php
                                $current_year = date('Y');
                                $min_year = $current_year - 10;
                                $max_year = $current_year + 10;
                                for ($i=$min_year; $i <= $max_year; $i++) {  
                                    if($i == $current_year){
                            ?>
                                    <option value="<?php echo $i; ?>" selected ><?php echo $i; ?></option>
                            <?php   }else{
                            ?>
                                    <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
                            <?php  }
                                } 
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label"><?php echo $setUp->getString("type_acreditation"); ?></label>
                        <select class="form-select" name="type_acreditation">
                            <?php
                            foreach ($setUp->getConfig("type_acreditation") as $key => $value) {
                                ?>
                                <option value="<?php echo $key; ?>" ><?php echo $setUp->getString($value); ?></option>
                                <?php
                            } ?>
                        </select>    
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <label class="form-label col-md-12"><?php echo $setUp->getString("name"); ?></label>    
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <input class="form-control"  type="text" name="name_directory" id="name_directory">        
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary tooltipper" 
                                    for="notify_newfolder" data-bs-placement="top" data-bs-toggle="tooltip" title="<?php echo $setUp->getString("create_directory"); ?>">
                                    <i class="bi bi-folder-plus"></i>
                                </button>        
                            </div>        
                        </div>
                    </div>
                </div><!-- row -->
            </div><!-- box-body -->
            </div>
        </div><!-- box -->
    </div><!-- col 12 -->
</div><!-- row -->

<?=load_plugin('css', array('profile-2'))?>
<div class="tab-pane active" id="tab_1_1">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> QR Code</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php 
                            $qrimg = file_exists(STORE_QR.$this->uri->segment(4).'.png');
                            if($qrimg!='1'): ?>
                                <form action="<?=base_url('hr/attendance/generate_qrcode/').$this->uri->segment(4)?>">
                                    <p>QR Code not exists <button type="submit" class="btn btn-sm green">Generate New</button></p>
                                </form> <?php 
                            else: ?>
                                <form action="<?=base_url('hr/attendance/download_qrcode/').$this->uri->segment(4)?>">
                                    <img src="<?=base_url(STORE_QR.$this->uri->segment(4).'.png')?>" alt="">
                                    <p style="margin-left: 15px;">
                                        <button type="submit" class="btn btn-sm blue">Download</button></p>
                                </form>
                                <?php
                            endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
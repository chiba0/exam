

<div class="form-box w80p" id="login-box">
    <div class="header text-left f18"><?=$ttest['name']?></div>
    <form action="/users/login/<?=$id?>" method="POST" >
    
        <div class="body bg-gray">
            <h4>個人情報属性</h4>
            <div class="form-group">
                <label>氏名</label>
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="name1" value="<?=$name1?>" class="form-control" />
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="name2" value="<?=$name2?>" class="form-control" />
                    </div>
                </div>
                <br />
                <label>ふりがな</label>
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="kana1" value="<?=$kana1?>" class="form-control" />
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="kana2" value="<?=$kana2?>" class="form-control" />
                    </div>
                </div>
                <br />
                <label>性別</label>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group" data-toggle="buttons">
                            
                            <?php foreach($array_gender as $key=>$value):
                                $chk = $act = "";
                                if($key == $gender){
                                    $chk = "checked";
                                    $act = "active";
                                }
                                ?>
                                <label class="btn btn-default <?=$act?>">
                                    <input type="radio" name="gender" value="<?=$key?>" autocomplete="off" <?=$chk?>> <?=$value?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                        
                </div>
                <br />
                <label>生年月日</label>
                <div class="row">
                    <div class="col-md-12">
                        <?=$birth_y?>年
                        <?=$birth_m?>月
                        <?=$birth_d?>日
                        <input type="hidden" name="birth_y" value="<?=$birth_y?>" />
                        <input type="hidden" name="birth_m" value="<?=$birth_m?>" />
                        <input type="hidden" name="birth_d" value="<?=$birth_d?>" />
                    </div>
                    
                </div>
            </div>          
            
            
                
        </div>
        <div class="footer">
            <div class="row">
                <div class="col-md-6">
                    <a href="/users/login/<?=$id?>" class="btn btn-default btn-block">ログイン画面</a>
                </div>
                <div class="col-md-6">
                    <input type="submit" class="btn bg-primary btn-block" name="regist" value="検査メニュー" /> 
                </div>

            </div>
            <input type="hidden" name="_csrfToken" value="<?= $this->request->getParam('_csrfToken') ?>">
            <input type="hidden" name="userid" value="<?=$this->request->getData('userid')?>" />
         </div>
    </form>


</div>
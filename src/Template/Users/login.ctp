

<div class="form-box w80p" id="login-box">
    <div class="header text-left f18"><?=$ttest['name']?></div>
    <form action="/users/login/<?=$id?>" method="POST" >
    
        <div class="body bg-gray">
            <h4>
                検査を実施します。<br />
                指示されたID/生年月日を入力後ログインを行ってください。
            </h4>
            <div class="form-group">
                <label>ログインID</label><br />
                <input type="text" name="userid" value="<?=$this->request->getData('userid')?>" class="form-control" placeholder="User ID"/>
                <br />
                <label>生年月日</label>
                <div class="row">
                    <div class="col-md-2">
                        <input type="text" name="birth_y" value="<?=$this->request->getData("birth_y")?>" class="form-control" placeholder="年" />
                    </div>
                    <div class="col-md-2">
                        <select name="birth_m" class="form-control" >
                            <?php for($i=1;$i<=12;$i++):
                                    $sel = "";
                                    if($this->request->getData("birth_m") == $i){
                                        $sel = "SELECTED";
                                    }
                                ?>
                                <option value="<?=$i?>" <?=$sel?>><?=$i?>月</option>
                            <?php endfor;?>
                        </select>

                    </div>
                    <div class="col-md-2">
                        <select name="birth_d" class="form-control" >
                            <?php for($i=1;$i<=31;$i++):
                                $sel = "";
                                if($this->request->getData("birth_d") == $i){
                                    $sel = "SELECTED";
                                }
                                
                                ?>
                                <option value="<?=$i?>" <?=$sel?> ><?=$i?>日</option>
                            <?php endfor;?>
                        </select>
                    </div>
                </div>
            </div>          
            
            
                
        </div>
        <div class="footer">                                                               
            <input type="submit" class="btn bg-primary btn-block" name="login" value="ログイン" /> 
            <input type="hidden" name="_csrfToken" value="<?= $this->request->getParam('_csrfToken') ?>">
        </div>
    </form>


</div>
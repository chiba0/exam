<div class=" w100p" >
    <div class="row">
        <div class="col-md-12">
            <h4 class="page-header">
             <?=$ttest['name']?> 
            </h4>
            <div class="box ">
            
                <div class="box-body">
                
                    <form action="/exams12/exam/<?=$id?>" method="POST" >


                        <div class="table-responsive">

                            <table class="table table-bordered table-">
                                <thead>
                                <tr class="table-exam">
                                    <th class="w5p">No</th>
                                    <th class="">A</th>
                                    <th class="w5p">
                                        <div class="textbox">
                                            <p class="vertical">明確にＡ</p>
                                        </div>
                                    </th>
                                    <th class="w5p">
                                        <div class="textbox">
                                            <p class="vertical">どちらかというとＡ</p>
                                        </div>
                                    </th>
                                    <th class="w5p">
                                        <div class="textbox">
                                            <p class="vertical">どちらともいえない</p>
                                        </div>
                                    </th>
                                    <th class="w5p">
                                        <div class="textbox">
                                            <p class="vertical">どちらかというとＢ</p>
                                        </div>
                                    </th>
                                    <th class="w5p">
                                        <div class="textbox">
                                            <p class="vertical">明確にＢ</p>
                                        </div>
                                    </th>
                                    <th class="">B</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($exam[$pager] as $key=>$value):
                                    
                                    ?>
                                    <tr>
                                        <td><?=$key?></td>
                                        <td><?=$value['a']?></td>
                                        <?php for($i=1;$i<=5;$i++):
                                                $chk = "";
                                                $q = "q".$key;
                                                if(!empty($ttp[$q]) && $ttp[$q] == $i){
                                                    $chk = "checked";
                                                }
                                            ?>
                                            <td class="text-center">
                                                <input type="checkbox" name="chk[<?=$key?>]" value="<?=$i?>" class="exam_chk chk_<?=$key?>" <?=$chk?> />
                                            </td>
                                        <?php endfor;?>
                                        <td><?=$value['b']?></td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center mt20">
                            <?php if($pager > 1):?>
                            <input type="submit" name="back" class="btn btn-info" value="前のページへ" />
                            <?php endif;?>
                            <?php if($pager < 4):?>
                                <input type="submit" name="next" class="btn btn-primary" value="次のページへ" />
                            <?php else:?>
                                <input type="submit" name="next" class="btn btn-primary" value="結果ページへ" />
                            <?php endif;?>
                            <input type="hidden" name="_csrfToken" value="<?=$token?>">
                            <input type="hidden" name="pager" value="<?=$pager+1?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>

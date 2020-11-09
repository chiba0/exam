<div class=" w100p" >
    <div class="row">
        <div class="col-md-12">
            <h4 class="page-header">
             <?=$ttest['name']?> 
            </h4>
            <div class="box ">
            
                <div class="box-body">
                
                    <form action="/exams2/exam/<?=$id?>" method="POST" >
               
                        <div class="box-header">
                            <h3 class="box-title"><?=$ttp->name?>さんの結果</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <p>
                                <?=$result['text0']?>
                            </p>
                            <p><?=$result['text1']?></p>
                            <p><?=$result['text2']?></p>
                            <p class="text-center"><img src="<?=D_HOME_URL?>/img/baj/<?=$result['text3']?>" /></p>
                            <p><?=$result['text4']?></p>
                        </div><!-- /.box-body -->
                        <div class="text-center">
                            <a href="/exams/menu/<?=$id?>" class="btn btn-primary" >検査メニューへ</a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>

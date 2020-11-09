

<div class="col-md-12">
    <div class="box box-solid">
        <div class="box-header pd5">
            <h3 class="box-title">
                <i class="fa fa-caret-square-o-right"></i>
                <?=$ttest['name']?>
            </h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <h4>検査選択メニュー</h4>
            <p>
            受検して頂く検査は<?=count($menu)?>つです。<br />下記の検査名を選択して下さい。
            </p>
            <?php foreach($menu as $key=>$value):
                    if($value['exam_state'] == 2):
            ?>
                <p class="btn btn-success btn-block text-left" disabled ><?=$value[ 'name' ]?>
                <small class="badge  bg-red">受検済</small>
                </p>
            <?php else: ?>
                <a href="/exams<?=$value['type']?>/guide/<?=$id?>" class="btn btn-success btn-block text-left">
                <i class="fa fa-fw fa-mail-forward"></i>
                    <?=$value[ 'name' ]?></a>
            <?php 
                    endif;
                endforeach;
            ?>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div>




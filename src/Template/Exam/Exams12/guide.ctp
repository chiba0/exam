<div class=" w100p" >
    <div class="row">
        <div class="col-md-12">
            <h4 class="page-header">
             <?=$ttest['name']?> 
            </h4>
            <div class="box ">
            
                <div class="box-body">
                
                    <form action="/exams12/exam/<?=$id?>" method="POST" >
                        <ol class="guide">
                            <li>
                            各設問に対し、現在のご自身が取るであろう傾向を選択肢の中から選択してください。
                            </li>
                            <li>質問は36問あります。受検時間の目安は１０分です</li>
                            <li>回答を入力しないと次に進めませ</li>
                            <li>ブラウザの「戻る」ボタンは使えません。ページ下部の「戻る」ボタンで、前のページまで戻れます。</li>
                            <li>
                                <b>
                            １つの質問には、AとBの２つの文があります。AとBを比較して、あなたに当てはまる程度を選択し、１つの質問に対し、１箇所のみチェックをしてください。どちらにも当てはまっていない場合、あるいはまったく同じ程度当てはまっている場合には、「どちらともいえない」にチェックしてください。
                                </b>
                            </li>
                            <li>
                                検査の途中で何らかの原因によりログアウトした場合や、検査を中断された場合は、再度ログインし直してください。
                            </li>
                            <li>
                            個人情報は当社のプライバシーポリシーに従って適切に取り扱います。
                            </li>
                            <li>
                                個人情報を適切な方法で管理し、お客様および受検者の同意なく、第三者に対し開示することはありません。ただし、研究開発または統計分析を目的として、受検者に関する検査結果を含む個人情報を、個人が識別または特定できないように編集加工し、無償で利用する場合があります。
                            </li>
                        </ol>
                        <div class="text-center">
                            <input type="submit" name="start" class="btn btn-primary" value="テスト開始" />
                            <input type="hidden" name="_csrfToken" value="<?= $this->request->getParam('_csrfToken') ?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>

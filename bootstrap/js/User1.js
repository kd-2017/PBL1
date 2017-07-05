 $(function(){
	// ユーザー登録画面にてファイルアップロードする
	$('#fileUpload').change(function() {
		$('#FileUpTextBox').val($(this).val());
	});

	// 確認ダイアログ
	$('#Submit').click(function() {
		if(confirm('登録されている生徒のデータが消えてしまいます。よろしいですか？')){ // 確認ダイアログを表示
			return true; // 「OK」時は送信を実行
		}
		else{ // 「キャンセル」時の処理
			return false; // 送信を中止
		}
	});
})
 $(function(){
	$( "#selectable" ).selectable({
      	stop: function() {
	        $( ".ui-selected", this ).each(function() {
    	      var index = $( "#contentu" ).index( this );
       	 	});
      	},
	    filter: 'td',
	    delay: 1
    });

	// テーブルセルクリック時イベント
	$( "[id=contentu]" ).click(function(){
		var clas = $(this).attr("class"); 
		var classes = clas.split(' '); 
		// クリックした出欠コード取得
		var attendance = $(this).html();
		// 空文字の場合はスルー
		if ( attendance != "" ) {
			// 出欠コードが5以下のとき
			if ( attendance < 5) {
				// 1足す
				attendance++;
			// 出欠コードが5のとき
			} else if ( attendance == 5 ) {
				// 出欠コードを0にもどす
				attendance = 0;
			}
			// コードによってセル内の色変える
			switch (attendance) {
				case 0:
		    		$(this).css({'background-color': '#ffffff'});
					break;
				case 1:
		    		$(this).css({'background-color': '#ffff00'});
					break;
				case 2:
		    		$(this).css({'background-color': '#ff0000'});
					break;
				case 3:
		    		$(this).css({'background-color': '#00ffff'});
					break;
				case 4:
		    		$(this).css({'background-color': '#00ff00'});
					break;
				case 5:
		    		$(this).css({'background-color': '#1c90eb'});
					break;
			}
			// hidden の 値変更
			$("input[id="+classes[4]+"]").val(attendance);
			// 出欠コード再表示
			$(this).html(attendance);
		}
	});

	// 一括変更ラジオボタン変更時
	$( 'input[name="attendance"]:radio' ).click( function() {
		$("#selectable .ui-selected").html($(this).val());
			$("#selectable .ui-selected").each(function(){
			 	var clas = $(this).attr("class"); 
			 	var classes = clas.split(' '); 
				// hidden の 値変更
				$("input[id="+classes[4]+"]").val($("input:radio[name='attendance']:checked").val());
			});
		var attendance = parseInt($(this).val());
		switch (attendance) {
			case 0:
	    		$("#selectable .ui-selected").css({'background-color': '#ffffff'});
				break;
			case 1:
	    		$("#selectable .ui-selected").css({'background-color': '#ffff00'});
				break;
			case 2:
	    		$("#selectable .ui-selected").css({'background-color': '#ff0000'});
				break;
			case 3:
	    		$("#selectable .ui-selected").css({'background-color': '#00ffff'});
				break;
			case 4:
	    		$("#selectable .ui-selected").css({'background-color': '#00ff00'});
				break;
			case 5:
	    		$("#selectable .ui-selected").css({'background-color': '#1c90eb'});
				break;
		}
	});
 
})
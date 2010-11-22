<?php
	/*
	* To load mp4
	* I consulted http://yu-ki-report.com/index.php/archives/74 .
	*/
	$path=urldecode($_GET["p"]);
	$file=preg_replace("/\\\+/"," ",$path);//ファイル名に空白があると+に変換されるので、+を空白に戻す
	$file_size = filesize( $file ) ;

	$unique_name = $file;
	header( "Accept-Ranges: bytes" ) ;
	//header('Content-type: video/mp4');

	$unique_file = $unique_name;
	$handle = fopen($unique_file, 'rb');
	if ($handle === false) {
	return false;
	}

	if( isset( $_SERVER['HTTP_RANGE'] ) ) {

	list($toss, $range) = explode('=', $_SERVER['HTTP_RANGE']);
	list($range_start, $range_end) = explode('-', $range);

	$size = $file_size - 1;
	$length = $range_end - $range_start +1;

	header('HTTP/1.1 206 Partial Content');
	header('Content-type: video/mp4');
	header('Content-Length: ' . $length);
	header('Content-Range: bytes ' . $range . '/' . $file_size);
	header("Etag: \"" . md5( $_SERVER["REQUEST_URI"] ) . $file_size . "\"" );
	header("Last-Modified: " . gmdate( "D, d M Y H:i:s", filemtime($file)) . " GMT");
	fseek($handle, $range_start);

	}else {

	 // 一回目のリクエスト
	 // Content-Length のヘッダと、ファイル全体をレスポンス
	$content_length = $file_size ;
	header('Content-type: video/mp4');
	header('Content-Length: ' . $file_size);
	header("Etag: \"" . md5( $_SERVER["REQUEST_URI"] ) . $file_size . "\"" );
	header("Last-Modified: " . gmdate( "D, d M Y H:i:s", filemtime($file)) . " GMT");

	}

	@ob_end_clean();
	while (!feof($handle) && connection_status() == 0 && !connection_aborted()) {
	set_time_limit(0);
	$buffer = fread($handle,8192);
	echo $buffer;
	@flush();
	@ob_flush();
	}
	fclose($handle);
	exit(0);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PostgreSQL AutoIncrement for Existing Table</title>
</head>
<body id="main_body" >
	<div id="form_container">
	
		<h1><a>PostgreSQL AutoIncrement for Existing Table</a></h1>
		<form id="form" method="post" action="">
			<ul >
			<li id="li_1" >
		<label >Nama Tabel </label>
		<div>
			<input id="element_1" name="table" class="element text medium" type="text" maxlength="255" value="<?php echo $_POST["table"];?>"/> 
		</div>
		</li>		<li id="li_2" >
		<label>Nama Field (yg di autoincrement / primary key) </label>
		<div>
			<input id="element_2" name="field" class="element text medium" type="text" maxlength="255" value="<?php echo $_POST["field"];?>"/> 
		</div>
		</li>		<li id="li_3" >
		<label class="description" for="element_3">Opsi </label>
		<span>
			<input id="element_3_1" name="element_3_1" class="element checkbox" type="checkbox" value="1" checked="checked"/>
<label class="choice" for="element_3_1">Alter Filed to INT8 (atau bisa ganti ke int4 / int2 kalau data kecil)</label>

		</span> 
		</li>
		<li class="buttons">
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
			</ul>
		</form>	
	</div>
<pre>
<?php
if (empty($_POST["field"])){
	$_POST["field"] = "id_".$_POST["table"];
} else {
	$_POST["field"] = $_POST["field"];
}

echo "-- ubah ".$_POST["field"]." jadi INT8 INT4 atau INT2 sesuai kebutuhan JIKA SEBELUMNYA VARCHAR !!\n";
echo "ALTER TABLE ".$_POST["table"]." ALTER COLUMN ".$_POST["field"]." TYPE INT8 USING (".$_POST["field"]."::integer);\n\n";
//ALTER TABLE the_table ALTER COLUMN col_name TYPE integer USING (col_name::integer);

echo "-- ubah ".$_POST["field"]." jadi INT8 INT4 atau INT2 sesuai kebutuhan (salah satu) \n";
echo "ALTER TABLE ".$_POST["table"]." ALTER COLUMN ".$_POST["field"]." TYPE INT2;\n";
echo "ALTER TABLE ".$_POST["table"]." ALTER COLUMN ".$_POST["field"]." TYPE INT4;\n";
echo "ALTER TABLE ".$_POST["table"]." ALTER COLUMN ".$_POST["field"]." TYPE INT8;\n\n";

// DEFAULT nextval('perpus_pola_seq'::regclass) NOT NULL
echo "-- buat sequencenya \n";
echo "CREATE SEQUENCE ".$_POST["table"]."_seq OWNED BY ".$_POST["table"].".".$_POST["field"].";\n\n";

echo "-- ubah kepemilikan sequencenya (tidak perlu gpp, atas sudah di set owner juga) \n";
echo "ALTER SEQUENCE ".$_POST["table"]."_seq OWNED BY ".$_POST["table"].".".$_POST["field"].";\n\n";

echo "-- ubah field id ke defualt jadi nexvalue sequencenya  \n";
echo "ALTER TABLE ".$_POST["table"]." ALTER COLUMN ".$_POST["field"]." SET DEFAULT nextval('".$_POST["table"]."_seq'::regclass);\n\n";

echo "-- ubah nilai nexvalue sequencenya jika tabel sudah terdapat data sebelumnya \n";
echo "SELECT setval('".$_POST["table"]."_seq', (SELECT MAX(".$_POST["field"].") FROM ".$_POST["table"]."), FALSE);\n\n";

echo "-- ubah ".$_POST["field"]." jadi primary key jika diperlukan \n";
echo "ALTER TABLE ".$_POST["table"]."  ADD PRIMARY KEY (".$_POST["field"].");\n";
?></pre>
</body>
</html>

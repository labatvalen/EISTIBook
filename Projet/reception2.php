<?php
session_start();
print_r($_POST);
echo "<br>";
print_r($_FILES);
print_r($_FILES['fileToUpload']['name']);


    require("util.php");
    error_reporting(-1);
    ini_set('display_errors', 'On');

    function imagethumb( $image_src , $image_dest = NULL , $max_size = 100, $expand = FALSE, $square = FALSE )
    {
	if( !file_exists($image_src) ) return FALSE;

	// Récupère les infos de l'image
	$fileinfo = getimagesize($image_src);
	if( !$fileinfo ) return FALSE;

	$width     = $fileinfo[0];
	$height    = $fileinfo[1];
	$type_mime = $fileinfo['mime'];
	$type      = str_replace('image/', '', $type_mime);

	if( !$expand && max($width, $height)<=$max_size && (!$square || ($square && $width==$height) ) )
	{
		// L'image est plus petite que max_size
		if($image_dest)
		{
			return copy($image_src, $image_dest);
		}
		else
		{
			header('Content-Type: '. $type_mime);
			return (boolean) readfile($image_src);
		}
	}

	// Calcule les nouvelles dimensions
	$ratio = $width / $height;

	if( $square )
	{
		$new_width = $new_height = $max_size;

		if( $ratio > 1 )
		{
			// Paysage
			$src_y = 0;
			$src_x = round( ($width - $height) / 2 );

			$src_w = $src_h = $height;
		}
		else
		{
			// Portrait
			$src_x = 0;
			$src_y = round( ($height - $width) / 2 );

			$src_w = $src_h = $width;
		}
	}
	else
	{
		$src_x = $src_y = 0;
		$src_w = $width;
		$src_h = $height;

		if ( $ratio > 1 )
		{
			// Paysage
			$new_width  = $max_size;
			$new_height = round( $max_size / $ratio );
		}
		else
		{
			// Portrait
			$new_height = $max_size;
			$new_width  = round( $max_size * $ratio );
		}
	}

	// Ouvre l'image originale
	$func = 'imagecreatefrom' . $type;
	if( !function_exists($func) ) return FALSE;

	$image_src = $func($image_src);
	$new_image = imagecreatetruecolor($new_width,$new_height);

	// Gestion de la transparence pour les png
	if( $type=='png' )
	{
		imagealphablending($new_image,false);
		if( function_exists('imagesavealpha') )
			imagesavealpha($new_image,true);
	}

	// Gestion de la transparence pour les gif
	elseif( $type=='gif' && imagecolortransparent($image_src)>=0 )
	{
		$transparent_index = imagecolortransparent($image_src);
		$transparent_color = imagecolorsforindex($image_src, $transparent_index);
		$transparent_index = imagecolorallocate($new_image, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
		imagefill($new_image, 0, 0, $transparent_index);
		imagecolortransparent($new_image, $transparent_index);
	}

	// Redimensionnement de l'image
	imagecopyresampled(
		$new_image, $image_src,
		0, 0, $src_x, $src_y,
		$new_width, $new_height, $src_w, $src_h
	);

	// Enregistrement de l'image
	$func = 'image'. $type;
	if($image_dest)
	{
		$func($new_image, $image_dest);
	}
	else
	{
		header('Content-Type: '. $type_mime);
		$func($new_image);
	}

	// Libération de la mémoire
	imagedestroy($new_image);

	return TRUE;
}

    function upload($index,$destination,$maxsize=FALSE,$extensions=FALSE)
    {
        //Test1: fichier correctement uploadé
            if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0) return FALSE;
        //Test2: taille limite
            if ($maxsize !== FALSE AND $_FILES[$index]['size'] > $maxsize) return FALSE;
        //Test3: extension
            $ext = substr(strrchr($_FILES[$index]['name'],'.'),1);
            if ($extensions !== FALSE AND !in_array($ext,$extensions)) return FALSE;
        //Déplacement et ajout dans la BDD
            $nom = md5(uniqid(rand(), true)).'.'.$ext;
            $image_sizes = getimagesize($_FILES['fileToUpload']['tmp_name']);
            $taille = "$image_sizes[0]"."x"."$image_sizes[1]";
            initImg1($taille,$nom,$ext);
            move_uploaded_file($_FILES[$index]['tmp_name'],$destination.$nom);
            chmod ($destination.$nom,0755);
            imagethumb($destination.$nom, $destination.'miniatures/'.$nom, 90);
            return(chmod ($destination.'miniatures/'.$nom,0755));
    }

    //Action

        $upload = upload('fileToUpload','images/',50000, array('png','gif','jpg','jpeg') );

        if ($upload) "Upload de l'icone réussi!<br/>"; //modifier avec ajax
        print_r($_SESSION['idpdp']);
?>

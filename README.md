EasyGD
======

EasyGD - a PHP framework for use GD easier


# The basic stuff 


#### How to load and show an image

    (new Image())->load($filename)->show();
	
#### How to load and save an image on disk

    (new Image())->load($filename)->save('php.png');

#### How to load, save and show an image in the same time

    (new Image())->load($filename)->save('php.png')->show();

#### How to make multiple save

    (new Image())->load($filename)->save('php.png')
    ->setType(IMAGETYPE_GIF)->save('php.gif')
    ->setType(IMAGETYPE_JPEG)->save('php.jpg');

----

# Include the image in the HTML

You can use the data src property to render the image quickly in the HTML tag.<br />
Use it only on small image, if you dont want that your html page becommes to big. 

```
<img src="<?php echo (new Image())->load($filename)->dataSrc() ?>" />
```

# The other types

#### Define a dimension
    $dimension = (new Dimension)->create(300, 300);

#### Define a color
    // Create a color with hexadecimal code
    $color = (new Color())->create('#83d01e');
    // OR create a color from a preset
    $color = (new Color())->create(Color::Yellow);
    // OR create a preseted color 
    $color = Color::Yellow();

#### Define a position
    $position = (new Position)->create(200, 125);

#### Define a GD text
    $text = (new Text())->create('Hello World');

# Create your own images

#### How to create a truetype image
    (new Image())->create($dimension, $color)->show();

----

# Adding text in the images 


#### How to add a GD text into an image
    (new Image)->create((new Dimension)->create(300, 300), Color::Blue())
    ->addText(
        (new Text())->create('Hello World')
            ->setColor(Color::Silver())
            ->setSize(3)
            ->setPosition((new Position)->create(200, 125))
    )->show();

#### How to draw a string vertically into an image
    (new Image())->create((new Dimension())->create(200, 200))->addText(
	(new Text())->create('gd library')
		->setSize(5)
		->setColor(Color::White())
		->setDrawtype(Text::TEXT_DRAW_VERTICAL)
		->setPosition((new Position())->create(40, 100))
    )->show();

#### How to apply an alpha color to a text into an image
    (new Image)->create((new Dimension())->create(300, 300), Color::White())
	->addText(
		(new Text())->create('Alpha Color')
			->setColor(
				(new Color())->create('#FF0000')->setAlpha(95)
			)
			->setSize(5)
			->setPosition((new Position())->create(55, 35))
	)
	->show();

#### How to mix "GD text", "TrueType text", "FreeType text" into an image

    (new Image())->create((new Dimension())->create(300, 300), (new Color())->create('#f2f2f2'))
	->addText(
		(new Text())->create('True Type')
			->setFontType(Text::TEXT_FONT_TRUETYPE)
			->setFontfile(Text::TEXT_UNIX_FONT_PATH . '/truetype/dejavu/DejaVuSans.ttf')
			->setColor(Color::Silver())
			->setSize(16)
			->setAngle(45)
			->setPosition((new Position())->create(100, 100))
	)
	->addText(
		(new Text())->create('Hello ' . PHP_EOL . 'Free Type')
			->setFontType(Text::TEXT_FONT_FREETYPE)
			->setFontfile(Text::TEXT_UNIX_FONT_PATH . '/truetype/dejavu/DejaVuSans.ttf')
			->setColor(Color::Silver())
			->setSize(16)
			->setAngle(45)
			->setPosition((new Position())->create(100, 175))
	)
	->addText(
		(new Text())->create('hello world')
			->setColor(Color::Maroon())
			->setPosition((new Position())->create(98, 173))
	)
	->show();

----

# Get the informations

#### How to get the information about an image
    $imageInfo = (new Image())->load($filename)->getInfos();
    echo '<pre>', $imageInfo, '</pre>';


    filename : https://www.php.net/images/logos/new-php-logo.png 
	width : 200 
	height : 106 
	type : 3 
	img : width="200" height="106" 
	mime : image/png 
	channels :  
	bits : 8 


#### How to get / add the IPTC tag
    $fileDst = __DIR__ . '/iptc.jpg';
    $iptc = $imageInfo->getIpct();
    $iptc->addTag(\Easy\Iptc::IPTC_CITY, 'CHEVERNY')
	    ->addTag(Easy\Iptc::IPTC_COUNTRY, 'FRANCE')
	    ->addTag(Easy\Iptc::IPTC_CREATED_DATE, '2012-03-01')
	    ->addTag(Easy\Iptc::IPTC_CATEGORY, 'JOURNEY');

    if ($iptc->write($fileSrc, $fileDst) === false)
	throw new Exception('Error to write IPTC');

#### How to have the preseted positions

    $image = (new Image())->load($filename);

    echo 'TOP_LEFT:', $image->topLeft(), '<br/>';
    echo 'TOP_CENTER:', $image->topCenter(), '<br/>';
    echo 'TOP_RIGHT:', $image->topRight(), '<br/>';
    echo 'MIDDLE_LEFT', $image->middleLeft(), '<br/>';
    echo 'MIDDLE_CENTER', $image->middleCenter(), '<br/>';
    echo 'MIDDLE_RIGHT', $image->middleRight(), '<br/>';
    echo 'BOTTOM_LEFT', $image->bottomLeft(), '<br/>';
    echo 'BOTTOM_CENTER', $image->bottomeCenter(), '<br/>';
    echo 'BOTTOM_RIGHT', $image->bottomRight(), '<br/>';

It will return an object Position ...

----

# Transformations

## Resizing the images

#### How to resize an image
    (new Image)->load($filename)
    ->resizeByPercent(0.5)
    ->show();

#### How to resize an image by fixing the width or height
    (new Image)->load($filename)
    ->resizeByWidth(50)
    ->show();

    (new Image)->load($filename)
    ->resizeByHeight(30)
    ->show();

#### How to safetly resize an image 
    (new Image)->load($filename)
    ->resizeAuto((new Dimension())->create(300, 200))
    ->show();

#### How to make a thumbnail
    (new Image)->load($filename)
    ->thumbnail(140, Color::Silver())
    ->show();

## Croping and Rotation

#### How to crop an image
    (new Image)->load($filename)
    ->crop((new Position)->create(20, 13), (new Dimension())->create(80, 40))
    ->show();

#### How to make a rotation
    (new Image)->load($filename)
    ->rotate(90)
    ->show();

## Merging two images

#### How to insert a logo into an image

    $logo = (new Image)->load('http://www.php.net/images/logos/php-med-trans-light.gif')
        ->resizeByPercent(0.6);
    $src8 = (new Image)->load('http://static.php.net/www.php.net/images/logos/php-med-trans.png')
        ->inlay($logo, (new Position)->create(30, 20), 100)
        ->show();

## Make thumbnails

Here you can find an example to, easyly, generate some thumbnails.

```
$text = (new Text)->create('Copyright (C) 2020 Your Name')
	->setFontType(Text::TEXT_FONT_TRUETYPE)
	->setFontfile(Text::TEXT_UNIX_FONT_PATH . '/truetype/dejavu/DejaVuSans.ttf')
	->setSize(5)
	->setColor(Color::White())
	->setPosition((new Position())->create(40, 190));

$path = __DIR__ . '/images/original/';

foreach (new ImageFilterIterator(new DirectoryIterator($path)) as $file) {

	if (($image = (new Image)->load($file->getPathname())) === false) {
		continue;
	}

	$thumb1 = $image->thumbnail(100)->dataSrc();
	$thumb2 = $image->thumbnail(200)->addText($text)->dataSrc();
	$thumb3 = $image->thumbnail(400)->dataSrc();
?>

	<img src="<?php echo $thumb1 ?>" />
	<img src="<?php echo $thumb2 ?>" />
	<img src="<?php echo $thumb3 ?>" />
	<br />
<?php
}
?>
```

----

# Filters

## Using the preset filter

You can use : 

+ PRESET_NEGATE
+ PRESET_GRAYSCALE
+ PRESET_EDGEDETECT
+ PRESET_EMBOSS
+ PRESET_GAUSSIAN_BLUR
+ PRESET_MEAN_REMOVAL
+ PRESET_SELECTIVE_BLUR
+ PRESET_PIXELATE
+ PRESET_SMOOTH
+ PRESET_CONTRAST
+ PRESET_BRIGHTNESS
+ PRESET_COLORIZE

#### How to create a preset filter
    $filter = Easy\Preset::PRESET_GRAYSCALE();

#### How to apply the filter
    $filter->process($image)->show();

## Using the convolution filter

You can use preseted convolution or your own convolution filters.

#### How to use a preseted convolution
    $filter = Easy\Convolution::CONVOLUTION_LAPLACIEN_1();
    $filter->process($image)->show();

#### How to use your own convolution
    $matrix = array(-1, 7, -1,
    0, 0, 0,
    1, 7, 1
    );

    $filter = \Easy\Convolution::create($matrix);
    $filter->process($image)->show();

## Using the lookuptable filter

You can use preseted lookuptable or your own lookuptable filters.

#### How to use a preseted lookuptable
    $filter = \Easy\LookUpTable::create('Negative');
    $filter->process($image)->show();

#### To create a new lookuptable filter, you must create a callback method like this :

    private function Special($rgb) {
	$r = ($rgb['red'] > 128) ? max($rgb['green'], $rgb['blue']) : min($rgb['green'], $rgb['blue']);
	$g = ($rgb['green'] > 128) ? max($rgb['red'], $rgb['blue']) : min($rgb['red'], $rgb['blue']);
	$b = ($rgb['blue'] > 128) ? max($rgb['green'], $rgb['red']) : min($rgb['green'], $rgb['red']);
	return array($r, $g, $b);
    }

    $filter = \Easy\LookUpTable::create('Special');
    $filter->process($image)->show();
    
## Using all the filters with the factory

You can use filters with a common syntax.
The factory, use the three types of filter :
+ FILTER_PRESET
+ FILTER_LOOKUPTABLE
+ FILTER_CONVOLUTION

#### Using the factory, it is easy !!!!

    $filter = Easy\FilterFactory::create(Easy\FilterFactory::FILTER_LOOKUPTABLE, 'Negative');

OR
    
    $filter = Easy\FilterFactory::create(Easy\FilterFactory::FILTER_PRESET, 'PRESET_EMBOSS');

OR

    $filter = Easy\FilterFactory::create(Easy\FilterFactory::FILTER_CONVOLUTION, $matrix);

OR

    $filter = Easy\FilterFactory::create(Easy\FilterFactory::FILTER_CONVOLUTION, 'CONVOLUTION_LAPLACIEN_1');

AND APPLY THE FILTER

    $filter->process($image)->show();
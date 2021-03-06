EasyGD
======

EasyGD is a PHP framework to use GD easier<br/>
The frame allows you to easily load images from a file, URL or string.<br/>
After loading the image, you can apply transformations.<br/>
You can then choose to save the result as a file, either to return a character string, or to send the image directly to the browser.<br/>

## Installing

Installation is quite typical - with composer:

```
composer require easygithdev/easygd
```

## The header script

You will need to include the autoloader before using the classes.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Easygd\Image;

```

## The basic stuff 

In all the examples that follow, the $stream variable is either a URL or a file or a character string.<br/>
For example, you can use the PHP logo with the following URL:

```php
$stream = 'https://www.php.net/images/logos/new-php-logo.png';
```

![PHP Logo](https://www.php.net/images/logos/new-php-logo.png)

#### How to load and show an image

In this case, the stream is directly sent to the browser.

```php
(new Image())->load($stream)->show();
```	

#### How to load and render an image in a HTML tag

You can use the data src property to render the image in the HTML tag.<br />
Use it only on small image, if you dont want that your HTML page becommes to big. 

```php
<img src="<?php echo (new Image())->load($stream)->src() ?>" />
```

#### How to load and save an image on disk

In this case, the stream is saved to the browser.

```php
(new Image())->load($stream)->save('php.png');
```

#### How to load, save and show an image in the same time

```php
(new Image())->load($stream)->save('php.png')->show();
```

#### How to make multiple save

```php
(new Image())->load($stream)->save('php.png')
->setType(IMAGETYPE_GIF)->save('php.gif')
->setType(IMAGETYPE_JPEG)->save('php.jpg');
```

----


## The other types

#### Define a dimension

```php
$dimension = (new Dimension())->create(300, 300);
```

#### Define a color

```php
// Create a color with hexadecimal code
$color = (new Color())->create('#83d01e');

// OR create a color from a preset
$color = (new Color())->create(Color::Yellow);

// OR create a preseted color 
$color = Color::Yellow();
```

#### Define a position

```php
$position = (new Position())->create(200, 125);
```

#### Define a text

```php
$text = (new Text())->create('Hello World');
```

## Create your own images

#### How to create a truetype image

```php
(new Image())->create($dimension, $color)->show();
```

----

## Adding text in the images 

#### How to draw a text into an image

```php
(new Image)->create((new Dimension)->create(300, 300), Color::Blue())
->addText(
(new Text())->create('Hello World')
    ->setColor(Color::Silver())
    ->setSize(3)
    ->setPosition((new Position)->create(200, 125))
)->show();
```

#### How to draw a string vertically into an image

```php
(new Image())->create((new Dimension())->create(200, 200))->addText(
	(new Text())->create('gd library')
	->setSize(5)
	->setColor(Color::White())
	->setDrawtype(Text::TEXT_DRAW_VERTICAL)
	->setPosition((new Position())->create(40, 100))
)->show();
```

#### How to apply an alpha color to a text into an image
    
```php    
(new Image)->create((new Dimension())->create(300, 300), Color::White())->addText(
	(new Text())->create('Alpha Color')
	->setColor(
		(new Color())->create('#FF0000')->setAlpha(95)
	)
	->setSize(5)
	->setPosition((new Position())->create(55, 35))
)
->show();
```

#### How to mix "GD text", "TrueType text", "FreeType text" into an image

```php
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
```

----

## Get the informations

#### How to get the information about an image

```php
$infos = (new Image())->load($stream)->getInfos();
echo '<pre>', $infos, '</pre>';

$infos = (new Image())->load($stream)->getInfos()->toArray();
echo '<pre>', print_r($infos, true), '</pre>'; 
```

#### How to have the preseted positions

```php
$image = (new Image())->load($stream);

echo 'TOP_LEFT:', $image->topLeft(), '<br/>';
echo 'TOP_CENTER:', $image->topCenter(), '<br/>';
echo 'TOP_RIGHT:', $image->topRight(), '<br/>';
echo 'MIDDLE_LEFT', $image->middleLeft(), '<br/>';
echo 'MIDDLE_CENTER', $image->middleCenter(), '<br/>';
echo 'MIDDLE_RIGHT', $image->middleRight(), '<br/>';
echo 'BOTTOM_LEFT', $image->bottomLeft(), '<br/>';
echo 'BOTTOM_CENTER', $image->bottomeCenter(), '<br/>';
echo 'BOTTOM_RIGHT', $image->bottomRight(), '<br/>';
```

It will return an object Position ...

#### How to get / add the IPTC tag

Remember IPTC work with JPEG files.

```php
(new Image())->load($stream)->setType(IMG_JPEG)->save('iptc.jpg');

$fileSrc = __DIR__ . '/iptc.jpg';
$fileDst = __DIR__ . '/iptc2.jpg';

$iptc = (new Iptc())->create($fileSrc, null);
$iptc->addTag(Iptc::IPTC_CITY, 'CHEVERNY')
    ->addTag(Iptc::IPTC_COUNTRY, 'FRANCE')
    ->addTag(Iptc::IPTC_CREATED_DATE, '2012-03-01')
    ->addTag(Iptc::IPTC_CATEGORY, 'JOURNEY');

if ($iptc->write($fileDst) === false) {
    throw new Exception('Error to write IPTC');
}
echo '<pre>', (new Image())->load($fileDst)->getInfos(), '</pre>';
```

----

## Resizing the images

#### How to resize an image

```php
(new Image)->load($stream)
->resizeByPercent(0.5)
->show();
```

#### How to resize an image by fixing the width or height

```php
(new Image)->load($stream)
->resizeByWidth(50)
->show();

(new Image)->load($stream)
->resizeByHeight(30)
->show();
```

#### How to safetly resize an image 

```php
(new Image)->load($stream)
->resizeAuto((new Dimension())->create(300, 200))
->show();
```

#### How to make a thumbnail

```php
(new Image)->load($stream)
->thumbnail(140, Color::Silver())
->show();
```

## Croping and Rotation

#### How to crop an image

```php
(new Image)->load($stream)
->crop((new Position)->create(20, 13), (new Dimension())->create(80, 40))
->show();
```

#### How to make a rotation

```php
(new Image)->load($stream)
->rotate(90)
->show();
```

## Merging two images

#### How to insert a logo into an image

```php
$logo = (new Image)->load('http://www.php.net/images/logos/php-med-trans-light.gif')
->resizeByPercent(0.6);

(new Image)->load('http://static.php.net/www.php.net/images/logos/php-med-trans.png')
->inlay($logo, (new Position)->create(30, 20), 100)
->show();
```

## Make thumbnails

Here you can find an example to, easyly, generate some thumbnails.

```php
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

	$thumb1 = $image->thumbnail(100)->src();
	$thumb2 = $image->thumbnail(200)->addText($text)->src();
	$thumb3 = $image->thumbnail(400)->src();
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

## Filters

#### Using all the filters with the factory

You can use filters with a common syntax.
The factory, use the three types of filters :
+ FILTER_PRESET
+ FILTER_LOOKUPTABLE
+ FILTER_CONVOLUTION

You ca use this way to call, preset/convolution/lookuptable filters like this :

```php
// Preset filters
$src1 = Filter::negate()->process((new Image())->load($stream))->src();

// Convolution filters
$src2 = Filter::emboss()->process((new Image())->load($stream))->src();

// LookupTable filters
$src3 = Filter::thresholding()->process((new Image())->load($stream))->src();
```

#### Using the preset filter

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

#### How to create and apply a preset filter

```php
(new PresetFilter())->create(PresetFunctions::negate())->process((new Image())->load($stream))->show();
```

#### Using the convolution filter

You can use preseted convolution or your own convolution filters.

#### How to use a preseted convolution

```php
(new ConvolutionFilter())->create(ConvolutionFunctions::CONVOLUTION_GAUSSIAN())->process((new Image())->load($stream))->show();
```

#### How to use your own convolution

```php
$matrix = [
-1, 7, -1,
0, 0, 0,
1, 7, 1
];

$convolution = (new Convolution())->create($matrix);;
$dataSrc = (new ConvolutionFilter())->create($convolution)->process((new Image())->load($stream))->src();
```

#### Using the lookuptable filter

You can use preseted lookuptable or your own lookuptable filters.

#### How to use a preseted lookuptable

```php
$closure = \Closure::fromCallable([new LookupTableFunctions(), 'LightnessGray']),
(new LookUpTableFilter())->create((new LookUpTable())->create($closure))->process((new Image())->load($stream))->src();
```

#### To create a new lookuptable filter, you must create a callback method like this :

```php
function personnal($rgb)
{
$r = ($rgb['red'] > 128) ? 255 : 128;
$g = ($rgb['green'] > 128) ? 255 : 128;
$b = ($rgb['blue'] > 128) ? 255 : 128;
return [$r, $g, $b];
}

$closure = \Closure::fromCallable('personnal');
$lut = (new LookUpTableFilter())->create((new LookUpTable())->create($closure))->process((new Image())->load($stream))->src();
```

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

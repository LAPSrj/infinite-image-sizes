# Infinite Image Sizes

This is a simple WordPress plugin that alows theme developers to use dynamic image sizes in their themes. With this plugin, when you set a specific image size, instead of WordPress returning the image with the closest size it will return an image with the exact size.

This plugin is useful if you need few images in specific sizes, so instead of creating multiple image sizes that will bloat your upload folder you can create the sizes as you need them. Images are resized on page rendering, being saved on file after that. If the plugin is disabled the default WordPress behaviour will come back.

## How to use

When specifying the image size, use an array with the size instead of a size name. For example. If your code currently looks like this:

````
get_the_post_thumbnail_url( null, 'post-thumbnail' );
````

You can make it like this:

````
get_the_post_thumbnail_url( null, array(550, 450) );
````

## Contributing
Contributions are welcome. The main goal is to make a plugin that won't break the site if it is unistalled.
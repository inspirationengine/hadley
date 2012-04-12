=== jqDock Post Thumbs ===

Contributors: sscovil
Tags: jqDock, image, thumbnail, jquery, mac, apple, menu, dock
Requires at least: 3.2.1
Tested up to: 3.2.1
Stable tag: 2.0

This plugin allows you to create a Mac-like Dock menu with post thumbnail links or an image gallery in any post or page, using a
simple shortcode.

== Description ==

The Dock - as anyone familiar with a Mac knows - is a set of icons that expand when rolled over with the cursor. This plugin
mimics that behavior with WordPress post thumbnails, creating a visually-stunning set of links to other blog posts on any post
or page. New in version 2.0, it can also be used to create an image gallery!

jqDock Post Thumbs can be used to display posts, pages, or custom post types, provided post thumbnails are enabled in the current
theme. It can also be used to display images attached to the current post, or by post ID.

**How To Use**

`[jqdpostthumbs]`

This shortcode will create a Dock with five random post thumbnail links.

**Control Number of Thumbnails**

`[jqdpostthumbs qty="10"]`

The `qty` option can be set to any number you like. Your page width will help you determine your maximum. As a point of reference,
a page that is 850px wide with no sidebar looks good at `qty="14"`.

**Show Custom Post Type**

`[jqdpostthumbs type="my-custom-post-type"]`

The `type` option can be set to `page`, or to the name of any custom post type.

**Hide Post Titles (Since 2.0)**

`[jqdpostthumbs notitle="true"]`

Prevent the title of the post from appearing over the thumbnail using this shortcode.

**Control Order of Posts (Since 2.0)**

`[jqdpostthumbs order="ASC" orderby="title"]`

Control the order in which post thumbnails are displayed using these options. The only valid choice for `order` is `ASC`;
default is `DESC`. For `orderby`, you can choose: `none`, `ID`, `author`, `title`, `date`, `modified`, `parent`, `comment_count`,
or `menu_order`; default is `rand`.

**Show Image Gallery (Since 2.0)**

`[jqdgallery]`

Show a random set of 5 image thumbnails attached to the current post, which link to the full size images.

**Control Number of Thumbnails**

`[jqdgallery qty="10"]`

Same as with post thumbnails, the `qty` option can be set to any number you like. Your page width will help you determine your
maximum. As a point of reference, a page that is 850px wide with no sidebar looks good at `qty="14"`.

**Show Images From Specific Post (Since 2.0)**

`[jqdgallery id="10"]`

Set the post ID to show images attached to a specific post/page. Defaults to the current post/page.

**Hide Image Titles (Since 2.0)**

`[jqdgallery notitle="true"]`

Same as with post thumbnails, prevent the title of the image from appearing over the thumbnail using this shortcode.

**Set Image Link Attributes (Since 2.0)**

`[jqdgallery target="blank" class="my-class" rel="my-rel"]`

This may be useful if you want to combine jqDock Image Gallery with a Lightbox plugin that requires a special `class` or `rel`.

**About This Plugin**

For more information about this plugin, visit: http://mynewsitepreview.com/jqdpostthumbs/

To see a live demo, visit: http://mynewsitepreview.com/jqdpostthumbs-wordpress-plugin-live-demo

**About jqDock**

jqDock, which powers this WordPress plugin, is an awesome jQuery plugin developed by Roger Barrett and inspired by Isaac Rocca's "iconDock" plugin.

Documentation for jqDock can be found at: http://www.wizzud.com/jqDock/

== Installation ==

1. Upload the entire folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Insert the shortcode `[jqdpostthumbs]` or `[jqdgallery]` in any post or page

== Frequently Asked Questions ==

= How do I style the jqDock? =

Add this code to your theme's `style.css` and edit as you see fit:

`.jqd_container {
	margin-top: 50px !important;
	margin-bottom: 50px !important;
	width: 100% !important;
}

.jqd_menu {
	position: relative !important;
	width: 100% !important;
}

.jqd_menu div.jqDockWrap {
	margin: 0 auto !important;
}

.jqd_menu div.jqDock {
	cursor: pointer !important;
}

.jqd_menu div.jqDock img {
	-webkit-box-shadow: 0px 2px 3px 1px #999 !important;
	-moz-box-shadow: 0px 2px 3px 1px #999 !important;
	box-shadow: 0px 2px 3px 1px #999 !important;
}

div.jqDockLabel {
	background-color: rgba(100, 100, 100, .6) !important;
	color: #fff !important;
	cursor: pointer !important;
	font-weight: bold !important;
	padding: 0 6px !important;
	white-space: nowrap !important;
}`

Do not change the `display` value for `.jqd_menu`, and be sure to keep the `!important` to override the default plugin styles.

= Can I change the behavior of the jqDock? =

Yes. All of the documentation for jqDock can be found here: http://www.wizzud.com/jqDock/

In order to change the jqDock settings for this plugin, you need to make a copy of this file:  `/scripts/jqDock.options.js`

Save your copy of the file as: `/scripts/jqDock.custom.js`

Then edit your copy as you see fit, and the plugin will use your settings instead.

== Screenshots ==

1. Thumbnail images expand like the Dock menu on a Mac!

== Changelog ==

= 2.0 =
* Added options to hide title of a post or image.
* Added option to control the order of post thumbnails.
* Added new shortcode to display image attachment thumbs as well as post thumbs.
* Added options to set image link attributes for gallery images.
* Fixed bug that prevented custom jqDock settings from loading correctly.

= 1.0 =
* First public release.
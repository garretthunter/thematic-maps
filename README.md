# Thematic Maps - A WordPress Plugin
A WordPress plugin that displays a thematic map designed to show a particular theme connected with a specific geographic area.

## Description
Defines a single [shortcode](https://codex.wordpress.org/Shortcode) that displays a [choropleth map](https://en.wikipedia.org/wiki/Choropleth_map) of the United States based on data saved in a [Ninja Forms form](https://ninjaforms.com).
The data lookup is hardcoded while I figure out the Ninja Forms data model or select another way to save / retrieve the data.

## Screenshot
![Choropleth of the United States](https://github.com/garretthunter/thematic-maps/blob/master/choropleth-sample.png)

## Installation
This section describes how to install the plugin and get it working.

1. Upload the thematic-maps directory to your /wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to your WordPress admin Dashboard and under Settings->General update the "Maps API Key" option with your [Google Maps API Key](https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings) from your Google Developer's console

## Use
Reverse engineer the Ninja Form form field you want to report out and update the query in (the file name).
Insert the shortcode \[thematic_maps\] into your post or page of choice.

## TO DO
1. Replace db hardcode with something better

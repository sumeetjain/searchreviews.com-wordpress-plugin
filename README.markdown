# SearchReviews.com Widget - WordPress Plugin
Upon enabling this plugin, the SearchReviews.com widget Javascript is included in your theme. Additionally, a meta-box is added the New/Edit Post and New/Edit Page screens. This meta-box takes a list of keywords for which to search for reviews on SearchReviews.com.

If keywords are entered into the meta-box, the SearchReviews.com widget will appear at the top of your post/page. Clicking the widget will show a modal window with the reviews. If no keywords are entered, the widget will not be shown for that post/page.

## Installation/Activation
[Download the plugin](https://github.com/sumeetjain/searchreviews.com-wordpress-plugin/zipball/master). Unzip the folder and move it into your WordPress site's plugins folder (/wp-content/plugins). This installs the plugin.

Activate the plugin from your site's plugins screen (/wp-admin/plugins.php):

![Activated Plugin](http://f.cl.ly/items/2Y0O1w291j1C2q2L2i0J/Screen%20shot%202011-05-22%20at%2012.28.19%20AM.png)

## Configuration
One optional setting should be configured before use of the plugin. If you have a Publisher ID (assigned by SearchReviews.com), enter it in the widget settings screen. This screen is available after you activate the plugin from the Settings menu:

![Settings](http://f.cl.ly/items/2i100f2Y0D1t352l0d2f/Screen%20shot%202011-05-22%20at%2012.31.50%20AM.png)

![Setting](http://f.cl.ly/items/0k0y2H0K263U3K292o2P/Screen%20shot%202011-05-22%20at%2012.35.17%20AM.png)

It's alright if you don't have a Publisher ID.

## Usage
Posts and pages now have a "SearchReviews.com Widget" meta-box. Just add keywords to this box to trigger the widget. Using the widget is optional - if you don't add keywords, the widget won't appear.

[![Keywords](http://f.cl.ly/items/0t253l2O2Y3v2y013i24/Screen%20shot%202011-05-22%20at%2012.37.37%20AM_600x338.shkl.png)](http://www.cl.ly/6xq3)

## TODO
This is very much under construction. It should work without issue right now, but the plugin would benefit from more customizability:

- Ability to change the text that's shown in the widget link
- Option to automatically pull keywords from post tags, categories, etc.
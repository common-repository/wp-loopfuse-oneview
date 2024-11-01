=== LoopFuse OneView ===
Contributors: loopfuse, kreativemart
Tags: LoopFuse, OneView, marketing automation, lead capture, page tracking
Requires at least: 2.2
Tested up to: 3.0.1
Stable tag: 2.2

Lets you integrate the LoopFuse OneView tracking script in to your Wordpress site

== Description ==

LoopFuse provides the only on-demand sales and marketing automation solution for web companies that uniquely brings sales and marketing together to transform entire organizations into sales machines. LoopFuse OneView offers marketing and sales departments a user-friendly way to fully automate lead information and analysis. This helps organizations to dramatically improve the performance of their pipeline and generate sales without the need to involve in-house IT staff.

The LoopFuse WordPress plugin allows you to quickly implement the tracking code needed to take full advantage of OneView. Simply enter your Customer ID in to the settings screen to enable the LoopFuse OneView tracking code on each page of your site.

== Installation ==

1. Upload the folder 'wp-loopfuse-oneview' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to 'Settings -> LoopFuse' to enter your Customer ID number and Save it.

Optional Forms Integration

1. Create a Form in OneView.
2. Add formID, form name, and action URL to the List of OnewView Forms
3. Create a form using the activated Contact Form 7 plugin.
4. Check the LoopFuse box at the bottom of a CF7 form and select a LoopFuse form to integrate in to CF7.

== Frequently Asked Questions ==
= Q. Does this plugin integrate forms as well? =
= A. We now offer integration with Contact Form 7 (version 2.4.4). By providing the formID, action URL, and form name to the LoopFuse plugin you can leverage the utility and power of CF7 to create forms that will send data to your OneView account. =

== Screenshots ==
1. Screenshot of the admin section
2. Adding LoopFuse form details
3. Attaching LoopFuse form to Contact Form 7

== Changelog ==

= 2.2 =
* Fixed form association issues
* Fixed CF7 native form functionality
* Modified how forms are submitted to OneView

= 2.0 =
* Major overhaul of plugin
* Added integration with Contact Form 7
* Modifies the default "action" URL of CF7 to submit data.
* Adds required OneView hidden fields for "formID" and "cid" to CF7 forms.

= 1.0 =
First release

== Upgrade notice ==

= 2.2 =
Requires Contact Form 7 plugin. Fixes numerous issues related to CF7 integration.